<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWaliTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'nama_wali' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'no_hp' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('wali');
    }

    public function down()
    {
        $this->forge->dropTable('wali');
    }
}
