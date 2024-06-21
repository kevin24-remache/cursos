<?php
namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\RegistrationsModel;
use App\Models\PaymentsModel;
use App\Models\DepositsModel;

class DepositosController extends BaseController
{
    private function redirectView($validation = null, $flashMessages = null, $last_data = null, $last_action=null)
    {
        return redirect()->to('/')->
            with('flashValidation', isset($validation) ? $validation->getErrors() : null)->
            with('flashMessages', $flashMessages)->
            with('last_data', $last_data)->with('last_action', $last_action);
    }
    public function deposito()
    {
        $depositoCedula = $this->request->getPost('depositoCedula');
        $codigoPago = $this->request->getPost('codigoPago');
        $comprobantePago = $this->request->getFile('comprobantePago');
        $comprobante = $this->request->getPost('comprobante');
        $dateDeposito = $this->request->getPost('dateDeposito');
        $montoDeposito = $this->request->getPost('montoDeposito');

        $data = [
            'depositoCedula' => $depositoCedula,
            'codigoPago' => $codigoPago,
            'comprobantePago' => $comprobantePago->getName(),
            'comprobante' => $comprobante,
            'montoDeposito' => $montoDeposito,
            'dateDeposito' => $dateDeposito,
        ];

        $validation = \Config\Services::validation();
        $validation->setRules([
            'depositoCedula' => [
                'label' => 'Cédula',
                'rules' => 'required',
            ],
            'codigoPago' => [
                'label' => 'Código de Pago',
                'rules' => 'required',
            ],
            'comprobante' => [
                'label' => 'Número de comprobante',
                'rules' => 'required',
            ],
            'dateDeposito' => [
                'label' => 'Fecha del deposito',
                'rules' => 'required|valid_date',
            ],
            'montoDeposito' => [
                'label' => 'Monto del deposito',
                'rules' => 'permit_empty',
            ],
            'comprobantePago' => [
                'label' => 'Comprobante de pago',
                'rules' => 'required',
            ],
        ]);

        if (!$validation->run($data)) {
            return $this->redirectView($validation, [['Error en los datos enviados', 'warning']],$data,'insert');
        }

        $registrationsModel = new RegistrationsModel();
        $paymentsModel = new PaymentsModel();
        $depositosModel = new DepositsModel();

        // Iniciar la transacción
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Consulta JOIN para obtener el registro, el pago correspondiente y el precio de la categoría
            $query = $registrationsModel->select('registrations.id as registration_id, registrations.ic, payments.id as payment_id, payments.payment_cod, categories.cantidad_dinero as category_price')
                ->join('payments', 'payments.id_register = registrations.id', 'left')
                ->join('categories', 'categories.id = registrations.cat_id', 'left')
                ->where('registrations.ic', $depositoCedula)
                ->where('payments.payment_cod', $codigoPago)
                ->first();

            if (!$query) {
                $db->transRollback(); // Revertir la transacción
                return $this->redirectView(null, [['La cédula o el código de pago ingresados no son válidos', 'warning']]);
            }

            if ($depositosModel->existsPendingDeposit($codigoPago)) {
                $db->transRollback(); // Revertir la transacción
                return $this->redirectView(null, [['El código de pago ingresado está siendo evaluado ', 'warning']]);
            }

            // Validar si el archivo subido es una imagen
            if (!$comprobantePago->isValid() || !in_array($comprobantePago->getMimeType(), ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'])) {
                $db->transRollback(); // Revertir la transacción
                return $this->redirectView(null, [['El archivo subido no es una imagen válida', 'warning']]);
            }

            // Actualizar el estado del pago a 'En proceso' (4)
            $paymentsModel->update($query['payment_id'], ['payment_status' => 4]);

            // Guardar el monto del depósito y el comprobante de pago en la tabla inscripcion_pagos
            $nombreComprobante = $comprobantePago->getRandomName();
            $ruta = ROOTPATH . 'public/uploads/comprobantes/';

            if ($comprobantePago->move($ruta, $nombreComprobante)) {
                $rutaComprobante = 'uploads/comprobantes/' . $nombreComprobante;

                $deposits = [
                    'payment_id' => $query['payment_id'],
                    'deposit_cedula' => $depositoCedula,
                    'codigo_pago' => $codigoPago,
                    'monto_deposito' => $query['category_price'],
                    'comprobante_pago' => $rutaComprobante,
                    'num_comprobante' => $comprobante,
                    'date_deposito' => $dateDeposito,
                ];

                $depositosModel->insert($deposits);
                $db->transComplete(); // Confirmar la transacción

                return $this->redirectView(null, [['El depósito se ha registrado correctamente', 'success']]);
            } else {
                $db->transRollback(); // Revertir la transacción en caso de error al mover la imagen
                return $this->redirectView(null, [['No se pudo guardar el comprobante de pago', 'danger']]);
            }
        } catch (\Exception $e) {
            $db->transRollback(); // Revertir la transacción en caso de error
            return $this->redirectView(null, [['No se pudo registrar el depósito', 'danger']]);
        }
    }


    public function fetchMontoDeposito()
    {
        $request = $this->request->getJSON(); // Obtener datos JSON enviados desde el cliente
        $depositoCedula = $request->cedula ?? null;
        $codigoPago = $request->codigoPago ?? null;
        if (!$depositoCedula) {
            return $this->response->setJSON(['error' => 'cedula no enviada'], 404);
        }
        if (!$codigoPago) {
            return $this->response->setJSON(['error' => 'codigo no enviada'], 404);
        }
        $registrationsModel = new RegistrationsModel();
        $cod = $registrationsModel->getAmountByPaymentCode($depositoCedula, $codigoPago);
        try {
            if ($cod) {
                return $this->response->setJSON(['monto' => $cod]);
            } else {
                return $this->response->setJSON(['error' => 'Datos no encontrados'], 404);
            }
        } catch (\Exception $e) {
            // Aquí capturamos cualquier excepción y devolvemos un mensaje de error claro
            return $this->response->setJSON(['error' => 'Error al procesar la solicitud: ' . $e->getMessage()], 500);
        }
    }
}