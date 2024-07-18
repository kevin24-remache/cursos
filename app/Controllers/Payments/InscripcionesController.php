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

    private function demoPDF($num_autorizacion)
    {
        helper('facture');
        $paymentsModel = new PaymentsModel();
        $payment = $paymentsModel->getPaymentByNumAutorizacion($num_autorizacion);
        if (!$payment) {
            return 'Registro no encontrado';
        }

        // Generar el PDF
        $pdfData = generate_pdf($payment);
        $pdfOutput = $pdfData['output'];

        // Guardar el PDF en una ruta accesible
        $pdfPath = WRITEPATH . 'uploads/factura.pdf';
        file_put_contents($pdfPath, $pdfOutput);

        // Verificar si se debe enviar el correo electrónico
        if (empty($payment['send_email'])) {
            helper('email');
            // Enviar correo electrónico con el PDF adjunto
            $to = $payment['email_user'];
            $subject = 'Factura';
            $message = 'Adjunto encontrará su factura.';
            $result = send_email_with_pdf_from_path($to, $subject, $message, $pdfPath);

            if ($result === 'success') {
                // Actualizar el campo send_email en la base de datos
                $paymentsModel->update($payment['id'], ['send_email' => 1]);
                // Eliminar el archivo PDF temporal
                unlink($pdfPath);
                return 'success';
            } else {
                // Ocurrió un error al enviar el correo
                return $result;
            }
        }

        // Eliminar el archivo PDF temporal
        unlink($pdfPath);
        return 'success';
    }

    private function redirectView($validation = null, $flashMessages = null, $last_data = null, $ic = null, $estado = null, $uniqueCode = null)
    {
        return redirect()->to('/punto/pago/inscripciones/' . $ic . '/' . $estado)->
            with('flashValidation', isset($validation) ? $validation->getErrors() : null)->
            with('flashMessages', $flashMessages)->
            with('last_data', $last_data)->
            with('uniqueCode', $uniqueCode);
    }

    private function redirectError($validation = null, $flashMessages = null, $last_data = null)
    {
        return redirect()->to('punto/pago/inscripciones')->
            with('flashValidation', isset($validation) ? $validation->getErrors() : null)->
            with('flashMessages', $flashMessages)->
            with('last_data', $last_data);
    }

    public function showPDF($num_autorizacion)
    {
        helper('facture');
        $paymentsModel = new PaymentsModel();
        $payment = $paymentsModel->getPaymentByNumAutorizacion($num_autorizacion);
        if (!$payment) {
            return "Registro no encontrado";
        }

        // Generar el PDF
        $pdfData = generate_pdf($payment);
        $pdf = $pdfData['pdf'];

        // Enviar el PDF al navegador
        $pdf->stream('factura.pdf', ['Attachment' => false]);
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
        // $total_pago = $subtotal + $iva_15;
        $pago_final = $precio;
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
            "payment_method_id" => 2,
        ];

        // Verificar si el campo num_autorizacion ya tiene un valor
        if (isset($payment['num_autorizacion']) && !empty($payment['num_autorizacion']) && ($payment['payment_status'] !== 2)) {
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
        // Llamar al método demoPDF() para generar y enviar el PDF
        $result = $this->demoPDF($uniqueCode);

        // Verificar el resultado de demoPDF()
        if ($result === 'success') {
            return $this->redirectView(null, [['Email enviado con el PDF correctamente', 'success', $uniqueCode]], null, $cedula, 'Completado', $uniqueCode);
        } else {
            return $this->redirectView(null, [['Error al enviando el email ', 'error']], null, $cedula, $estado_pago);
        }
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