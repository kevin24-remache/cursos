<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/*class CreateQueueJobsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'queue' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
                'null'       => false,
            ],
            'job' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'data' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'pending',
            ],
            'priority' => [
                'type'       => 'SMALLINT',
                'default'    => 0,
            ],
            'available_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'reserved_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'done_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'failed_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'attempts' => [
                'type'       => 'SMALLINT',
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('queue_jobs');
    }

    public function down()
    {
        $this->forge->dropTable('queue_jobs');
    }
}
*/