<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['username' => 'admin', 'password' => password_hash('123', PASSWORD_DEFAULT), 'name' => 'Administrator', 'foto' => null, 'role' => 'admin', 'ref_id' => 0],
            ['username' => 'ust1', 'password' => password_hash('123', PASSWORD_DEFAULT), 'name' => 'Ustadz Bayhaqi', 'foto' => null, 'role' => 'ustadz', 'ref_id' => 1],
            ['username' => 'ust2', 'password' => password_hash('123', PASSWORD_DEFAULT), 'name' => 'Ustadz Jamaludin', 'foto' => null, 'role' => 'ustadz', 'ref_id' => 2],
            ['username' => 'wali1', 'password' => password_hash('123', PASSWORD_DEFAULT), 'name' => 'Gunawan', 'foto' => null, 'role' => 'wali', 'ref_id' => 1],
            ['username' => 'wali2', 'password' => password_hash('123', PASSWORD_DEFAULT), 'name' => 'Siti Aisyah', 'foto' => null, 'role' => 'wali', 'ref_id' => 2],
        ];
        $this->db->table('users')->insertBatch($data);
    }
}
