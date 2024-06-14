<?php

namespace App\Models;

use CodeIgniter\Model;

class RegistrationsModel extends Model
{
    protected $table = 'registrations';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
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

    public function allInscritos()
    {

        $query = $this->db->table('payments')
            ->select('
                payments.payment_cod AS codigo_pago,
                registrations.ic AS cedula,
                registrations.full_name_user AS nombres,
                events.event_name AS evento,
                categories.category_name AS categoria,
                registrations.address AS direccion,
                registrations.phone AS telefono,
                registrations.email AS email,
                payments.payment_status
            ')
            ->join('registrations', 'payments.id_register = registrations.id')
            ->join('events', 'registrations.event_cod = events.id', 'left')
            ->join('categories', 'registrations.cat_id = categories.id', 'left')
            ->orderBy('payments.payment_cod')
            ->get()
            ->getResultArray();

        // Map the payment status to human-readable format
        foreach ($query as &$row) {
            $row['estado_pago'] = $this->getPaymentStatusText($row['payment_status']);
        }

        return $query;
    }

    public function getInscripcionesByCedula($cedula)
    {
        $query = $this->db->table('payments')
            ->select('
                payments.id AS id_pago,
                payments.payment_cod AS codigo_pago,
                registrations.ic AS cedula,
                registrations.full_name_user AS nombres,
                events.event_name AS evento,
                categories.category_name AS categoria,
                categories.cantidad_dinero AS precio,
                registrations.address AS direccion,
                registrations.phone AS telefono,
                registrations.email AS email,
                payments.payment_status
            ')
            ->join('registrations', 'payments.id_register = registrations.id')
            ->join('events', 'registrations.event_cod = events.id', 'left')
            ->join('categories', 'registrations.cat_id = categories.id', 'left')
            ->where('registrations.ic', $cedula)
            ->orderBy('payments.payment_cod')
            ->get()
            ->getResultArray();

        // Map the payment status to human-readable format
        foreach ($query as &$row) {
            $row['estado_pago'] = getPaymentStatusText($row['payment_status']);
        }

        return $query;
    }

    public function getInscripcionesByCedulaYEstado($cedula, $estado)
    {
        $query = $this->db->table('payments')
            ->select('
            payments.id AS id_pago,
            payments.payment_cod AS codigo_pago,
            registrations.ic AS cedula,
            registrations.full_name_user AS nombres,
            events.event_name AS evento,
            categories.category_name AS categoria,
            categories.cantidad_dinero AS precio,
            registrations.address AS direccion,
            registrations.phone AS telefono,
            registrations.email AS email,
            payments.payment_status
        ')
            ->join('registrations', 'payments.id_register = registrations.id')
            ->join('events', 'registrations.event_cod = events.id', 'left')
            ->join('categories', 'registrations.cat_id = categories.id', 'left')
            ->where('registrations.ic', $cedula)
            ->where('payments.payment_status', $estado)
            ->orderBy('payments.payment_cod')
            ->get()
            ->getResultArray();

        // Map the payment status to human-readable format
        foreach ($query as &$row) {
            $row['estado_pago'] = getPaymentStatusText($row['payment_status']);
        }

        return $query;
    }

}