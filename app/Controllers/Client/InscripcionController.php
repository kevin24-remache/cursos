<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\EventsModel;
use App\Models\RegistrationsModel;

class InscripcionController extends BaseController
{
    public function validarCedula()
    {

        // Obtener los datos del usuario enviados en la solicitud POST
        $userData = $this->request->getJSON(true);
        $persona = [
            'cedula' => $userData['user']['cedula'],
            'nombres' => $userData['user']['nombres'],
            'apellidos' => $userData['user']['apellidos'],
            'email' => $userData['user']['email'],
            'telefono' => $userData['user']['telefono'],
        ];

        helper('format_names');
        // Preparar la respuesta JSON
        if ($persona) {
            $persona_formateada = formatear_nombre_apellido($persona['nombres'], $persona['apellidos']);
            $respuesta = [
                'exists' => true,
                'persona' => [
                    'id' => $persona['cedula'],
                    'nombres' => $persona_formateada['nombres'],
                    'apellidos' => $persona_formateada['apellidos']
                ]
            ];
            return $this->response->setJSON($respuesta);
        } else {
            return $this->response->setJSON(['exists' => false]);
        }
    }

    public function obtenerDatosEvento()
    {
        $eventoId = $this->request->getJSON()->eventoId;
        if (empty($eventoId)) {
            echo json_encode("error: invalid eventoId");
            return;
        }
        $eventoModel = new EventsModel();
        $evento = $eventoModel->getEventById($eventoId);


        return $this->response->setJSON($evento);
    }
    public function guardarInscripcion()
    {
        // Obtener los datos de la solicitud
        $data = $this->request->getJSON();

        // Validar los datos si es necesario
        if (!isset($data->id_user) || !isset($data->eventoId) || !isset($data->catId)) {
            return $this->response->setJSON(['error' => true, 'message' => 'Datos incompletos']);
        }

        // Procesar cada dato individualmente
        $idUser = $data->id_user;
        $eventoId = $data->eventoId;
        $catId = $data->catId;

        // Verificar si el evento existe
        $eventModel = new EventsModel();
        $event = $eventModel->find($eventoId);

        if (!$event) {
            return $this->response->setJSON(['error' => true, 'message' => 'Evento no encontrado']);
        }
        $event_name = $event['event_name'];
        $fechaEvento = new \DateTime($event['event_date']);

        // Obtener los datos del usuario por su ID
        $user = null;
        $personas = [];
        foreach ($personas as $persona) {
            if ($idUser == $persona['id']) {
                $user = $persona;
                break;
            }
        }
        // Validar si se encontró al usuario
        if (!$user) {
            return $this->response->setJSON(['error' => true, 'message' => 'Usuario no encontrado']);
        }

        // Simular el guardado de la inscripción y generar un código de pago aleatorio
        $codigoPago = rand(1000000, 9999999); // Genera un código de pago aleatorio de 7 dígitos

        // Calcular la fecha límite de pago (por ejemplo, 7 días desde la fecha de inscripción)
        $fechaInscripcion = new \DateTime(); // Fecha actual
        $intervalo = new \DateInterval('P7D'); // Intervalo de 7 días
        $fechaLimitePago = (clone $fechaInscripcion)->add($intervalo);

        // Comparar con la fecha del evento
        if ($fechaLimitePago > $fechaEvento) {
            $fechaLimitePago = $fechaEvento;
        }

        // Crear el arreglo de datos para el modelo
        $datosInscripcion = [
            'user_id' => $idUser,
            'event_cod' => $eventoId,
            'cat_id' => $catId,
            'full_name_user' => $user['nombres'] . " " . $user['apellidos'],
            'ic' => $user['cedula'],
            'address' => $user['direccion'],
            'phone' => $user['telefono'],
            'email' => $user['email'],
            'event_name' => $event_name,
            'payment_cod' => $codigoPago,
            'payment_time_limit' => $fechaLimitePago->format('Y-m-d H:i:s'), // Añadir la fecha límite de pago
        ];

        $db = \Config\Database::connect();
        $db->transStart(); // Iniciar la transacción

        // Guardar los datos en la base de datos
        $registrationModel = new RegistrationsModel();
        $registration = $registrationModel->insert($datosInscripcion);

        if ($registration) {
            // Intentar enviar el correo electrónico
            $emailEnviado = $this->send_email($user['email'], $codigoPago, $fechaLimitePago->format('Y-m-d'), $user['nombres'] . " " . $user['apellidos']);

            if ($emailEnviado) {
                // Confirmar la transacción si el correo se envió correctamente
                $db->transComplete();

                // Devolver una respuesta JSON con el código de pago, los datos del usuario y la fecha límite de pago
                return $this->response->setJSON(['success' => true, 'codigoPago' => $codigoPago, 'payment_time_limit' => $fechaLimitePago->format('Y-m-d H:i:s')]);
            } else {
                // Hacer rollback si el correo no se pudo enviar
                $db->transRollback();
                return $this->response->setJSON(['error' => true, 'message' => 'No se pudo enviar el correo electrónico']);
            }
        } else {
            // Hacer rollback si la inscripción no se pudo guardar
            $db->transRollback();
            return $this->response->setJSON(['error' => true, 'message' => 'No se pudo registrar']);
        }
    }


    public function registrarUsuario()
    {
        $data = $this->request->getJSON();

        // Simular la lógica para registrar el usuario
        $success = true; // Simulamos una respuesta exitosa

        return $this->response->setJSON(['success' => $success]);
    }

    public function send_email($emailAddress, $codigoPago, $fechaLimitePago, $user)
    {
        $email = \Config\Services::email();
        $email->setFrom('inscripciones@test.com', 'TEST');
        $email->setTo($emailAddress);
        // $email->setCC('');
        $email->setSubject('Código de pago');
        $cuerpo = "<h5>Usuario {$user}";
        $cuerpo .= "<h4>Tu código de pago es {$codigoPago}</h4>";
        $cuerpo .= "<p>Recuerda acercarte a realizar el pago antes de la fecha {$fechaLimitePago}</p>";
        // $cuerpo .= '<a href="">Ver comprobante de registro<a/>';

        $email->setMessage($cuerpo);

        // $email->attach('assets/css/styles.css', 'attachment', 'Comprobante.pdf');
        $email->setAltMessage("Tu código de pago es {$codigoPago}");
        if ($email->send()) {
            return true;
        } else {
            // log_message('error', $email->printDebugger(['headers']));
            return false;
        }
    }
}
