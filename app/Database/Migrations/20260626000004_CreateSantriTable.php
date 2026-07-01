<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSantriTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nis' => ['type' => 'VARCHAR', 'constraint' => 20],
            'nama' => ['type' => 'VARCHAR', 'constraint' => 100],
            'id_kelas' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_wali' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);
        $this->forge->addForeignKey('id_kelas', 'kelas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_wali', 'wali', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addKey('id', true);
        $this->forge->createTable('santri');
    }

    public function down()
    {
        $this->forge->dropTable('santri');
    }
}
