<?php
namespace App\Controllers\Payments;

use PaymentStatus;
use App\Controllers\BaseController;
use App\Models\PaymentsModel;
use App\Models\PaymentMethodsModel;
use CodeIgniter\I18n\Time;
use App\Models\DepositsModel;

class DepositosController extends BaseController
{
    private function redirectView($validation = null, $flashMessages = null, $last_data = null, $uniqueCode = null, $last_action = null)
    {
        return redirect()->to('punto/pago/depositos')->
            with('flashValidation', isset($validation) ? $validation->getErrors() : null)->
            with('flashMessages', $flashMessages)->
            with('last_data', $last_data)->
            with('uniqueCode', $uniqueCode)->with('last_action', $last_action);
    }
    public function index()
    {
        $paymentModel = new PaymentsModel();
        $depositos = $paymentModel->getPaymentsWithDetailsAndDeposits();
        $flashValidation = session()->getFlashdata('flashValidation');
        $flashMessages = session()->getFlashdata('flashMessages');
        $last_data = session()->getFlashdata('last_data');
        $last_action = session()->getFlashdata('last_action');
        $data = [
            'depositos' => $depositos,
            'last_action' => $last_action,
            'last_data' => $last_data,
            'validation' => $flashValidation,
            'flashMessages' => $flashMessages
        ];
        return view('payments/depositos', $data);
    }
}