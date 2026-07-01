<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_kelas' => 'Kelas 1'],
            ['nama_kelas' => 'Kelas 2'],
            ['nama_kelas' => 'Kelas 3'],
        ];
        $this->db->table('kelas')->insertBatch($data);
    }
}
