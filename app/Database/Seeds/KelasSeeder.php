<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $data = [
            [
                'nama_kelas' => '1 Ibtida',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_kelas' => '2 Ibtida',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_kelas' => '3 Ibtida',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_kelas' => '4 Ibtida',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_kelas' => '5 Ibtida',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_kelas' => '6 Ibtida',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        $this->db->table('kelas')->insertBatch($data);
    }
}
