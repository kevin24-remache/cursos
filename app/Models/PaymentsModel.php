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
}
