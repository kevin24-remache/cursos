<?php

namespace App\Jobs;

use Dompdf\Dompdf;
use Dompdf\Options;
use Exception;
use CodeIgniter\Queue\BaseJob;
use CodeIgniter\Queue\Interfaces\JobInterface;

class Email extends BaseJob implements JobInterface
{
    protected int $retryAfter = 60;
    protected int $tries = 3;

    public function process()
    {
        $to = $this->data['to'];
        $subject = $this->data['subject'];
        $message = $this->data['message'];
        $htmlContent = $this->data['htmlContent'];
        $pdfFilename = $this->data['pdfFilename'] ?? 'document.pdf';
        $paymentData = $this->data['paymentData'] ?? null; // Datos de pago si aplica

        try {
            // Generar PDF según el tipo de correo
            if ($this->data['emailType'] === 'send_email_facture' && $paymentData) {
                $pdfData = $this->generate_pdf($paymentData);
                $pdfOutput = $pdfData['output'];
            } else {
                $options = new Options();
                $options->set('isHtml5ParserEnabled', true);
                $options->set('isRemoteEnabled', true);
                $options->set('defaultFont', 'Arial');
                $dompdf = new Dompdf($options);
                $dompdf->loadHtml($htmlContent);
                $dompdf->setPaper('A4', 'portrait'); // <-- SOLO USAR ESTO
                $dompdf->render();
                $pdfOutput = $dompdf->output();
            }

            $tempPdfPath = WRITEPATH . 'uploads/' . $pdfFilename;
            file_put_contents($tempPdfPath, $pdfOutput);

            $email = service('email', null, false);
            $email->setTo($to);
            $email->setSubject($subject);
            $email->setMessage($message . '<br><br>' . $htmlContent);
            $email->attach($tempPdfPath);

            $result = $email->send(false);

            unlink($tempPdfPath);

            if (!$result) {
                throw new Exception($email->printDebugger(['headers']));
            }

            return $result;
        } catch (Exception $e) {
            log_message('error', 'Error al enviar el email: ' . $e->getMessage());
            throw $e;
        }
    }

    public function generate_pdf($payment)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Arial');

        $pdf = new Dompdf($options);

        // Usa el view que ya tienes, pero adapta el CSS si hace falta para que sea ancho A4
        $html = view('email/facture', [
            'num_autorizacion' => $payment['num_autorizacion'],
            'user' => $payment['user'],
            'user_ic' => $payment['user_ic'],
            'fecha_emision' => $payment['fecha_emision'],
            'precio_unitario' => $payment['precio_unitario'],
            'valor_total' => $payment['valor_total'],
            'sub_total' => $payment['sub_total'],
            'sub_total_0' => $payment['sub_total_0'],
            'sub_total_15' => $payment['sub_total_15'],
            'iva' => $payment['iva'],
            'total' => $payment['total'],
            'email_user' => $payment['email_user'],
            'user_tel' => $payment['user_tel'],
            'operador' => $payment['operador'],
            'valor_final' => $payment['amount_pay'],
            'event_name' => $payment['event_name'],
            'metodo_pago' => $payment['metodo_pago'],
        ]);

        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait'); // <-- SOLO A4 VERTICAL, JAMÁS CUSTOM
        $pdf->render();

        $output = $pdf->output();

        return ['pdf' => $pdf, 'output' => $output];
    }
}
