<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EventsSeeder extends Seeder
{
    public function run()
    {
        $data=[
            [
            'event_name' => 'Evento XD',
            'short_description' => 'Evento XD es un evento genial que sirve para futuros profesionales XD',
            'event_date' => '2024-05-01',
            'modality' => '1',
            'event_time' => '08:00:00',
            'address' => 'Dirección example',
            'registrations_start_date' => '2024-05-01',
            'registrations_end_date' => '2024-06-01',
            'event_status' => 'Activo',
            'image' => '',
            ]
        ];
        $this->db->table('events')->insertBatch($data);
    }
}