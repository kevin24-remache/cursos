<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\EventsModel;
use App\Models\PaymentsModel;
use App\Models\RegistrationsModel;
use App\Services\ApiPrivadaService;
use CodeIgniter\I18n\Time;

class InscripcionController extends BaseController
{
    private $apiPrivadaService;

    public function __construct()
    {

        $this->apiPrivadaService = new ApiPrivadaService();
    }

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
            'full_name_user' => $persona['name'] . " " . $persona['surname'],
            'ic' => $persona['identification'],
            'address' => $persona['address'],
            'phone' => $persona['phone'],
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
        try {

            // Generar nuevo token CSRF al inicio
            $newCsrfToken = csrf_hash();

            // Obtener los datos JSON
            $data = $this->request->getJSON();

            // Validar si el cuerpo de la solicitud contiene el campo 'cedula'
            if (is_null($data) || !isset($data->cedula) || empty($data->cedula)) {
                return $this->response
                    ->setHeader('X-CSRF-TOKEN', $newCsrfToken)
                    ->setJSON([
                        'status' => 'validation',
                        'message' => 'Cédula o RUC requerido',
                        'code' => 400
                    ], 400);
            }

            $cedula = trim($data->cedula);
            $ipAddress = $this->request->getIPAddress();

            // Validar que la cédula sea numérica
            $validation = \Config\Services::validation();
            $validation->setRules([
                'cedula' => 'required|numeric'
            ]);

            // Ejecutar la validación y revisar si falló
            if (!$validation->run(['cedula' => $cedula])) {
                $errorMessage = $validation->getError('cedula');
                log_message('warning', "Validación fallida: Cédula no numérica ingresada desde IP: {$ipAddress}");

                return $this->response
                    ->setHeader('X-CSRF-TOKEN', $newCsrfToken)
                    ->setJSON([
                        'status' => 'validation',
                        'message' => $errorMessage,
                        'code' => 400
                    ], 400);
            }

            // Usar el servicio para obtener los datos del usuario si la cédula es válida
            $persona = $this->apiPrivadaService->getDataUser($cedula);

            // Si la persona existe y tiene éxito
            if ($persona && $persona['success'] && isset($persona['data'])) {
                $personaData = $persona['data'];

                // Verificar si el email está vacío o es inválido
                $email = $personaData['email'];
                $phone = $personaData['phone'];

                if ($email == '@' || !$email || !$phone) {
                    return $this->response
                        ->setHeader('X-CSRF-TOKEN', $newCsrfToken)
                        ->setJSON([
                            'status' => 'warning',
                            'message' => 'Usuario encontrado pero email vació',
                            'code' => 200,
                            'persona' => [
                                'id' => $personaData['identification'],
                                'nombres' => $personaData['name'],
                                'apellidos' => $personaData['surname'],
                                'email' => $email,
                                'phone' => $personaData['phone'],
                                'address' => $personaData['address'],
                                'gender' => $personaData['gender'],
                            ]
                        ], 200);
                }

                // Guardar los datos del usuario en la sesión para su uso posterior
                session()->set('persona', $personaData);

                helper('format_names');
                helper('email');

                $persona_formateada = formatear_nombre_apellido($personaData['name'], $personaData['surname']);

                return $this->response
                    ->setHeader('X-CSRF-TOKEN', $newCsrfToken)
                    ->setJSON([
                        'status' => 'success',
                        'message' => 'Usuario encontrado',
                        'code' => 200,
                        'persona' => [
                            'id' => $personaData['identification'],
                            'nombres' => $persona_formateada['nombres'],
                            'apellidos' => $persona_formateada['apellidos'],
                            'email' => mask_email($personaData['email']),
                        ]
                    ]);
            } else {
                return $this->response
                    ->setHeader('X-CSRF-TOKEN', $newCsrfToken)
                    ->setJSON([
                        'status' => 'error',
                        'message' => 'Usuario no encontrado',
                        'code' => 404
                    ], 404);
            }
        } catch (\Exception $e) {
            log_message('critical', "Error crítico en validarCedula: {$e->getMessage()}");

            return $this->response
                ->setHeader('X-CSRF-TOKEN', $newCsrfToken)
                ->setJSON([
                    'status' => 'error',
                    'message' => 'Ocurrió un error interno del servidor.',
                    'code' => 500
                ], 500);
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

        // Obtener los datos del usuario de la sesión (flashdata)
        $personaData = session('persona');

        // Si no hay datos de la persona en la sesión, devolver error
        if (!$personaData) {
            return $this->response->setJSON(['error' => true, 'message' => 'Usuario no encontrado']);
        }

        // Verificar si el evento existe
        $eventModel = new EventsModel();
        $event = $eventModel->getEventNameAndCategories($eventoId, $catId);
        if (!$event) {
            return $this->response->setJSON(['error' => true, 'message' => 'Evento no encontrado']);
        }

        // **Validar si ya está inscrito en el mismo evento y categoría**
        $registrationModel = new RegistrationsModel();
        $existingRegistration = $registrationModel->where('ic', $cedula)
            ->where('event_cod', $eventoId)
            ->where('cat_id', $catId)
            ->first();

        if ($existingRegistration) {
            return $this->response->setJSON(['error' => true, 'message' => 'Ya estás inscrito en esta categoría, realiza el pago de tu inscripción']);
        }

        // Generar código de pago y calcular fecha límite
        $codigoPago = $this->generarCodigoPagoUnico();
        $fechaInscripcion = Time::now();
        $fechaEvento = new Time($event['event_date']);
        $event_name = $event['event_name'];
        $fechaLimitePago = $this->calcularFechaLimitePago($fechaInscripcion, $fechaEvento);

        // Preparar datos para la inscripción y el pago
        $datosInscripcion = $this->prepararDatosInscripcion($personaData, $event, $catId);
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

            // Eliminar los datos de la persona de la sesión
            session()->remove('persona');
            return $this->response->setJSON(['error' => true, 'message' => 'No se pudo registrar la inscripción']);
        }

        // Enviar correo electrónico a la cola
        $emailData = [
            'to' => $personaData['email'],
            'subject' => 'Código de pago',
            'message' => 'Estimado ' . $personaData['name'] . " " . $personaData['surname'] . ', los detalles de su solicitud se encuentran en el documento adjunto. Su código de pago es: ' . $codigoPago,
            'htmlContent' => view('client/codigo', [
                'user' => $personaData['name'] . " " . $personaData['surname'],
                'codigoPago' => $codigoPago,
                'fechaLimitePago' => $fechaLimitePago->toDateString(),
                'fechaEmision' => Time::now()->toDateTimeString(),
                'evento' => $event['event_name'],
                'categoria' => $event['category_name'],
                'precio' => $event['cantidad_dinero'],
            ]),
            'pdfFilename' => 'comprobante_registro.pdf',
            'emailType' => 'send_email_registro'
        ];

        // Añadir el trabajo a la cola
        $jobId = service('queue')->push('emails', 'email', $emailData);

        if ($jobId) {

            // Eliminar los datos de la persona de la sesión
            session()->remove('persona');
            $db->transComplete();
            helper('email');
            $email = mask_email($personaData['email']);
            return $this->response->setJSON([
                'success' => true,
                'codigoPago' => $codigoPago,
                'eventName' => $event_name,
                'email' => $email,
                'payment_time_limit' => $fechaLimitePago->format('Y-m-d H:i:s'),
                'job_id' => $jobId,
            ]);
        } else {

            // Eliminar los datos de la persona de la sesión
            session()->remove('persona');
            $db->transRollback();
            return $this->response->setJSON(['error' => true, 'message' => 'No se pudo añadir el email a la cola']);
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
            try {

                // Preparar los datos para la API
                $dataApi = [
                    'name' => $data->nombres,
                    'surname' => $data->apellidos,
                    'full_name' => $data->nombres . ' ' . $data->apellidos,
                    'email' => $data->email,
                    'phone' => $data->telefono,
                    'mobile' => null,
                    'address' => $data->direccion,
                    'city' => null,
                    'country' => null,
                    'observation' => null,
                    'identification' => $data->numeroCedula,
                    'type_identification' => null,
                    'profession' => null,
                    'date_of_birth' => null,
                    'place_of_birth' => null,
                    'gender' => $data->gender == 0 ? "Masculino" : "Femenino",
                    'nationality' => null,
                    'citizen_status' => null,
                    'civil_status' => null,
                ];

                // Llamada al servicio ApiPrivada
                $apiResponse = \App\Services\ApiPrivadaService::setDataUserCi($dataApi);

                if (!$apiResponse) {
                    return $this->response->setJSON(['error' => false, 'message' => 'Error al intentar registrarse']);
                }

                return $this->response->setJSON(['success' => true, 'message' => 'Usuario registrado correctamente.']);
            } catch (\Exception $e) {
                log_message('warning', $e->getMessage(), ['status' => $e->getMessage()]);
                return $this->response->setJSON(['error' => false, 'message' => 'Error al registrar el usuario']);
            }
        } else {
            return $this->response->setJSON(['error' => false, 'message' => $validation->getErrors()]);
        }
    }

    public function limpiarSesionPersona()
    {
        // Eliminar los datos de la persona de la sesión
        session()->remove('persona');

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Datos limpiados correctamente'
        ]);
    }

}