<?php

namespace App\Models;

use CodeIgniter\Model;

class SantriModel extends Model
{
    protected $table = 'santri';
    protected $primaryKey = 'id';

    // Hanya kolom ini yang boleh diisi melalui input user
    protected $allowedFields = ['nis', 'nama', 'id_kelas', 'id_wali'];

    // Validasi otomatis di tingkat model (Layer pertahanan 1)
    protected $validationRules = [
        'nis'      => 'required|is_unique[santri.nis]',
        'nama'     => 'required|alpha_space|min_length[3]',
        'id_kelas' => 'required|is_natural_no_zero',
        'id_wali'  => 'required|is_natural_no_zero',
    ];
}
