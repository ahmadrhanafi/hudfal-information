<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePembayaranTable extends Migration
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
            'id_santri' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'tanggal' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'jenis_pembayaran' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ], // Contoh: SPP Bulanan, Ujian, Infaq
            'jumlah' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2'
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Lunas', 'Pending', 'Menunggu Verifikasi', 'Gagal'],
                'default'    => 'Pending'
            ],
            'keterangan' => [
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
        $this->forge->addForeignKey('id_santri', 'santri', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pembayaran');
    }

    public function down()
    {
        $this->forge->dropTable('pembayaran', true);
    }
}
