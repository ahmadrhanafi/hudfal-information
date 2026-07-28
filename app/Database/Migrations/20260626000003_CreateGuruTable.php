<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGuruTable extends Migration
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
            'nip' => [
                'type' => 'VARCHAR',
                'constraint' => 30
            ],
            'nama_guru' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'jenis_kelamin' => [
                'type' => 'ENUM',
                'constraint' => ['L', 'P'],
                'default' => 'L'
            ],
            'id_kelas_diampu' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'status_aktif' => [
                'type' => 'ENUM',
                'constraint' => ['Aktif', 'Non-Aktif',],
                'default' => 'Aktif'
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
        $this->forge->addForeignKey('id_kelas_diampu', 'kelas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('guru');
    }

    public function down()
    {
        $this->forge->dropTable('guru');
    }
}
