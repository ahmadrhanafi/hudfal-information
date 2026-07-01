<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['username' => 'admin', 'password' => password_hash('123', PASSWORD_DEFAULT), 'name' => 'Administrator', 'role' => 'admin', 'ref_id' => 0],
            ['username' => 'ust1', 'password' => password_hash('123', PASSWORD_DEFAULT), 'name' => 'Ustadz Bayhaqi', 'role' => 'ustadz', 'ref_id' => 1],
            ['username' => 'ust2', 'password' => password_hash('123', PASSWORD_DEFAULT), 'name' => 'Ustadz Jamaludin', 'role' => 'ustadz', 'ref_id' => 2],
            ['username' => 'wali1', 'password' => password_hash('123', PASSWORD_DEFAULT), 'name' => 'Gunawan', 'role' => 'wali', 'ref_id' => 1],
            ['username' => 'wali2', 'password' => password_hash('123', PASSWORD_DEFAULT), 'name' => 'Siti Aisyah', 'role' => 'wali', 'ref_id' => 2],
        ];
        $this->db->table('users')->insertBatch($data);
    }
}
