<?php

namespace App\Services;

use App\Models\PaymentsModel;
use App\Models\PaymentMethodsModel;
use CodeIgniter\I18n\Time;
use Dompdf\Dompdf;
use Dompdf\Options;
use PaymentStatus;

class PaymentAprobarService
{
    protected $paymentsModel;
    protected $paymentMethodModel;

    public function __construct()
    {
        $this->paymentsModel = new PaymentsModel();
        $this->paymentMethodModel = new PaymentMethodsModel();
    }

    public function approvePayment($paymentId, $userId)
    {
        helper('ramdom');
        $uniqueCode = generateUniqueNumericCode(50);

        $payment = $this->paymentsModel->pagoData($paymentId);
        if (!$payment) {
            return ['success' => false, 'message' => 'Pago no encontrado'];
        }

        // Validación para evitar el reenvío de email si ya se envió
        if ($payment['send_email'] == 1) {
            return ['success' => false, 'message' => 'El email ya ha sido enviado previamente'];
        }


        $local = $this->paymentMethodModel->paymentLocal(2);
        if (!$local) {
            return ['success' => false, 'message' => 'Método de pago desactivado'];
        }

        $datosPago = $this->calculatePaymentDetails($payment['precio'], $uniqueCode);

        try {
            $this->paymentsModel->updatePaymentAndInsertInscripcionPago($paymentId, $datosPago, $userId);
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Error en la actualización del pago: ' . $e->getMessage()];
        }

        $pdfResult = $this->generateAndSendPDF($uniqueCode);
        if ($pdfResult !== 'success') {
            return ['success' => false, 'message' => 'Error al generar o enviar el PDF: ' . $pdfResult];
        }

        return ['success' => true, 'message' => 'Pago aprobado y email enviado correctamente', 'uniqueCode' => $uniqueCode];
    }

    protected function calculatePaymentDetails($precio, $uniqueCode)
    {
        $cantidad = 1;
        $fecha_emision = Time::now();
        $precio_unitario = 0.51;
        $subtotal = $precio_unitario * $cantidad;
        $sub_total_0 = 0.00;
        $subtotal_15 = $subtotal;
        $iva_15 = $subtotal * 0.15;
        $total = $precio_unitario + $iva_15;

        return [
            "num_autorizacion" => $uniqueCode,
            "date_time_payment" => $fecha_emision,
            "payment_status" => PaymentStatus::Completado,
            "amount_pay" => $precio,
            "precio_unitario" => $precio_unitario,
            "sub_total" => $subtotal,
            "sub_total_0" => $sub_total_0,
            "sub_total_15" => $subtotal_15,
            "iva" => $iva_15,
            "valor_total" => $subtotal,
            "total" => $total,
            "payment_method_id" => 3,
        ];
    }

    protected function generateAndSendPDF($num_autorizacion)
    {
        helper(['facture', 'email']);
        $payment = $this->paymentsModel->numeroAutorizacion($num_autorizacion);
        if (!$payment) {
            return 'Pago no encontrado';
        }

        $pdfData = generate_pdf($payment);
        $pdfOutput = $pdfData['output'];

        $pdfPath = WRITEPATH . 'uploads/comprobante_recaudacion.pdf';
        file_put_contents($pdfPath, $pdfOutput);

        $to = $payment['email_user'];
        $subject = 'Comprobante de recaudación';
        $message = 'Adjunto encontrará su comprobante de recaudación.';
        $result = send_email_with_pdf_from_path($to, $subject, $message, $pdfPath);

        if ($result === 'success') {
            $this->paymentsModel->update($payment['id'], ['send_email' => 1]);
            unlink($pdfPath);
            return 'success';
        } else {
            unlink($pdfPath);
            return $result;
        }
    }
}