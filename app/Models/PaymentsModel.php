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
            categories.cantidad_dinero AS precio_unitario,
            categories.cantidad_dinero AS val_total,
            payments.amount_pay AS sub_total,
            payments.amount_pay AS sub_total_0,
            0 AS sub_total_15,
            0 AS iva,
            payments.amount_pay AS total,
            registrations.email AS email_user,
            registrations.phone AS user_tel,
            users.first_name AS operador,
            payments.amount_pay AS valor_total
        ')
            ->join('registrations', 'payments.id_register = registrations.id', 'left')
            ->join('events', 'registrations.event_cod = events.id', 'left')
            ->join('categories', 'registrations.cat_id = categories.id', 'left')
            ->join('users', 'payments.created_by = users.id', 'left')
            ->where('payments.num_autorizacion', $num_autorizacion)
            ->get()
            ->getRowArray();

        return $query;
    }
}
