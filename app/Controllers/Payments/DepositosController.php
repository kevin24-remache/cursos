<?php
namespace App\Controllers\Payments;

use App\Controllers\BaseController;
use App\Models\RegistrationsModel;
use App\Models\PaymentsModel;
use App\Models\DepositsModel;

class DepositosController extends BaseController
{
    private function redirectView($validation = null, $flashMessages = null, $last_data = null, $last_action = null)
    {
        return redirect()->to('/')->
            with('flashValidation', isset($validation) ? $validation->getErrors() : null)->
            with('flashMessages', $flashMessages)->
            with('last_data', $last_data)->with('last_action', $last_action);
    }
    public function index()
    {
        $depositosModel = new DepositsModel();
        $depositos = $depositosModel->getPendingDepositsWithDetails();
        $flashValidation = session()->getFlashdata('flashValidation');
        $flashMessages = session()->getFlashdata('flashMessages');
        $last_data = session()->getFlashdata('last_data');
        $last_action = session()->getFlashdata('last_action');
        $data = [
            'depositos'=> $depositos,
            'last_action' => $last_action,
            'last_data' => $last_data,
            'validation' => $flashValidation,
            'flashMessages' => $flashMessages
        ];
        return view('payments/depositos', $data);
    }

}