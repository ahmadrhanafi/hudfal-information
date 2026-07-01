<?php

namespace App\Models;

use CodeIgniter\Model;

class UstadzModel extends Model
{
    protected $table      = 'ustadz';
    protected $primaryKey = 'id';

    // Hanya kolom ini yang bisa diisi
    protected $allowedFields = ['nip', 'nama', 'id_kelas_diampu'];
}
