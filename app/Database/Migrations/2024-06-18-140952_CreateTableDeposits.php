<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableDeposits extends Migration
{
    public function up()
    {
        // Deshabilitar chequeo de claves foráneas temporalmente
        $this->db->disableForeignKeyChecks();

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'payment_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'deposit_cedula' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'codigo_pago' => [
                'type' => 'INT',
                'null' => false,
            ],
            'monto_deposito' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => false,
            ],
            'comprobante_pago' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'num_comprobante' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'date_deposito' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Pendiente', 'Aprobado', 'Rechazado'],
                'default' => 'Pendiente',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('payment_id', 'payments', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('deposits');
    }

    public function down()
    {
        $this->forge->dropTable('deposits');
    }
}
