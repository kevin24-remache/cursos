<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PaymentMethodsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'method_name' => 'Deposito',
                'description' => 'Pago por deposito'
            ],
            [
                'method_name' => 'Pago fisico',
                'description' => 'Pago en puntos de pago'
            ]
        ];
        $this->db->table('payment_methods')->insertBatch($data);
    }
}
