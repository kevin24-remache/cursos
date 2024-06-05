<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableRegistrations extends Migration
{
    public function up()
    {

        // Deshabilitar chequeo de claves foráneas temporalmente
        $this->db->disableForeignKeyChecks();

        $this->forge->addField([
            'id' =>[
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'user_id' =>[
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'event_cod' =>[
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'cat_id' =>[
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'full_name_user' =>[
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => false,
            ],
            'ic' =>[
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => false,
            ],
            'address' =>[
                'type' => 'TEXT',
                'null' => true,
            ],
            'phone' =>[
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'email' =>[
                'type' => 'TEXT',
                'null' => true,
            ],
            'event_name' =>[
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'amount_pay' =>[
                'type' => 'NUMERIC',
                'constraint' => '10,2',
                'null' => true,
            ],
            'payment_status' =>[
                'type' => 'VARCHAR',
                'constraint' => 20,
                'comment' => 'Estado del pago (Pagado,Anulado,No pagado)',
                'null' => true,
            ],
            'date_time_payment' =>[
                'type' => 'DATETIME',
                'null' => true,
            ],
            'payment_cod' =>[
                'type' => 'INT',
                'null' => false,
            ],
            'address_payment' =>[
                'type' => 'INT',
                'null' => true,
            ],
            'payment_time_limit' =>[
                'type' => 'DATE',
                'null' => false
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'null' => true,
                'default' => 1,
            ],
            'updated_by' => [
                'type' => 'INT',
                'null' => true,
            ],
            'deleted_by' => [
                'type' => 'INT',
                'null' => true,
            ],
        ]);
        $this->forge->addkey('id',true);
        // Agregar la llave foránea para la columna 'event_cod' que referencia a la columna 'id' de la tabla event
        $this->forge->addForeignKey('event_cod', 'events', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('cat_id', 'categories', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('registrations');
    }

    public function down()
    {
        $this->forge->dropTable('registrations');
    }
}
