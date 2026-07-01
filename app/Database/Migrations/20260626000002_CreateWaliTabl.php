<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWaliTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama' => ['type' => 'VARCHAR', 'constraint' => 100],
            'no_hp' => ['type' => 'VARCHAR', 'constraint' => 20],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('wali');
    }

    public function down()
    {
        //
    }
}
