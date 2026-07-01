<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'username' => ['type' => 'VARCHAR', 'constraint' => 50],
            'password' => ['type' => 'VARCHAR', 'constraint' => 255],
            'role' => ['type' => 'ENUM', 'constraint' => ['admin', 'ustadz', 'wali']],
            'ref_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true], // ID Ustadz atau Wali
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        //
    }
}
