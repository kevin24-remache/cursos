<?php
namespace App\Controllers\Payments;

use App\Controllers\BaseController;
use App\Models\PaymentMethodsModel;
use App\Models\PaymentsModel;
use App\Models\RegistrationsModel;
use CodeIgniter\I18n\Time;
use ModulosAdminPagos;
use Dompdf\Dompdf;
use Dompdf\Options;
use PaymentStatus;

class InscripcionesController extends BaseController
{
    public function demoPDF($num_autorizacion)
    {
        $paymentsModel = new PaymentsModel();
        $payment = $paymentsModel->getPaymentByNumAutorizacion($num_autorizacion);
        if (!$payment) {
            return "Registro no encontrado";
        }

        // Extraer los datos del pago
        $user = $payment['user'];
        $user_ic = $payment['user_ic'];
        $fecha_emision = $payment['fecha_emision'];
        $precio_unitario = $payment['precio_unitario'];
        $valor_total = $payment['valor_total'];
        $sub_total = $payment['sub_total'];
        $sub_total_0 = $payment['sub_total_0'];
        $sub_total_15 = $payment['sub_total_15'];
        $iva = $payment['iva'];
        $total = $payment['total'];
        $email_user = $payment['email_user'];
        $user_tel = $payment['user_tel'];
        $operador = $payment['operador'];
        $valor_total = $payment['valor_total'];
        $valor_final = $payment['amount_pay'];
        $send_email = $payment['send_email'];

        // Validar campos obligatorios
        // if (empty($email_user) || empty($user) || empty($user_ic) || empty($fecha_emision) || empty($precio_unitario) || empty($val_total) || empty($sub_total) || empty($sub_total_0) || empty($sub_total_15) || empty($iva) || empty($total) || empty($operador) || empty($valor_total)) {
        //     return "Faltan datos obligatorios para generar la factura";
        // }

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
            'valor_total' => $valor_total,
            'sub_total' => $sub_total,
            'sub_total_0' => $sub_total_0,
            'sub_total_15' => $sub_total_15,
            'iva' => $iva,
            'total' => $total,
            'email_user' => $email_user,
            'user_tel' => $user_tel,
            'operador' => $operador,
            'valor_final' => $valor_final,
            // 'evento' => $evento,
        ]);

        $pdf->loadHtml($html);

        // Tamaño de la página en puntos (58 x 210 mm)
        $customPaper = array(0, 0, 164.41, 595.51); // 58mm = 164.41pt, 210mm = 595.51pt
        $pdf->setPaper($customPaper);

        // Renderizar el PDF
        $pdf->render();

        // Obtener la salida del PDF como una cadena
        $pdfOutput = $pdf->output();

        // Guardar el PDF temporalmente en el servidor
        $tempPdfPath = WRITEPATH . 'uploads/factura.pdf';
        file_put_contents($tempPdfPath, $pdfOutput);

        // Verificar si se debe enviar el correo electrónico
        if (empty($send_email)) {
            helper('email');
            // Enviar correo electrónico con el PDF adjunto
            $to = $email_user;
            $subject = 'Factura';
            $message = 'Adjunto encontrará su factura.';
            $result = send_email_with_pdf_from_path($to, $subject, $message, $tempPdfPath);

            if ($result === 'success') {
                // Actualizar el campo send_email en la base de datos
                $paymentsModel->update($payment['id'], ['send_email' => 1]);
            } else {
                // Ocurrió un error al enviar el correo
                echo $result;
            }
        }

        // Enviar el PDF al navegador
        $pdf->stream('factura.pdf', ['Attachment' => false]);

        // Eliminar el archivo temporal
        unlink($tempPdfPath);
    }

    private function redirectView($validation = null, $flashMessages = null, $last_data = null, $ic = null, $estado = null)
    {
        return redirect()->to('/punto/pago/inscripciones/' . $ic . '/' . $estado)->
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
        helper('ramdom');
        $uniqueCode = generateUniqueNumericCode(50);

        $id_usuario = session('id');
        $id_pago = $this->request->getPost('id');
        $cedula = $this->request->getPost('cedula');
        $estado_pago = $this->request->getPost('estado_pago');
        $precio = $this->request->getPost('precio');
        if (!$id_pago) {
            return $this->redirectView(null, [['El id no existe', 'warning']], null, $cedula, $estado_pago);
        }

        $paymentsModel = new PaymentsModel();
        $payment_methodModel = new PaymentMethodsModel();
        $local = $payment_methodModel->paymentLocal(2);
        if (!$local) {
            return $this->redirectView(null, [['Método de pago desactivado', 'warning']], null, $cedula, $estado_pago);
        }

        // Obtener el registro del pago
        $payment = $paymentsModel->find($id_pago);
        if (!$payment) {
            return $this->redirectView(null, [['Pago no encontrado', 'warning']], null, $cedula, $estado_pago);
        }
        $cantidad = 1;
        $fecha_emision = Time::now();
        $precio_unitario = 0.51;
        $subtotal = $precio_unitario * $cantidad;
        $valor_total = $precio_unitario * $cantidad;
        $sub_total_0 = 0.00; // Si no hay subtotales exentos o a 0%
        $subtotal_15 = $subtotal;
        $iva_15 = $subtotal * 0.15;
        $total_pago = $subtotal + $iva_15;
        $pago_final = $precio + $total_pago;
        $total = $precio_unitario + $iva_15;
        $datosPago = [
            "num_autorizacion" => $uniqueCode,
            "date_time_payment" => $fecha_emision,
            "payment_status" => 2,
            "amount_pay" => $pago_final,
            "precio_unitario" => $precio_unitario,
            "sub_total" => $subtotal,
            "sub_total_0" => $sub_total_0,
            "sub_total_15" => $subtotal_15,
            "iva" => $iva_15,
            "valor_total" => $valor_total,
            "total" => $total,
            "payment_method_id"=>2,
        ];

        // Verificar si el campo num_autorizacion ya tiene un valor
        if (isset($payment['num_autorizacion']) && !empty($payment['num_autorizacion'])&&($payment['payment_status'] !== 2)) {
            // El campo num_autorizacion ya tiene un valor, usar el existente
            $uniqueCode = $payment['num_autorizacion'];
            $paymentsModel->update($id_pago, ["payment_status" => 2, "payment_method_id" => 2]);

        } else {
            // El campo num_autorizacion está vacío, actualizar con el nuevo valor
            try {
                $paymentsModel->updatePaymentAndInsertInscripcionPago($id_pago, $datosPago, $id_usuario);
            } catch (\Exception $e) {
                return $this->redirectView(null, [['Error en la creación del pdf:' . $e->getMessage(), 'warning']], null, $cedula, $estado_pago);
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

        // Verificar que el estado sea obligatorio y válido
        if (is_null($estadoValue) || !in_array($estadoValue, $validStates)) {
            $data = ['cedula' => $cedula];
            return $this->redirectError(null, [['El estado es obligatorio y debe ser válido', 'warning']], $data);
        }

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

}