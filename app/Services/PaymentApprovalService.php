<?php

namespace App\Services;

use App\Models\PaymentsModel;
use CodeIgniter\I18n\Time;

class PaymentApprovalService
{
    protected $paymentsModel;

    public function __construct()
    {
        $this->paymentsModel = new PaymentsModel();
    }

    public function approvePaymentAndSendEmail($paymentId)
    {
        // 1. Aprobar el pago
        $payment = $this->approvePayment($paymentId);

        if (!$payment) {
            return false;
        }

        // 2. Generar el PDF
        $pdfPath = $this->generatePDF($payment);

        if (!$pdfPath) {
            return false;
        }

        // 3. Enviar el email
        $emailSent = $this->sendEmail($payment, $pdfPath);

        // 4. Limpiar el archivo temporal
        unlink($pdfPath);

        return $emailSent;
    }

    protected function approvePayment($paymentId)
    {
        $payment = $this->paymentsModel->find($paymentId);
        if (!$payment) {
            return false;
        }

        $payment['payment_status'] = 2; // Asumiendo que 2 es el estado de "aprobado"
        $payment['date_time_payment'] = Time::now();

        $this->paymentsModel->update($paymentId, $payment);

        return $payment;
    }

    protected function generatePDF($payment)
    {
        helper('facture');
        $pdfData = generate_pdf($payment);
        $pdfOutput = $pdfData['output'];

        $pdfPath = WRITEPATH . 'uploads/comprobante_recaudacion_' . $payment['id'] . '.pdf';
        file_put_contents($pdfPath, $pdfOutput);

        return $pdfPath;
    }

    protected function sendEmail($payment, $pdfPath)
    {
        helper('email');
        $to = $payment['email_user'];
        $subject = 'Comprobante de recaudación';
        $message = 'Adjunto encontrará su comprobante de recaudación.';

        $result = send_email_with_pdf_from_path($to, $subject, $message, $pdfPath);

        if ($result === 'success') {
            $this->paymentsModel->update($payment['id'], ['send_email' => 1]);
            return true;
        }

        return false;
    }
}