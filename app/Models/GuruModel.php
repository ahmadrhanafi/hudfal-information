<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruModel extends Model
{
    protected $table      = 'guru';
    protected $primaryKey = 'id';

    // Hanya kolom ini yang bisa diisi
    protected $allowedFields = [
        'id',
        'nip',
        'nama',
        'jenis_kelamin',
        'id_kelas_diampu',
        'created_at',
        'updated_at'
    ];
}
