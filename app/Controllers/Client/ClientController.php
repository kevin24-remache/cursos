<?php
namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\EventsModel;

class ClientController extends BaseController
{
    public function index()
    {

        // Cargar el helper
        helper('date');

        // get flash data
        $flashValidation = session()->getFlashdata('flashValidation');
        $flashMessages = session()->getFlashdata('flashMessages');
        $last_data = session()->getFlashdata('last_data');
        $last_action = session()->getFlashdata('last_action');

        $eventModel = new EventsModel();
        $all_events = $eventModel->asObject()->findAll();

        // Formatear las fechas de los eventos
        foreach ($all_events as $event) {
            $event->formatted_event_date = format_event_date($event->event_date);
            $event->formatted_modality = $event->modality == 1 ? 'Presencial' : 'OTRO';
        }
        // print_r($all_events);
        $data = [
            'events' => $all_events,
            'last_action' => $last_action,
            'last_data' => $last_data,
            'validation' => $flashValidation,
            'flashMessages' => $flashMessages,
        ];
        return view('client/home', $data);
    }
}
