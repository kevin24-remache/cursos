<?php
use CodeIgniter\I18n\Time;
use Dompdf\Dompdf;
use Dompdf\Options;

if (!function_exists('send_email_with_pdf')) {
    function send_email_with_pdf($to, $subject, $message, $htmlContent, $pdfFilename = 'document.pdf')
    {
        // Configurar las opciones de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Arial');

        // Crear una nueva instancia de Dompdf
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($htmlContent);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfOutput = $dompdf->output();

        // Guardar el PDF temporalmente en el servidor
        $tempPdfPath = WRITEPATH . 'uploads/' . $pdfFilename;
        file_put_contents($tempPdfPath, $pdfOutput);

        // Configurar y enviar el correo electrónico
        $email = \Config\Services::email();
        // $email->setFrom('apps@istel.edu.ec', 'TEST');
        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage($message);
        $email->attach($tempPdfPath);

        // Intentar enviar el correo
        if ($email->send()) {
            // Eliminar el archivo temporal después de enviar el correo
            unlink($tempPdfPath);
            return "success";
        } else {
            // Obtener cualquier error del correo
            $error = $email->printDebugger(['headers']);
            log_message('error', 'Error enviando correo: ' . $error);

            // Eliminar el archivo temporal en caso de error
            unlink($tempPdfPath);
            return $error;
        }
    }
}

if (!function_exists('send_email_with_pdf_from_path')) {
    function send_email_with_pdf_from_path($to, $subject, $message, $pdfFilePath)
    {
        // Configurar y enviar el correo electrónico
        $email = \Config\Services::email();
        // $email->setFrom('inscripciones@test.com', 'TEST');
        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage($message);
        $email->attach($pdfFilePath);

        // Intentar enviar el correo
        if ($email->send()) {
            return "success";
        } else {
            // Obtener cualquier error del correo
            $error = $email->printDebugger(['headers']);
            log_message('error', 'Error enviando correo: ' . $error);
            return $error;
        }
    }
}

if (!function_exists('mask_email')) {
    function mask_email($email)
    {
        $parts = explode('@', $email);
        $name = $parts[0];
        $domain = isset($parts[1]) ? $parts[1] : '';

        // Mostrar las primeras 4 letras del nombre
        $name_length = strlen($name);
        $masked_name = substr($name, 0, min(4, $name_length)) . str_repeat('*', max(0, $name_length - 4));

        // Mostrar la primera letra y última letra del dominio (sin tocar la extensión)
        $domain_parts = explode('.', $domain);
        $masked_domain = '';

        if (count($domain_parts) > 1) {
            $domain_name = $domain_parts[0];
            $domain_extension = $domain_parts[1];

            $domain_length = strlen($domain_name);
            $masked_domain = substr($domain_name, 0, 1) . str_repeat('*', max(0, $domain_length - 2)) . substr($domain_name, -1) . '.' . $domain_extension;
        } else {
            // En caso de que no haya una extensión
            $masked_domain = $domain;
        }

        return $masked_name . '@' . $masked_domain;
    }
}
?>