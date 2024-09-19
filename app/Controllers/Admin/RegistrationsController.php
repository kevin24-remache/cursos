<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PaymentsModel;
use PaymentStatus;
use App\Models\RegistrationsModel;
use App\Models\EventsModel;
use App\Models\CategoryModel;
use App\Models\PaymentMethodsModel;
use ModulosAdmin;

class RegistrationsController extends BaseController
{

    private $paymentsModel;

    public function __construct()
    {
        $this->paymentsModel = new PaymentsModel();
    }

    private function redirectView($validation=null, $flashMessages=null, $last_data=null, $last_action=null, $id_evento=null)
    {
        return redirect()->to('admin/event/inscritos/' .$id_evento)->
        with('flashValidation', isset($validation) ? $validation->getErrors() : null)->
        with('flashMessages', $flashMessages)->
        with('last_data', $last_data)->
        with('last_action',$last_action);
    }

    public function inscritos($eventId)
    {
        $registrationsModel = new RegistrationsModel();
        $status = $this->request->getPost('status');
        $category = $this->request->getPost('category');
        $metodoPago = $this->request->getPost('metodoPago');

        $fechaRegistro = $this->request->getPost('fechaRegistro'); // Obtener la fecha de registro
        // Pasar la fecha al modelo para filtrar los resultados
        $inscriptions = $registrationsModel->getInscriptionsByEventWithFilters($eventId, $status, $category, $metodoPago, $fechaRegistro);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'data' => $inscriptions
            ]);
        }

        $eventModel = new EventsModel();
        $event = $eventModel->find($eventId);

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getCategoriesByEventId($eventId);

        $paymentMethodsModel = new PaymentMethodsModel();
        $metodosPago = $paymentMethodsModel->findAll();


        // get flash data
        $flashValidation = session()->getFlashdata('flashValidation');
        $flashMessages = session()->getFlashdata('flashMessages');
        $last_data = session()->getFlashdata('last_data');
        $last_action = session()->getFlashdata('last_action');

        $data = [
            'last_action' => $last_action,
            'last_data' => $last_data,
            'validation' => $flashValidation,
            'flashMessages' => $flashMessages,
            'inscriptions' => $inscriptions,
            'event' => $event,
            'paymentStatuses' => [
                PaymentStatus::Pendiente,
                PaymentStatus::Completado,
                PaymentStatus::Fallido,
                PaymentStatus::EnProceso,
                PaymentStatus::Incompleto,
                PaymentStatus::Rechazado
            ],
            'selectedStatus' => $status,
            'selectedCategory' => $category,
            'selectedMetodo' => $metodoPago,
            'selectedDate' => $fechaRegistro,
            'categories' => $categories,
            'metodosPago' => $metodosPago
        ];

        return view('admin/events/event_inscritos', $data);
    }

    public function update()
    {
        $id_inscrito = $this->request->getPost('id_inscrito');
        $id_event = $this->request->getPost('id');
        $full_name_user = $this->request->getPost('full_name_user');
        $ic = $this->request->getPost('ic');
        $address = $this->request->getPost('address');
        $phone = $this->request->getPost('phone');
        $email = $this->request->getPost('email');

        $data = [
            // 'id_category' => $id_category,
            'full_name_user' => trim($full_name_user),
            'ic' => trim($ic),
            'address' => trim($address),
            'phone' => trim($phone),
            'email' => trim($email),
        ];

        try {
            $validation = \Config\Services::validation();
            $validation->setRules(
                [
                    'full_name_user' => [
                        'label' => 'Nombres del usuario inscrito',
                        'rules' => 'required|min_length[3]',
                    ],
                    'ic' => [
                        'label' => 'Cédula/Ruc',
                        'rules' => 'required|numeric',
                    ],
                    'phone' => [
                        'label' => 'Teléfono',
                        'rules' => 'required|numeric',
                    ],
                    'email' => [
                        'label' => 'Correo electrónico',
                        'rules' => 'required|valid_email',
                    ]
                ]
            );

            if ($validation->run($data)) {
                $paymentCompleted = $this->paymentsModel->isPaymentCompletedByRegistrationId($id_inscrito);
                if ($paymentCompleted) {
                    return $this->redirectView(null, [['La inscripción no se puede actualizar por que ya se encuentra aprobada', 'error']], null,null, $id_event);
                }

                // Actualizar los datos en la DB
                $registrationsModel = new RegistrationsModel();
                // unset($data['id_category']);
                $update_registration = $registrationsModel->updateRegistrations($ic,$full_name_user,$data);

                if (!$update_registration) {
                    return $this->redirectView(null, [['No fue posible actualizar los datos del usuario inscrito', 'warning']], $data, 'update', $id_event);
                } else {
                    log_message("warning",$update_registration);
                    return $this->redirectView(null, [['Datos del usuario actualizado exitosamente', 'success']], null,null,$id_event);
                }
            } else {
                return $this->redirectView($validation, [['Error en los datos enviados', 'warning']], $data, 'update',$id_event);
            }
        } catch (\Exception $e) {
            return $this->redirectView(null, [['No se pudo actualizar los datos del usuario', 'danger']], null, null, $id_event);
        }
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $id_event = $this->request->getPost('id_event');

        $data = [
            'id' => $id,
            'id_event' => $id_event,
        ];

        try {
            $validation = \Config\Services::validation();
            $validation->setRules(
                [
                    'id' => [
                        'label' => 'Id',
                        'rules' => 'required|numeric',
                    ],
                    'id_event' => [
                        'label' => 'Nombres del usuario inscrito',
                        'rules' => 'required|numeric',
                    ],
                ]
            );

            if ($validation->run($data)) {

                $paymentCompleted = $this->paymentsModel->isPaymentCompletedByRegistrationId($id);
                if ($paymentCompleted) {
                    return $this->redirectView(null, [['La inscripción no se puede eliminar por que ya se encuentra aprobada', 'error']], null,null, $id_event);
                }
                // Actualizar los datos en la DB
                $registrationsModel = new RegistrationsModel();
                unset($data['id_event']);
                $delete_registration = $registrationsModel->delete($id);

                if (!$delete_registration) {
                    return $this->redirectView(null, [['No fue posible eliminar la inscripción', 'warning']], $data, 'update', $id_event);
                } else {
                    return $this->redirectView(null, [['Inscripción eliminada exitosamente', 'success']], null,null,$id_event);
                }
            } else {
                return $this->redirectView($validation, [['Error en los datos enviados', 'warning']], $data, 'update',$id_event);
            }
        } catch (\Exception $e) {
            log_message("warning",$e->getMessage());
            return $this->redirectView(null, [['No se pudo eliminar el registro', 'danger']], null, null, $id_event);
        }
    }

    public function allInscritos()
    {
        // get flash data
        $flashValidation = session()->getFlashdata('flashValidation');
        $flashMessages = session()->getFlashdata('flashMessages');
        $last_data = session()->getFlashdata('last_data');
        $last_action = session()->getFlashdata('last_action');

        $registrationsModel = new RegistrationsModel();

        $registrations = $registrationsModel->getAllInscriptionsWithPaymentMethodAndStatus();
        $modulo = ModulosAdmin::INSCRIPCIONES;
        $data = [
            'registrations' => $registrations,
            'last_action' => $last_action,
            'last_data' => $last_data,
            'validation' => $flashValidation,
            'flashMessages' => $flashMessages,
            'modulo' => $modulo
        ];

        return view('admin/registrations/index', $data);
    }

    public function trash()
    {
        // get flash data
        $flashValidation = session()->getFlashdata('flashValidation');
        $flashMessages = session()->getFlashdata('flashMessages');
        $last_data = session()->getFlashdata('last_data');
        $last_action = session()->getFlashdata('last_action');

        $registrationsModel = new RegistrationsModel();

        $registrations = $registrationsModel->onlyDeleted()->findAll();
        $modulo = ModulosAdmin::INSCRIPCIONES_ELIMINADAS;
        $data = [
            'registrations' => $registrations,
            'last_action' => $last_action,
            'last_data' => $last_data,
            'validation' => $flashValidation,
            'flashMessages' => $flashMessages,
            'modulo' => $modulo
        ];

        return view('admin/registrations/trash/trash', $data);
    }

    private function redirectTrashView($validation = null, $flashMessages = null, $last_data = null,)
    {

        return redirect()->to('admin/inscritos/trash')->
            with('flashValidation', isset($validation) ? $validation->getErrors() : null)->
            with('flashMessages', $flashMessages)->
            with('last_data', $last_data);
    }

    public function restore()
    {
        try {
            $inscrito_id = $this->request->getPost('id');
            $registrationsModel = new RegistrationsModel();

            $client = $registrationsModel->onlyDeleted()->find($inscrito_id);
            if (isset($client)) {
                $registrationsModel->withDeleted()->set(['deleted_at' => null])->update($inscrito_id);
                return $this->redirectTrashView(null, [['Inscripción restaurada correctamente', 'success']]);
            }
            else {
                return $this->redirectTrashView(null,[['No existe la inscripción buscada', 'warning']]);
            }
        } catch (\Exception $e) {
            return $this->redirectTrashView(null,[['No fue posible restaurar la inscripción', 'danger']]);
        }
    }
}