<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUstadzTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nip' => ['type' => 'VARCHAR', 'constraint' => 30],
            'nama' => ['type' => 'VARCHAR', 'constraint' => 100],
            'id_kelas_diampu' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);
        $this->forge->addForeignKey('id_kelas_diampu', 'kelas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addKey('id', true);
        $this->forge->createTable('ustadz');
    }

    public function down()
    {
        //
    }
}
