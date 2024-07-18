<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentsModel extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = false;
    protected $allowedFields = [];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = false;
    protected $beforeInsert = ['setCreatedBy'];
    protected $afterInsert = [];
    protected $beforeUpdate = ['setUpdatedBy'];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = ['setDeletedBy'];
    protected $afterDelete = [];



    public function getPaymentByNumAutorizacion($num_autorizacion)
    {
        $query = $this->db->table('payments')
            ->select('
            payments.num_autorizacion,
            payments.id_register,
            registrations.full_name_user AS user,
            registrations.ic AS user_ic,
            payments.date_time_payment AS fecha_emision,
            payments.precio_unitario AS precio_unitario,
            categories.cantidad_dinero AS cantidad_dinero,
            payments.sub_total AS sub_total,
            payments.sub_total_0 AS sub_total_0,
            payments.sub_total_15 AS sub_total_15,
            payments.iva AS iva,
            payments.total AS total,
            registrations.email AS email_user,
            registrations.phone AS user_tel,
            payments.valor_total AS valor_total,
            payments.send_email,
            payments.id,
            payments.amount_pay,
            users.first_name AS operador
        ')
            ->join('registrations', 'payments.id_register = registrations.id', 'left')
            ->join('events', 'registrations.event_cod = events.id', 'left')
            ->join('categories', 'registrations.cat_id = categories.id', 'left')
            ->join('inscripcion_pagos', 'inscripcion_pagos.pago_id = payments.id', 'left')
            ->join('users', 'users.id = inscripcion_pagos.usuario_id', 'left')
            ->where('payments.num_autorizacion', $num_autorizacion)
            ->where('payments.payment_status', 2)
            ->get()
            ->getRowArray();

        return $query;
    }

    public function updatePaymentAndInsertInscripcionPago($id_pago, $datosPago, $id_usuario)
    {
        $this->db->transStart();

        // Intentar actualizar el registro en la tabla payments
        $update = $this->update($id_pago, $datosPago);

        // Si la actualización fue exitosa, insertar el registro en la tabla inscripcion_pagos
        if ($update) {
            $inscripcionPagosData = [
                'pago_id' => $id_pago,
                'fecha_hora' => date('Y-m-d H:i:s'), // Fecha y hora actual
                'usuario_id' => $id_usuario // Nombre del usuario que hizo el cobro
            ];

            // Insertar el nuevo registro en la tabla inscripcion_pagos
            $this->db->table('inscripcion_pagos')->insert($inscripcionPagosData);
        }

        $this->db->transComplete();

        // Verificar si la transacción fue exitosa
        if ($this->db->transStatus() === FALSE) {
            // Si algo salió mal, lanzar una excepción o manejar el error
            throw new \Exception('Error en la actualización del pago o inserción en inscripcion_pagos.');
        }

        return $update;
    }

    public function updatePaymentDeposito($id_pago, $datosPago, $id_usuario)
    {
        try {

            $this->db->transStart();

            // Intentar actualizar el registro en la tabla payments
            $update = $this->update($id_pago, $datosPago);

            // Si la actualización fue exitosa, continuar con las otras operaciones
            if ($update) {
                // Insertar el registro en la tabla inscripcion_pagos
                $inscripcionPagosData = [
                    'pago_id' => $id_pago,
                    'fecha_hora' => date('Y-m-d H:i:s'),
                    'usuario_id' => $id_usuario
                ];
                $this->db->table('inscripcion_pagos')->insert($inscripcionPagosData);

                // Actualizar todos los registros en la tabla deposits relacionados con el payment_id
                $depositData = [
                    'status' => 'Aprobado',
                    'approved_by' => $id_usuario
                ];
                $this->db->table('deposits')
                    ->where('payment_id', $id_pago)
                    ->update($depositData);
            }

            $this->db->transComplete();

            return $update;
        } catch (\Exception $e) {

            $this->db->transRollback();

            throw new \Exception($e->getMessage());
        }
    }

    public function updatePaymentRechazo($id_pago, $estado, $id_usuario, $motivo_rechazo, $precio_pagado = null, $tipo_rechazo = 'General')
    {
        $this->db->transStart();

        try {
            // Actualizar sólo los campos necesarios en la tabla payments
            $update = $this->db->table('payments')
                ->where('id', $id_pago)
                ->update([
                    'payment_status' => $estado,
                    // 'amount_pay' => $precio_pagado // ya no actualizo el valor del pago
                ]);

            // Verificar si la actualización fue exitosa
            if (!$update) {
                throw new \Exception('Error al actualizar la tabla payments.');
            }

            // Actualizar todos los depósitos asociados al payment_id
            $updateDeposits = $this->db->table('deposits')
                ->where('payment_id', $id_pago)
                ->update(['status' => 'Incompleto']);

            // Verificar si la actualización de deposits fue exitosa
            if (!$updateDeposits) {
                throw new \Exception('Error al actualizar la tabla deposits.');
            }

            // Insertar el registro en la tabla rejection_reasons
            $rejectionReasonsData = [
                'payment_id' => $id_pago,
                'user_id' => $id_usuario,
                'reason' => $motivo_rechazo,
                'rejection_date' => date('Y-m-d H:i:s'),
                'rejection_type' => $tipo_rechazo,
                'send_email' => 1 // Siempre enviar el correo
            ];

            $insertRejectionReasons = $this->db->table('rejection_reasons')->insert($rejectionReasonsData);

            // Verificar si la inserción en rejection_reasons fue exitosa
            if (!$insertRejectionReasons) {
                throw new \Exception('Error al insertar en la tabla de rechazos.');
            }

            $this->db->transComplete();

            // Verificar si la transacción fue exitosa
            if ($this->db->transStatus() === FALSE) {
                throw new \Exception('Error en la transacción. Revisa los logs para más detalles.');
            }

            return ['update' => $update, 'should_send_email' => true];

        } catch (\Exception $e) {
            $this->db->transRollback();
            // Lanzar una excepción personalizada con el mensaje específico
            throw new \Exception('Error durante la operación: ' . $e->getMessage());
        }
    }



    public function getPaymentsWithDetailsAndDeposits()
    {
        return $this->select('
        payments.id as id_pago,
        payments.amount_pay,
        payments.payment_status,
        payments.payment_cod as codigo_pago,
        payments.payment_time_limit,
        payments.num_autorizacion,
        registrations.full_name_user,
        registrations.ic,
        registrations.address,
        registrations.phone,
        registrations.email,
        categories.category_name,
        categories.cantidad_dinero,
        events.event_name
    ')
            ->distinct()
            ->join('deposits', 'deposits.payment_id = payments.id', 'inner')
            ->join('registrations', 'payments.id_register = registrations.id', 'left')
            ->join('categories', 'registrations.cat_id = categories.id', 'left')
            ->join('events', 'registrations.event_cod = events.id', 'left')
            ->where('payments.payment_status', 4)
            ->findAll();
    }
    public function getPaymentUser($id)
    {
        return $this->select('
        payments.id ,
        payments.amount_pay,
        payments.payment_status,
        payments.payment_cod as codigo_pago,
        payments.payment_time_limit,
        payments.num_autorizacion,
        registrations.full_name_user as name,
        registrations.ic,
        registrations.address,
        registrations.phone,
        registrations.email,
        categories.category_name as categoria,
        categories.cantidad_dinero as monto_total,
        events.event_name as evento
    ')
            ->distinct()
            ->join('deposits', 'deposits.payment_id = payments.id', 'inner')
            ->join('registrations', 'payments.id_register = registrations.id', 'left')
            ->join('categories', 'registrations.cat_id = categories.id', 'left')
            ->join('events', 'registrations.event_cod = events.id', 'left')
            ->where('payments.id', $id)
            ->findAll();
    }
    public function isPaymentCompleted($paymentId)
    {
        $payment = $this->select('payment_status')
            ->where('id', $paymentId)
            ->first();

        if ($payment && $payment['payment_status'] == 2) {
            return true;
        }

        return false;
    }
    public function isPaymentStatusCompleted($paymentId)
    {
        $payment = $this->select('num_autorizacion')
            ->where('id', $paymentId)
            ->where('payment_status', 2)
            ->get()
            ->getRowArray();

        if ($payment) {
            return ['completed' => true, 'num_autorizacion' => $payment['num_autorizacion']];
        }

        return ['completed' => false, 'num_autorizacion' => null];
    }



}
