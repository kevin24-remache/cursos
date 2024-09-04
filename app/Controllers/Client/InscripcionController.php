<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\EventsModel;
use App\Models\PaymentsModel;
use App\Models\RegistrationsModel;
use CodeIgniter\I18n\Time;

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
            'address' => $persona['direccion'],
            'phone' => $persona['telefono'],
            'email' => $persona['email'],
            'event_name' => $event['event_name'],
            'monto_category' => $event['cantidad_dinero'],
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
        // Obtener los datos JSON
        $data = $this->request->getJSON();

        // Verificar si $data es null (si el cuerpo de la solicitud no es JSON o está vacío)
        if (is_null($data) || !isset($data->cedula) || empty($data->cedula)) {
            return $this->response->setJSON(['error' => 'Cédula requerida']);
        }

        $cedula = trim($data->cedula);

        $firebase = service('firebase');
        $firestore = $firebase->firestore;
        $collection = $firestore->database()->collection('Usuarios');
        $documentReference = $collection->document($cedula);
        $snapshot = $documentReference->snapshot();

        if ($snapshot->exists()) {
            $persona = $snapshot->data();

            helper('format_names');
            helper('email');

            $persona_formateada = formatear_nombre_apellido($persona['nombres'], $persona['apellidos']);
            $respuesta = [
                'exists' => true,
                'persona' => [
                    'id' => $persona['cedula'],
                    'nombres' => $persona_formateada['nombres'],
                    'apellidos' => $persona_formateada['apellidos'],
                    'email' => mask_email($persona['email']),
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
        $data = $this->request->getJSON();
        if (!isset($data->cedula) || !isset($data->eventoId) || !isset($data->catId)) {
            return $this->response->setJSON(['error' => true, 'message' => 'Datos incompletos']);
        }

        $cedula = $data->cedula;
        $eventoId = $data->eventoId;
        $catId = $data->catId;

        // Obtener datos del usuario de Firebase
        $firebase = service('firebase');
        $firestore = $firebase->firestore;
        $collection = $firestore->database()->collection('Usuarios');
        $documentReference = $collection->document($cedula);
        $snapshot = $documentReference->snapshot();

        if (!$snapshot->exists()) {
            return $this->response->setJSON(['error' => true, 'message' => 'Usuario no encontrado']);
        }

        $persona = $snapshot->data();

        // Verificar si el evento existe
        $eventModel = new EventsModel();
        $event = $eventModel->getEventNameAndCategories($eventoId, $catId);
        if (!$event) {
            return $this->response->setJSON(['error' => true, 'message' => 'Evento no encontrado']);
        }

        // Generar código de pago y calcular fecha límite
        $codigoPago = $this->generarCodigoPagoUnico();
        $fechaInscripcion = Time::now();
        $fechaEvento = new Time($event['event_date']);
        $event_name = $event['event_name'];
        $fechaLimitePago = $this->calcularFechaLimitePago($fechaInscripcion, $fechaEvento);

        // Preparar datos para la inscripción y el pago
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

        // Enviar correo electrónico
        $emailEnviado = $this->send_email($persona, $codigoPago, $fechaLimitePago, $event);
        if ($emailEnviado === 'success') {
            $db->transComplete();
            helper('email');
            $email = mask_email($persona['email']);
            return $this->response->setJSON([
                'success' => true,
                'codigoPago' => $codigoPago,
                'eventName' => $event_name,
                'email' => $email,
                'payment_time_limit' => $fechaLimitePago->format('Y-m-d H:i:s')
            ]);
        } else {
            $db->transRollback();
            return $this->response->setJSON(['error' => true, 'message' => 'No se pudo enviar el correo electrónico']);
        }
    }

    public function registrarUsuario()
    {
        $data = $this->request->getJSON();

        // Aplicar trim a todos los campos relevantes
        $data->numeroCedula = trim($data->numeroCedula);
        $data->nombres = trim($data->nombres);
        $data->apellidos = trim($data->apellidos);
        $data->telefono = trim($data->telefono);
        $data->email = trim($data->email);
        $data->direccion = trim($data->direccion);

        $validation = \Config\Services::validation();
        $validation->setRules(
            [
                'numeroCedula' => [
                    'label' => 'Número de Cédula',
                    'rules' => 'required|numeric|min_length[10]|max_length[10]',
                ],
                'nombres' => [
                    'label' => 'Nombres',
                    'rules' => 'required|min_length[3]',
                ],
                'apellidos' => [
                    'label' => 'Apellidos',
                    'rules' => 'required|min_length[3]',
                ],
                'telefono' => [
                    'label' => 'Número de teléfono o celular',
                    'rules' => 'required|numeric|min_length[10]',
                ],
                'email' => [
                    'label' => 'Correo electrónico',
                    'rules' => 'required|valid_email',
                ],
                'direccion' => [
                    'label' => 'Dirección',
                    'rules' => 'required|min_length[5]',
                ],
            ]
        );

        if ($validation->run((array) $data)) {
            // Datos válidos, proceder con la verificación en Firebase
            try {
                $firebase = service('firebase');
                $firestore = $firebase->firestore;
                $collection = $firestore->database()->collection('Usuarios');

                // Verificar si la cédula ya existe
                $cedulaSnapshot = $collection->document($data->numeroCedula)->snapshot();
                if ($cedulaSnapshot->exists()) {
                    return $this->response->setJSON(['success' => false, 'message' => 'La cédula ya está registrada.']);
                }

                // Verificar si el email ya existe
                $emailQuery = $collection->where('email', '=', $data->email)->documents();
                if (!$emailQuery->isEmpty()) {
                    return $this->response->setJSON(['success' => false, 'message' => 'El correo electrónico ya está registrado.']);
                }

                // Asignar el valor de numeroCedula a cedula
                $data->cedula = $data->numeroCedula;
                unset($data->numeroCedula);

                // Añadir campo timestamp como Firebase Timestamp
                $currentTime = new \DateTime();
                $timestamp = $currentTime->getTimestamp();
                $data->timestamp = new \Google\Cloud\Core\Timestamp(new \DateTime("@$timestamp"));

                // Si ambas verificaciones pasan, registrar el usuario en Firebase
                $documentReference = $collection->document($data->cedula);
                $documentReference->set((array) $data);

                return $this->response->setJSON(['success' => true, 'message' => 'Usuario registrado correctamente.']);
            } catch (\Exception $e) {
                return $this->response->setJSON(['success' => false, 'message' => 'Error al registrar el usuario en Firebase.']);
            }
        } else {
            return $this->response->setJSON(['success' => false, 'message' => $validation->getErrors()]);
        }
    }

    public function send_email($persona, $codigoPago, $fechaLimitePago, $event)
    {
        helper('email');

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
        $htmlContent = view('client/codigo', [
            'user' => $user,
            'codigoPago' => $codigoPago,
            'fechaLimitePago' => $fechaLimitePagoFormateada,
            'fechaEmision' => $fechaEmision,
            'evento' => $evento,
            'categoria' => $categoria,
            'precio' => $precio
        ]);

        // Mensaje del email
        $emailMessage = 'Estimado ' . $user . ' los detalles de su solicitud se encuentran en el documento adjunto. Su codigo de pago es: ' . $codigoPago;

        // Usar la función del helper para enviar el email
        return send_email_with_pdf($emailAddress, 'Código de pago', $emailMessage, $htmlContent, 'comprobante_registro.pdf');
    }

}