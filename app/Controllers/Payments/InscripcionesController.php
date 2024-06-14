<?php
namespace App\Controllers\Payments;

use App\Controllers\BaseController;
use App\Models\PaymentsModel;
use App\Models\RegistrationsModel;
use ModulosAdminPagos;
use Dompdf\Dompdf;
use Dompdf\Options;
use PaymentStatus;

class InscripcionesController extends BaseController
{
    public function send_email($persona, $codigoPago, $fechaLimitePago, $event)
    {
        // Fecha de emisión del PDF
        $fechaEmision = Time::now()->toDateTimeString();
        $fechaLimitePagoFormateada = $fechaLimitePago->toDateString();
        // Obtener los datos
        $user = $persona['nombres'] . ' ' . $persona['apellidos'];
        $emailAddress = $persona['email'];
        $evento = $event['event_name'];
        $categoria = $event['category_name'];
        $precio = $event['cantidad_dinero'];


        // Cargar la vista y pasar los datos
        $html = view('client/codigo', [
            'user' => $user,
            'codigoPago' => $codigoPago,
            'fechaLimitePago' => $fechaLimitePagoFormateada,
            'fechaEmision' => $fechaEmision,
            'evento' => $evento,
            'categoria' => $categoria,
            'precio' => $precio
        ]);

        // Generar el PDF con dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfOutput = $dompdf->output();
        $pdfFilename = 'comprobante_pago.pdf';

        // Guardar temporalmente el PDF en el servidor
        $tempPdfPath = WRITEPATH . 'uploads/' . $pdfFilename;
        file_put_contents($tempPdfPath, $pdfOutput);

        // Configurar y enviar el correo electrónico
        $email = \Config\Services::email();
        $email->setFrom('inscripciones@test.com', 'TEST');
        $email->setTo($emailAddress);
        $email->setSubject('Código de pago');
        $email->setMessage('Tu código de pago está en el PDF adjunto.');
        $email->attach($tempPdfPath);

        // Intentar enviar el correo
        if ($email->send()) {
            // Eliminar el archivo temporal después de enviar el correo
            unlink($tempPdfPath);
            return true;
        } else {
            // Obtener cualquier error del correo
            $error = $email->printDebugger(['headers']);
            log_message('error', 'Error enviando correo: ' . $error);

            // Eliminar el archivo temporal en caso de error
            unlink($tempPdfPath);
            return false;
        }
    }
    public function demoPDF($num_autorizacion)
    {
        $paymentsModel = new PaymentsModel();
        $payment = $paymentsModel->getPaymentByNumAutorizacion($num_autorizacion);
        if (!$payment) {
            return "Registro no encontrado";
        }

        // Extraer los datos del pago
        $user = $payment['user']; // Asegúrate de que estos campos existen en tu modelo
        $user_ic = $payment['user_ic'];
        $fecha_emision = $payment['fecha_emision'];
        $precio_unitario = $payment['precio_unitario'];
        $val_total = $payment['val_total'];
        $sub_total = $payment['sub_total'];
        $sub_total_0 = $payment['sub_total_0'];
        $sub_total_15 = $payment['sub_total_15'];
        $iva = $payment['iva'];
        $total = $payment['total'];
        $email_user = $payment['email_user'];
        $user_tel = $payment['user_tel'];
        $operador = $payment['operador'];
        $valor_total = $payment['valor_total'];

        // Configurar las opciones de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Arial');

        // Crear una nueva instancia de Dompdf con las opciones configuradas
        $pdf = new Dompdf($options);

        // Contenido HTML de la factura
        $html = view('payments/facture', [
            'num_autorizacion' => $num_autorizacion,
            'user' => $user,
            'user_ic' => $user_ic,
            'fecha_emision' => $fecha_emision,
            'precio_unitario' => $precio_unitario,
            'val_total' => $val_total,
            'sub_total' => $sub_total,
            'sub_total_0' => $sub_total_0,
            'sub_total_15' => $sub_total_15,
            'iva' => $iva,
            'total' => $total,
            'email_user' => $email_user,
            'user_tel' => $user_tel,
            'operador' => $operador,
            'valor_total' => $valor_total
        ]);

        $pdf->loadHtml($html);

        // Tamaño de la página en puntos (58 x 210 mm)
        $customPaper = array(0, 0, 164.41, 595.51); // 58mm = 164.41pt, 210mm = 595.51pt
        $pdf->setPaper($customPaper);

        // Renderizar el PDF
        $pdf->render();

        // Enviar el PDF al navegador
        $pdf->stream('factura.pdf', ['Attachment' => false]);
    }

    private function redirectView($validation = null, $flashMessages = null, $last_data = null)
    {
        return redirect()->to('punto/pago/inscripciones')->
            with('flashValidation', isset($validation) ? $validation->getErrors() : null)->
            with('flashMessages', $flashMessages)->
            with('last_data', $last_data);
    }

    private function redirectError($validation = null, $flashMessages = null, $last_data = null)
    {
        return redirect()->to('punto/pago/inscripciones')->
            with('flashValidation', isset($validation) ? $validation->getErrors() : null)->
            with('flashMessages', $flashMessages)->
            with('last_data', $last_data);
    }
    public function pago()
    {
        // Generar un código único de 50 caracteres
        $uniqueCode = bin2hex(random_bytes(25)); // 25 bytes * 2 = 50 caracteres hexadecimales

        $id_pago = $this->request->getPost('id');
        if (!$id_pago) {
            return "no existe el id";
        }

        $paymentsModel = new PaymentsModel();

        // Obtener el registro del pago
        $payment = $paymentsModel->find($id_pago);
        if (!$payment) {
            return "Pago no encontrado";
        }

        // Verificar si el campo num_autorizacion ya tiene un valor
        if (isset($payment['num_autorizacion']) && !empty($payment['num_autorizacion'])) {
            // El campo num_autorizacion ya tiene un valor, usar el existente
            $uniqueCode = $payment['num_autorizacion'];
        } else {
            // El campo num_autorizacion está vacío, actualizar con el nuevo valor
            $update = $paymentsModel->update($id_pago, ["num_autorizacion" => $uniqueCode]);
            if (!$update) {
                echo "Error en la actualización";
                return;
            }
        }

        // Redirigir a la ruta de PDF con el hash
        return redirect()->to(base_url("punto/pago/pdf/$uniqueCode"));
    }

    public function index($cedula = null, $estado = null)
    {
        $data = [
            'cedula' => $cedula,
        ];

        // Obtener datos flash
        $flashValidation = session()->getFlashdata('flashValidation');
        $flashMessages = session()->getFlashdata('flashMessages');
        $last_data = session()->getFlashdata('last_data');
        $last_action = session()->getFlashdata('last_action');

        $registrationModel = new RegistrationsModel();

        // Convertir el texto del estado a su valor entero correspondiente
        $estadoValue = mapEstadoToValue($estado);

        $validStates = [
            PaymentStatus::Pendiente,
            PaymentStatus::Completado,
            PaymentStatus::Fallido,
            PaymentStatus::EnProceso,
            PaymentStatus::Cancelado
        ];

        // Primero, obtener todas las inscripciones por cédula
        $all_registrations = $registrationModel->getInscripcionesByCedula($cedula);

        if (empty($all_registrations)) {
            // Si no se encuentran registros para la cédula, redirigir a una vista de error
            return $this->redirectError(null, [['El número de cédula ingresado no está inscrito', 'warning']], $data);
        }

        // Si se proporciona un estado, obtener inscripciones filtradas por cédula y estado
        if (!is_null($estadoValue) && in_array($estadoValue, $validStates)) {
            $filtered_registrations = $registrationModel->getInscripcionesByCedulaYEstado($cedula, $estadoValue);

            if (empty($filtered_registrations)) {
                $data['estado'] = $estadoValue;
                // Si no se encuentran registros para el estado específico, redirigir con un mensaje específico
                return $this->redirectError(null, [['No se encontraron registros para el estado especificado', 'warning']], $data);
            }

            // Si se encuentran registros para el estado específico, utilizar estos registros
            $all_registrations = $filtered_registrations;
        }

        // Continuar con la vista normal si se encuentran registros
        $modulo = ModulosAdminPagos::INSCRIPCIONES;
        $data = [
            'registrations' => $all_registrations,
            'last_action' => $last_action,
            'last_data' => $last_data,
            'validation' => $flashValidation,
            'flashMessages' => $flashMessages,
            'modulo' => $modulo,
        ];
        return view('payments/inscripciones', $data);
    }


    public function buscar()
    {
        $flashValidation = session()->getFlashdata('flashValidation');
        $flashMessages = session()->getFlashdata('flashMessages');
        $last_data = session()->getFlashdata('last_data');
        $last_action = session()->getFlashdata('last_action');
        $data = [
            'last_action' => $last_action,
            'last_data' => $last_data,
            'validation' => $flashValidation,
            'flashMessages' => $flashMessages
        ];
        return view('payments/buscar_cedula', $data);
    }

    public function buscarPorCedula()
    {
        $cedula = $this->request->getPost('cedula');
        $estado = $this->request->getPost('estado');
        $data = [
            'cedula' => $cedula,
            'estado' => $estado,
        ];

        if ($cedula && preg_match('/^\d{10}$/', $cedula)) {
            // Verificar si el estado es válido
            $validStates = [
                PaymentStatus::Pendiente,
                PaymentStatus::Completado,
                PaymentStatus::Fallido,
                PaymentStatus::EnProceso,
                PaymentStatus::Cancelado
            ];

            if (in_array($estado, $validStates)) {
                // Estado válido, redirigir a la ruta con cédula y estado
                $estadoText = getPaymentStatusText($estado);
                return redirect()->to("punto/pago/inscripciones/{$cedula}/{$estadoText}");
            } else {
                // Estado inválido, redirigir solo con la cédula
                return redirect()->to("punto/pago/inscripciones/{$cedula}");
            }
        } else {
            $validation = \Config\Services::validation();
            $validation->setError('cedula', 'El número de cédula debe poseer 10 dígitos numéricos');
            return $this->redirectError($validation, [['El número de cédula es inválido', 'warning']], $data);
        }
    }

}
