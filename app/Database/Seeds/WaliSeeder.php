<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class WaliSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_wali'  => 'Raihan',
                'no_hp'      => '081234567890',
                'alamat'     => 'Jl. Merdeka No. 10, Jakarta',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_wali'  => 'Rasyid',
                'no_hp'      => '081987654321',
                'alamat'     => 'Jl. Sudirman No. 45, Bogor',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_wali'  => 'Ahmad Fauzi',
                'no_hp'      => '085611223344',
                'alamat'     => 'Jl. KH. Hasyim Ashari No. 12, Tangerang',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        // Masukkan data secara batch ke dalam tabel wali
        $this->db->table('wali')->insertBatch($data);
    }
}
