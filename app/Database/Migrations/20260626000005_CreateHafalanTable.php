<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHafalanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_santri' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_ustadz' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'surah' => ['type' => 'VARCHAR', 'constraint' => 100],
            'ayat_mulai' => ['type' => 'INT', 'constraint' => 5],
            'ayat_selesai' => ['type' => 'INT', 'constraint' => 5],
            'predikat' => ['type' => 'ENUM', 'constraint' => ['Mumtaz', 'Jayyid Jiddan', 'Jayyid']],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addForeignKey('id_santri', 'santri', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_ustadz', 'ustadz', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addKey('id', true);
        $this->forge->createTable('hafalan');
    }

    public function down()
    {
        //
    }
}
