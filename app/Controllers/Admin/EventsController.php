<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\EventCategoryModel;
use App\Models\EventsModel;
use ModulosAdmin;

class EventsController extends BaseController
{
    private function redirectView($validation = null, $flashMessages = null, $last_data = null)
    {
        return redirect()->to('admin/event/new')->
            with('flashValidation', isset($validation) ? $validation->getErrors() : null)->
            with('flashMessages', $flashMessages)->
            with('last_data', $last_data);
    }

    public function index()
    {
        // get flash data
        $flashValidation = session()->getFlashdata('flashValidation');
        $flashMessages = session()->getFlashdata('flashMessages');
        $last_data = session()->getFlashdata('last_data');
        $last_action = session()->getFlashdata('last_action');

        $eventModel = new EventsModel();
        $all_events = $eventModel->findAll();

        $modulo = ModulosAdmin::EVENTS_LIST;
        $data = [
            'events' => $all_events,
            'last_action' => $last_action,
            'last_data' => $last_data,
            'validation' => $flashValidation,
            'flashMessages' => $flashMessages,
            'modulo' => $modulo,
        ];
        return view('admin/event', $data);
    }
    public function add()
    {
        $event_name = $this->request->getPost('event_name');
        $short_description = $this->request->getPost('short_description');
        $event_date = $this->request->getPost('event_date');
        $address = $this->request->getPost('address');
        $modality = $this->request->getPost('modality');
        $registrations_start_date = $this->request->getPost('registrations_start_date');
        $registrations_end_date = $this->request->getPost('registrations_end_date');
        $image = $this->request->getFile('image');
        $categories = $this->request->getPost('id_cat');

        $data = [
            'event_name' => trim($event_name),
            'short_description' => trim($short_description),
            'event_date' => $event_date,
            'address' => trim($address),
            'modality' => $modality,
            'registrations_start_date' => $registrations_start_date,
            'registrations_end_date' => $registrations_end_date,
            'categories' => $categories,
        ];

        try {
            $validation = \Config\Services::validation();
            $validation->setRules(
                [
                    'event_name' => [
                        'label' => 'Nombre del evento',
                        'rules' => 'required|min_length[3]|is_unique[events.event_name]',
                    ],
                    'short_description' => [
                        'label' => 'Descripción corta',
                        'rules' => 'min_length[5]|permit_empty',
                    ],
                    'event_date' => [
                        'label' => 'Fecha del evento',
                        'rules' => 'required|valid_date',
                    ],
                    'address' => [
                        'label' => 'Dirección',
                        'rules' => 'required',
                    ],
                    'modality' => [
                        'label' => 'Modalidad',
                        'rules' => 'required',
                    ],
                    'registrations_start_date' => [
                        'label' => 'Fecha de inicio de inscripciones',
                        'rules' => 'required|valid_date',
                    ],
                    'registrations_end_date' => [
                        'label' => 'Fecha de fin de inscripciones',
                        'rules' => 'required|valid_date',
                    ],
                    'image' => [
                        'label' => 'Imagen',
                        'rules' => 'uploaded[image]|is_image[image]|max_size[image,1024]',
                    ],
                    'categories' => [
                        'label' => 'Categorías del evento',
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Debe seleccionar al menos una categoría.'
                        ]
                    ]
                ]
            );

            if ($validation->run($data)) {
                // Iniciar la transacción
                $db = \Config\Database::connect();
                $db->transStart();

                unset($data['categories']);
                // Guardar los datos en la DB
                $eventsModel = new EventsModel;
                $new_event = $eventsModel->insert($data);

                if ($new_event) {
                    // Si la inserción fue exitosa, procesar la imagen y las categorías
                    if ($image->isValid() && !$image->hasMoved()) {
                        $newName = $image->getRandomName();
                        $ruta = ROOTPATH . 'public/assets/images/events/';
                        $image->move($ruta, $newName);
                        $data['image'] = 'assets/images/events/' . $newName;

                        // Actualizar la entrada en la tabla events con la ruta de la imagen
                        $eventsModel->update($new_event, ['image' => $data['image']]);
                    } else {
                        // Si hubo un error con la imagen, revertir la transacción
                        $db->transRollback();
                        return $this->redirectView($validation, [['Error en los datos enviados', 'warning']], $data);
                    }
                    // Guardar las categorías en la tabla de relación
                    $eventCategoryModel = new EventCategoryModel();
                    foreach ($categories as $category_id) {
                        $eventCategoryModel->insert([
                            'event_id' => $new_event,
                            'cat_id' => $category_id,
                        ]);
                    }

                    // Si todo fue bien, confirmar la transacción
                    $db->transComplete();

                    return $this->redirectView(null, [['Evento agregado exitosamente', 'success']], null);
                } else {
                    // Si hubo un error al insertar en la tabla events, revertir la transacción
                    $db->transRollback();
                    return $this->redirectView(null, [['No fue posible guardar el evento', 'warning']], $data);
                }
            } else {
                return $this->redirectView($validation, [['Error en los datos enviados', 'warning']], $data);
            }
        } catch (\Exception $e) {
            // Si ocurre alguna excepción, revertir la transacción
            $db->transRollback();
            return $this->redirectView(null, [['No se pudo registrar el evento', 'danger']]);
        }
    }

    public function new_event()
    {
        // get flash data
        $flashValidation = session()->getFlashdata('flashValidation');
        $flashMessages = session()->getFlashdata('flashMessages');
        $last_data = session()->getFlashdata('last_data');
        $last_action = session()->getFlashdata('last_action');

        $categoryModel = new CategoryModel();
        $all_category = $categoryModel->findAll();

        $modulo = ModulosAdmin::EVENTS_ADD;
        $data = [
            'categories' => $all_category,
            'last_action' => $last_action,
            'last_data' => $last_data,
            'validation' => $flashValidation,
            'flashMessages' => $flashMessages,
            'modulo' => $modulo,
        ];
        return view('admin/nuevo_evento', $data);
    }
}
