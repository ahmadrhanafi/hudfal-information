<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $data = [
            [
                'username' => 'admin',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'name' => 'Administrator',
                'foto' => null,
                'role' => 'admin',
                'ref_id' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'username' => 'ust1',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'name' => 'Ustadz Bayhaqi',
                'foto' => null,
                'role' => 'guru',
                'ref_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // [
            //     'username' => 'ustz2',
            //     'password' => password_hash('123', PASSWORD_DEFAULT),
            //     'name' => 'Ustadzah Syifa',
            //     'foto' => null,
            //     'role' => 'guru',
            //     'ref_id' => 2,
            //     'created_at' => $now,
            //     'updated_at' => $now,
            // ],
            [
                'username' => 'wali1',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'name' => 'Gunawan',
                'foto' => null,
                'role' => 'wali',
                'ref_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // [
            //     'username' => 'wali2',
            //     'password' => password_hash('123', PASSWORD_DEFAULT),
            //     'name' => 'Siti Aisyah',
            //     'foto' => null,
            //     'role' => 'wali',
            //     'ref_id' => 2,
            //     'created_at' => $now,
            //     'updated_at' => $now,
            // ],
        ];
        $this->db->table('users')->insertBatch($data);
    }
}
