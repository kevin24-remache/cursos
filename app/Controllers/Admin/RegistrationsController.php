<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use PaymentStatus;
use App\Models\RegistrationsModel;
use App\Models\EventsModel;
use App\Models\CategoryModel;
use App\Models\PaymentMethodsModel;

class RegistrationsController extends BaseController
{
    public function index()
    {
        return view('admin/inscritos');
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
        $categories = $categoryModel->findAll();

        $paymentMethodsModel = new PaymentMethodsModel();
        $metodosPago = $paymentMethodsModel->findAll();

        $data = [
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


}