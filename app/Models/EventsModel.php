<?php

namespace App\Models;

use CodeIgniter\Model;

class EventsModel extends Model
{
    protected $table = 'events';
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


    // protected function setCreatedBy($data)
    // {
    //     $data['data']['created_by'] = session('id') ?? 1;
    //     return $data;
    // }

    // protected function setUpdatedBy($data)
    // {
    //     $data['data']['updated_by'] = session('id') ?? 1;
    //     return $data;
    // }

    // protected function setDeletedBy($data)
    // {
    //     $this->set(['deleted_by' => session('id') ?? 1])->update($data['id']);
    //     return $data;
    // }

    public function getEventById($id)
    {
        return $this->select('events.id, events.event_name, events.short_description, events.event_date, events.modality, events.address, events.registrations_start_date, events.registrations_end_date, events.event_status, events.image, GROUP_CONCAT(categories.id) AS category_ids, GROUP_CONCAT(categories.category_name) AS categories, GROUP_CONCAT(categories.cantidad_dinero) AS cantidad_dinero')
            ->join('event_category', 'event_category.event_id = events.id', 'left')
            ->join('categories', 'categories.id = event_category.cat_id', 'left')
            ->where('events.id', $id)
            ->groupBy('events.id')
            ->first();
    }

    public function getEventNameAndCategories($eventId, $categoryId)
    {
        return $this->select('events.id, events.event_name, events.event_date, categories.category_name, categories.cantidad_dinero AS cantidad_dinero')
            ->join('event_category', 'event_category.event_id = events.id', 'left')
            ->join('categories', 'categories.id = event_category.cat_id', 'left')
            ->where('events.id', $eventId)
            ->where('categories.id', $categoryId)
            ->first();
    }


}