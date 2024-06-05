<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\EventsModel;
use App\Models\RegistrationsModel;

class InscripcionController extends BaseController
{
    // Arreglo de personas
    private $personas = array(
        array(
            "id" => "1",
            "cedula" => "0250072444",
            "nombres" => "Juan Carlos",
            "apellidos" => "Sanchez Chimbo",
            "telefono" => "0999685745",
            "direccion" => "La prensa",
            "email" => "juan@example.com"
        ),
        array(
            "id" => "2",
            "cedula" => "0250072445",
            "nombres" => "Nombre1 Nombre2",
            "apellidos" => "Apellido1 Apellido2",
            "telefono" => "1234567891",
            "direccion" => "Dirección2",
            "email" => "correo2@example.com"
        ),
        array(
            "id" => "3",
            "cedula" => "0250072446",
            "nombres" => "Nombre3 nombre3",
            "apellidos" => "Apellido3",
            "telefono" => "1234567892",
            "direccion" => "Dirección3",
            "email" => "correo3@example.com"
        )
    );
    public function getPersonas()
    {
        return $this->personas;
    }
    public function validarCedula()
    {
        // Obtener el número de cédula del cuerpo JSON de la solicitud
        $numeroCedula = $this->request->getJSON()->numeroCedula;

        // Validar que el número de cédula sea numérico
        if (!is_numeric($numeroCedula)) {
            return $this->response->setJSON(['exists' => false, 'message' => 'El número de cédula debe ser numérico']);
        }
        // Buscar la persona que coincide con la cédula
        $personas = $this->getPersonas();

        $personaEncontrada = null;
        foreach ($personas as $persona) {
            if ($numeroCedula === $persona['cedula']) {
                $personaEncontrada = $persona;
                break;
            }
        }
        helper('format_names');
        // Preparar la respuesta JSON
        if ($personaEncontrada) {
            $persona_formateada = formatear_nombre_apellido($personaEncontrada['nombres'], $personaEncontrada['apellidos']);
            $respuesta = [
                'exists' => true,
                'persona' => [
                    'id' => $personaEncontrada['id'],
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
        $personas = $this->getPersonas();
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

        // Aquí deberías guardar los datos en tu base de datos
        $registrationModel = new RegistrationsModel();
        $registration = $registrationModel->insert($datosInscripcion);


        if (!$registration) {
            return $this->response->setJSON(['error' => true, 'message' => 'No se pudo registrar']);
        } else {
            // Devolver una respuesta JSON con el código de pago, los datos del usuario y la fecha límite de pago
            return $this->response->setJSON(['success' => true, 'codigoPago' => $codigoPago, 'payment_time_limit' => $fechaLimitePago->format('Y-m-d H:i:s')]);
        }
    }

    public function registrarUsuario()
    {
        $data = $this->request->getJSON();

        // Simular la lógica para registrar el usuario
        $success = true; // Simulamos una respuesta exitosa

        return $this->response->setJSON(['success' => $success]);
    }

    public function send_email(){
        $email= \Config\Services::email();
        $email->setFrom('inscripciones@test.com', 'TEST');
        $email->setTo('example@example.com');
        // $email->setCC('');
        $email->setSubject('Titulo');
        $cuerpo = '<h4>Tu código de pago es 001</h4>';
        $cuerpo.= '<p>Recuerda acercarte a realizar el pago antes de la fecha 25/06/2024</p>';
        $cuerpo.='<a href="">Ver comprobante de registro<a/>';

        $email->setMessage($cuerpo);

        $email->attach('assets/css/prueba.css','attachment','Comprobante.pdf');
        $email->setAltMessage('Recuerda acercarte a realizar el pago antes de la fecha 25/06/2024');
        if ($email->send()) {
            return '<h3>CORREO ENVIADO</h3>';
        }else {
            echo $email->printDebugger(['headers']);
        }
    }
}
