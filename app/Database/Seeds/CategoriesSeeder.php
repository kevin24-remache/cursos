<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $data=[
            [
            'category_name' => 'Categoría de test',
            'short_description' => 'EDescripción de la categoría del test',
            ]
        ];
        $this->db->table('categories')->insertBatch($data);
    }
}