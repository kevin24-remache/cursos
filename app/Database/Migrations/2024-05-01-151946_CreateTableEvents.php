<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableEvents extends Migration
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
            'event_name' =>[
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'short_description' =>[
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'event_date' =>[
                'type' => 'DATE',
                'null' => true,
            ],
            'event_time' =>[
                'type' => 'TIME',
                'null' => true,
            ],
            'address' =>[
                'type' => 'TEXT',
                'null' => true,
            ],
            'id_cat' =>[
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'registrations_start_date' =>[
                'type' => 'DATE',
                'null' => true,
            ],
            'registrations_end_date' =>[
                'type' => 'DATE',
                'null' => true,
            ],
            'event_status' =>[
                'type' => 'VARCHAR',
                'constraint' => 20,
                'comment' => 'Estado del evento (Activo,Cancelado,Completado)',
                'null' => true,
            ],
            'image' =>[
                'type' => 'TEXT',
                'null' => false,
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
        // Agregar la llave foránea para la columna 'id_cat' que referencia a la columna 'id' de la tabla categories
        $this->forge->addForeignKey('id_cat', 'categories', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('events');

    }

    public function down()
    {
        $this->forge->dropTable('events');
    }
}
