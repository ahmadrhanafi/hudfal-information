<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TambahKolomPembayaran extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pembayaran', [
            'bukti_pembayaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'bank_tujuan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'tanggal_konfirmasi' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pembayaran', ['bukti_pembayaran', 'bank_tujuan', 'tanggal_konfirmasi']);
    }
}
