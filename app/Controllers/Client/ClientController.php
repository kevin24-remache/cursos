<?php
namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\EventsModel;
use App\Services\UserService;

class ClientController extends BaseController
{
    private $userService;
    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function index()
    {
        helper('date');

        $flashValidation = session()->getFlashdata('flashValidation');
        $flashMessages = session()->getFlashdata('flashMessages');
        $last_data = session()->getFlashdata('last_data');
        $last_action = session()->getFlashdata('last_action');

        $eventModel = new EventsModel();
        $active_events = $eventModel->getActiveAndCurrentEvents();

        // Formatear las fechas de los eventos
        foreach ($active_events as &$event) {
            $event['formatted_event_date'] = format_event_date($event['event_date']);
        }

        $data = [
            'events' => $active_events,
            'last_action' => $last_action,
            'last_data' => $last_data,
            'validation' => $flashValidation,
            'flashMessages' => $flashMessages,
        ];
        return view('client/home', $data);
    }

    public function obtenerUsuario()
    {
        $data = $this->request->getJSON();
        $cedula = trim($data->cedula);

        if (!$cedula) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Cédula no enviada'
            ]);
        }

        try {
            $persona = $this->userService->getUserData($cedula);

            if ($persona) {
                // Función para censurar datos
                $censurar = function ($str) {
                    if (!$str)
                        return null;
                    $len = strlen($str);
                    return substr($str, 0, 2) . str_repeat('*', $len - 4) . substr($str, -2);
                };

                // Crear un nuevo array con los datos requeridos y censurados
                $datosPersona = [
                    'name' => ($persona['name']),
                    'surname' => ($persona['surname']),
                    'full_name' => ($persona['full_name']),
                    'mobile' => ($persona['mobile']),
                    'email' => ($persona['email']),
                    'direccion' => ($persona['direccion'])
                ];

                return $this->response->setJSON([
                    'success' => true,
                    'persona' => $datosPersona
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


}
