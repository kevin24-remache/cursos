<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\EventsModel;
use App\Models\PaymentsModel;
use App\Models\RegistrationsModel;
use CodeIgniter\I18n\Time;
use Dompdf\Dompdf;

class InscripcionController extends BaseController
{
    private function generarCodigoPagoUnico()
    {
        $paymentModel = new PaymentsModel();

        do {
            $codigoPago = rand(1000000, 9999999); // Genera un código de pago aleatorio de 7 dígitos
            $existingCode = $paymentModel->where('payment_cod', $codigoPago)->first();
        } while ($existingCode);

        return $codigoPago;
    }
    private function calcularFechaLimitePago($fechaInscripcion, $fechaEvento)
    {
        // Calcular la diferencia en días entre la fecha de inscripción y la fecha del evento
        $diasRestantes = $fechaInscripcion->diff($fechaEvento)->days;

        // Si la inscripción es el mismo día del evento
        if ($diasRestantes == 0) {
            return $fechaEvento;
        }

        // Si la diferencia es menor que 7 días, el intervalo será el número de días restantes
        if ($diasRestantes < 7) {
            $intervalo = new \DateInterval('P' . $diasRestantes . 'D');
        } else {
            $intervalo = new \DateInterval('P7D'); // Intervalo de 7 días
        }

        // Calcular la fecha límite de pago
        $fechaLimitePago = (clone $fechaInscripcion)->add($intervalo);

        // Comparar con la fecha del evento
        if ($fechaLimitePago > $fechaEvento) {
            $fechaLimitePago = $fechaEvento;
        }

        return $fechaLimitePago;
    }



    private function prepararDatosInscripcion($persona, $event, $catId)
    {
        return [
            'event_cod' => $event['id'],
            'cat_id' => $catId,
            'full_name_user' => $persona['nombres'] . ' ' . $persona['apellidos'],
            'ic' => $persona['cedula'],
            'address' => $persona['adress'],
            'phone' => $persona['telefono'],
            'email' => $persona['email'],
            'event_name' => $event['event_name'],
        ];
    }

    private function prepararDatosPago($codigoPago, $fechaLimitePago)
    {
        return [
            'payment_status' => 1,
            'payment_cod' => $codigoPago,
            'payment_time_limit' => $fechaLimitePago->format('Y-m-d H:i:s')
        ];
    }

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
            'adress' => $userData['user']['direccion'],
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
            // Guardar los datos del usuario en la sesión
            session()->set('persona', $persona);
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
        // Obtener los datos de la sesión
        $persona = session()->get('persona');
        if (!$persona) {
            return $this->response->setJSON(['error' => true, 'message' => 'Datos de usuario no encontrados en la sesión']);
        }

        // Obtener y validar los datos de la solicitud
        $data = $this->request->getJSON();
        if (!isset($data->eventoId) || !isset($data->catId)) {
            return $this->response->setJSON(['error' => true, 'message' => 'Datos incompletos']);
        }

        // Extraer los datos necesarios
        $eventoId = $data->eventoId;
        $catId = $data->catId;

        // Verificar si el evento existe
        $eventModel = new EventsModel();
        $event = $eventModel->getEventNameAndCategories($eventoId, $catId);
        if (!$event) {
            return $this->response->setJSON(['error' => true, 'message' => 'Evento no encontrado']);
        }

        // Generar un código de pago único
        $codigoPago = $this->generarCodigoPagoUnico();

        // Calcular la fecha límite de pago
        $fechaInscripcion = Time::now(); // Usar la hora actual del servidor
        $fechaEvento = new Time($event['event_date']);
        $fechaLimitePago = $this->calcularFechaLimitePago($fechaInscripcion, $fechaEvento);

        // Crear los datos para la inscripción y el pago
        $datosInscripcion = $this->prepararDatosInscripcion($persona, $event, $catId);
        $datosPayment = $this->prepararDatosPago($codigoPago, $fechaLimitePago);

        // Guardar los datos en la base de datos
        $db = \Config\Database::connect();
        $db->transStart();

        $registrationModel = new RegistrationsModel();
        $registration = $registrationModel->insert($datosInscripcion);

        $datosPayment['id_register'] = $registration;
        $paymentModel = new PaymentsModel();
        $payment = $paymentModel->insert($datosPayment);

        if (!$registration || !$payment) {
            $db->transRollback();
            return $this->response->setJSON(['error' => true, 'message' => 'No se pudo registrar la inscripción']);
        }

        // Intentar enviar el correo electrónico
        $emailEnviado = $this->send_email($persona, $codigoPago, $fechaLimitePago, $event);
        if ($emailEnviado) {
            $db->transComplete();
            session()->remove('persona');
            return $this->response->setJSON([
                'success' => true,
                'codigoPago' => $codigoPago,
                'payment_time_limit' => $fechaLimitePago->format('Y-m-d H:i:s')
            ]);
        } else {
            $db->transRollback();
            session()->remove('persona');
            return $this->response->setJSON(['error' => true, 'message' => 'No se pudo enviar el correo electrónico']);
        }
    }


    public function registrarUsuario()
    {
        $data = $this->request->getJSON();

        // Simular la lógica para registrar el usuario
        $success = true; // Simulamos una respuesta exitosa

        return $this->response->setJSON(['success' => $success]);
    }

    public function send_email($persona, $codigoPago, $fechaLimitePago, $event)
    {
        // Fecha de emisión del PDF
        $fechaEmision = Time::now()->toDateTimeString();
        $fechaLimitePagoFormateada = $fechaLimitePago->toDateString();
        // Obtener los datos
        $user = $persona['nombres'] . ' ' . $persona['apellidos'];
        $emailAddress = $persona['email'];
        $evento = $event['event_name'];
        $categoria = $event['category_name'];
        $precio = $event['cantidad_dinero'];


        // Cargar la vista y pasar los datos
        $html = view('client/codigo', [
            'user' => $user,
            'codigoPago' => $codigoPago,
            'fechaLimitePago' => $fechaLimitePagoFormateada,
            'fechaEmision' => $fechaEmision,
            'evento' => $evento,
            'categoria' => $categoria,
            'precio' => $precio
        ]);

        // Generar el PDF con dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfOutput = $dompdf->output();
        $pdfFilename = 'comprobante_pago.pdf';

        // Guardar temporalmente el PDF en el servidor
        $tempPdfPath = WRITEPATH . 'uploads/' . $pdfFilename;
        file_put_contents($tempPdfPath, $pdfOutput);

        // Configurar y enviar el correo electrónico
        $email = \Config\Services::email();
        $email->setFrom('inscripciones@test.com', 'TEST');
        $email->setTo($emailAddress);
        $email->setSubject('Código de pago');
        $email->setMessage('Tu código de pago está en el PDF adjunto.');
        $email->attach($tempPdfPath);

        // Intentar enviar el correo
        if ($email->send()) {
            // Eliminar el archivo temporal después de enviar el correo
            unlink($tempPdfPath);
            return true;
        } else {
            // Obtener cualquier error del correo
            $error = $email->printDebugger(['headers']);
            log_message('error', 'Error enviando correo: ' . $error);

            // Eliminar el archivo temporal en caso de error
            unlink($tempPdfPath);
            return false;
        }
    }

}
