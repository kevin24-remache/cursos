<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data=[
            //Admin
            [
            'rol_id' => '1',
            'ic' => '0000000000',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'phone_number' => '0987847289',
            'email' => 'admin@admin.com',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            ]
        ];
        $this->db->table('users')->insertBatch($data);
    }
}
