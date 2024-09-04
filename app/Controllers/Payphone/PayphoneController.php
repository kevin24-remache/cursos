<?php

namespace App\Controllers\Payphone;

use App\Controllers\BaseController;
use App\Services\PaymentAprobarService;
use App\Services\PayphoneService;
use App\Services\PayphoneConfirmService;
use App\Models\RegistrationsModel;
use App\Models\PaymentsModel;
use App\Models\PagoLineaModel;
use PaymentStatus;
use CodeIgniter\I18n\Time;

class PayphoneController extends BaseController
{

    private $payphoneService;
    private $PayphoneConfirmService;
    private $pagosEnLineaModel;
    private $paymentService;
    private $paymentsModel;
    private $registrationsModel;
    private $paymentApprovalService;

    private function redirectView($validation = null, $flashMessages = null, $last_data = null, $id = null, $clientTransactionId = null)
    {
        return redirect()->to("completado/$id/$clientTransactionId")->
            with('flashValidation', isset($validation) ? $validation->getErrors() : null)->
            with('flashMessages', $flashMessages)->
            with('last_data', $last_data);
    }

    public function __construct()
    {
        // Servicios
        $this->payphoneService = new PayphoneService();
        $this->PayphoneConfirmService = new PayphoneConfirmService();
        $this->paymentApprovalService = new PaymentAprobarService();

        // Modelos
        $this->pagosEnLineaModel = new PagoLineaModel();
        $this->paymentsModel = new paymentsModel();
        $this->registrationsModel = new RegistrationsModel();

    }
    private function generateTimestampId()
    {
        return date('YmdHis');
    }

    public function index()
    {
        $request = $this->request->getJSON();
        $depositoCedula = $request->cedula ?? null;
        $codigoPago = $request->codigoPago ?? null;

        if (!$depositoCedula || !$codigoPago) {
            return $this->response->setJSON(['error' => 'Datos incompletos'], 400);
        }

        try {
            $result = $this->registrationsModel->MountPayphone($depositoCedula, $codigoPago);

            if (!$result) {
                return $this->response->setJSON(['error' => 'No existen un registro con los datos enviados'], 404);
            }

            if ($result['payment_status'] == PaymentStatus::Completado) {
                return $this->response->setJSON(['error' => 'El pago de su inscripción ha sido recibido y registrado correctamente. No es necesario realizar otro pago'], 400);
            }

            if ($result['payment_status'] == PaymentStatus::EnProceso) {
                return $this->response->setJSON(['error' => 'El pago de tu inscripción se ha realizado mediante depósito bancario y está en proceso de verificación. Recibirás una confirmación una vez que el depósito sea validado.'], 400);
            }
            if ($result['payment_status'] != PaymentStatus::Pendiente) {
                return $this->response->setJSON(['error' => 'Una parte de tu pago se ha realizado con deposito El pago de tu inscripción se ha realizado mediante depósito bancario. Revisa tu correo donde se detalla la forma de realizar el pago'], 400);
            }

            // Calcular el monto total con comisión e IVA
            $payment_id = $result['payment_id'];
            $montoBase = $result['cantidad_dinero'];
            $por = 0.07;
            $iva = 1.15;

            $tot = ($montoBase * $por) * $iva;
            $total = round(($montoBase + $tot) * 100);

            $token = $this->payphoneService->getToken();
            $store = $this->payphoneService->getStore();

            return $this->response->setJSON([
                'success' => true,
                'data' => [
                    'token' => $token,
                    'store' => $store,
                    'amount' => $total,
                    'amountWithoutTax' => $total,
                    'amountWithTax' => 0,
                    'tax' => 0,
                    'service' => 0,
                    'tip' => 0,
                    'reference' => "Pago de inscripción",
                    'clientTransactionId' => $payment_id . $this->generateTimestampId()
                ]
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'data' => 'Ocurrió un error al generar el pago.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function respuesta()
    {
        $id = $this->request->getGet('id') ?? null;
        $clientTransactionId = $this->request->getGet('clientTransactionId') ?? null;

        if (!$id || !$clientTransactionId) {
            return view('client/errors/error_datos_incompletos');
        }

        $paymentId = substr($clientTransactionId, 0, 1);
        $payment = $this->paymentsModel->find($paymentId);

        if (!$payment) {
            return view('client/errors/error_pago_no_encontrado');
        }

        $result = $this->PayphoneConfirmService->confirmTransaction($id, $clientTransactionId);
        $transaction_status = $result['data']['transactionStatus'];
        $statusCode = $result['data']['statusCode'];

        if ($result['success'] && ($transaction_status == 'Approved' || $statusCode == 2)) {
            // Utilizamos el PaymentApprovalService para aprobar el pago
            $userId = null; // Asumimos que el ID del usuario está en la sesión o en el pago
            $approvalResult = $this->paymentApprovalService->approvePayment($paymentId, $userId);

            if ($approvalResult['success']) {
                // El pago se aprobó correctamente
                $data = [
                    'status_code' => $result['data']['statusCode'],
                    'payment_id' => $paymentId,
                    'transaction_status' => $result['data']['transactionStatus'],
                    'client_transaction_id' => $result['data']['clientTransactionId'],
                    'authorization_code' => $result['data']['authorizationCode'] ?? null,
                    'transaction_id' => $result['data']['transactionId'],
                    'email' => $result['data']['email'] ?? null,
                    'phone_number' => $result['data']['phoneNumber'] ?? null,
                    'document' => $result['data']['document'] ?? null,
                    'amount' => $result['data']['amount'],
                    'card_type' => $result['data']['cardType'] ?? null,
                    'card_brand' => $result['data']['cardBrand'] ?? null,
                    'message' => $result['data']['message'] ?? null,
                    'message_code' => $result['data']['messageCode'] ?? null,
                    'currency' => $result['data']['currency'],
                    'transaction_date' => $result['data']['date'],
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->pagosEnLineaModel->insert($data);

                return $this->redirectView(null, null, null, $id, $clientTransactionId);
            } else {
                // Hubo un error al aprobar el pago
                return view('client/errors/error_aprobacion_pago', ['message' => $approvalResult['message']]);
            }
        } else {
            return view('client/errors/error_pago_rechazado');
        }
    }

    public function completado($id, $clientTransactionId)
    {
        $paymentId = substr($clientTransactionId, 0, 1);
        $payment = $this->paymentsModel->find($paymentId);

        $result = $this->PayphoneConfirmService->confirmTransaction($id, $clientTransactionId);
        $transaction_status = $result['data']['transactionStatus'];
        $statusCode = $result['data']['statusCode'];

        if ($result['success'] && ($transaction_status == 'Approved' || $statusCode == 2)) {
            // Actualizar el estado del pago en la base de datos

            helper('email');
            $data = [
                'status_code' => $result['data']['statusCode'],
                'transaction_status' => payphone_status($result['data']['transactionStatus']),
                'client_transaction_id' => $result['data']['clientTransactionId'],
                'authorization_code' => $result['data']['authorizationCode'] ?? null,
                'transaction_id' => $result['data']['transactionId'],
                'email' => mask_email($result['data']['email']) ?? null,
                'phone_number' => mask_phone($result['data']['phoneNumber']) ?? null,
                'document' => $result['data']['document'] ?? null,
                'amount' => $result['data']['amount'],
                'card_type' => $result['data']['cardType'] ?? null,
                'cardBrand' => $result['data']['cardBrand'] ?? null,
                'message' => $result['data']['message'] ?? null,
                'message_code' => $result['data']['messageCode'] ?? null,
                'currency' => $result['data']['currency'],
                'transaction_date' => $result['data']['date'],
                'created_at' => date('Y-m-d H:i:s'),
                'store_name' => $result['data']['storeName'],
                'region_iso' => $result['data']['regionIso'],
                'transaction_type' => $result['data']['transactionType'],
                'reference' => $result['data']['reference'],
                'last_digits' => $result['data']['lastDigits'],
            ];
            $data['numAutorizacion'] = $payment;

            return view('client/completado', $data);
        } else {
            return view('client/errors/error_payphone');
            // return $this->response->setJSON(['error' => 'No se pudo confirmar el pago'], 400);
        }
    }


}
