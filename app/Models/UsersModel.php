<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = false;
    protected $allowedFields = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = false;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
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
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function usersAll()
    {
        return $this->select('id,rol_id, ic, first_name, last_name, phone_number, email, address')
            ->where('rol_id !=', 1)
            ->findAll();
    }

    public function detalleUsuario($id)
    {
        return $this->select('id,rol_id, ic, first_name, last_name, phone_number, email, address')
            ->where('id', $id)
            ->find();
    }

    public function getUserCollections($userId)
    {
        $builder = $this->select('
            users.ic AS ic,
            users.id AS id,
            users.first_name,
            users.last_name,
            payments.id AS payment_id,
            payments.amount_pay,
            payments.date_time_payment,
            payments.payment_cod AS codigo,
            payments.num_autorizacion AS num_autorizacion,
            registrations.full_name_user AS participante_name,
            registrations.ic AS participante_cedula,
            registrations.address AS participante_direccion,
            registrations.phone AS participante_telefono,
            registrations.email AS participante_email,
            registrations.event_name AS event_name,
            registrations.monto_category AS precio,
            payment_methods.method_name AS method_pago,
        ');
        $builder->join('inscripcion_pagos', 'users.id = inscripcion_pagos.usuario_id');
        $builder->join('payments', 'inscripcion_pagos.pago_id = payments.id');
        $builder->join('registrations', 'payments.id_register = registrations.id');
        $builder->join('payment_methods', 'payment_methods.id = payments.payment_method_id');
        $builder->where('users.id', $userId);
        $builder->where('payments.payment_status', 2); // Asumiendo que 2 es el estado de pago completado
        $builder->orderBy('payments.date_time_payment', 'DESC');

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getUserRecaudado()
    {
        $builder = $this->select('
            users.ic AS ic,
            users.id AS id,
            users.first_name AS operador,
            users.last_name AS last_operador,
            payments.id AS payment_id,
            payments.amount_pay,
            payments.date_time_payment,
            payments.payment_cod AS codigo,
            payments.num_autorizacion AS num_autorizacion,
            registrations.full_name_user AS participante_name,
            registrations.ic AS participante_cedula,
            registrations.address AS participante_direccion,
            registrations.phone AS participante_telefono,
            registrations.email AS participante_email,
            registrations.event_name AS event_name,
            registrations.monto_category AS precio,
            payment_methods.method_name AS method_pago,
        ');
        $builder->join('inscripcion_pagos', 'users.id = inscripcion_pagos.usuario_id');
        $builder->join('payments', 'inscripcion_pagos.pago_id = payments.id');
        $builder->join('registrations', 'payments.id_register = registrations.id');
        $builder->join('payment_methods', 'payment_methods.id = payments.payment_method_id');
        // $builder->where('users.rol_id', 2);
        $builder->where('payments.payment_status', 2); // Asumiendo que 2 es el estado de pago completado
        $builder->orderBy('payments.date_time_payment', 'DESC');

        $query = $builder->get();
        return $query->getResultArray();
    }


}