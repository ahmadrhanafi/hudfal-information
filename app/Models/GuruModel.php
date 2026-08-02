<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruModel extends Model
{
    protected $table            = 'guru';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nip', 'nama_guru', 'jenis_kelamin', 'id_kelas_diampu', 'status_aktif', 'no_hp'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getGuruWithKelas()
    {
        return $this->select('guru.*, kelas.nama_kelas')
            ->from('guru')
            ->join('kelas', 'kelas.id = guru.id_kelas_diampu', 'left')
            ->findAll();
    }
}
