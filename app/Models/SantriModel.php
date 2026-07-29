<?php

namespace App\Models;

use CodeIgniter\Model;

class SantriModel extends Model
{
    protected $table            = 'santri';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Tambahkan field baru di sini agar bisa di-insert/update
    protected $allowedFields    = [
        'nis',
        'nama_santri',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'id_kelas',
        'id_wali',
        'uid_kartu',
        'status_aktif'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Fungsi untuk mengambil data santri beserta relasi
    public function getSantriWithRelations($id = null)
    {
        $builder = $this->select('santri.*, kelas.nama_kelas, wali.nama_wali, wali.no_hp as no_hp_wali, wali.alamat AS alamat_wali')
            ->join('kelas', 'kelas.id = santri.id_kelas', 'left')
            ->join('wali', 'wali.id = santri.id_wali', 'left');

        if ($id === null) {
            return $builder->findAll();
        }

        return $builder->where('santri.id', $id)->first();
    }

    public function searchSantri($keyword = null, $idKelas = null, $status = null)
    {
        $builder = $this->select('santri.*, kelas.nama_kelas, wali.nama_wali, wali.no_hp as no_hp_wali, wali.alamat as alamat_wali')
            ->join('kelas', 'kelas.id = santri.id_kelas', 'left')
            ->join('wali', 'wali.id = santri.id_wali', 'left');

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('santri.nama_santri', $keyword)
                ->orLike('santri.nis', $keyword)
                ->orLike('wali.nama_wali', $keyword)
                ->groupEnd();
        }

        if (!empty($idKelas)) {
            $builder->where('santri.id_kelas', $idKelas);
        }

        // Tambahan filter berdasarkan status_aktif
        if (!empty($status)) {
            $builder->where('santri.status_aktif', $status);
        }

        return $builder->findAll();
    }

    public function getSantriByKelas($idKelas)
    {
        return $this->select('santri.*, kelas.nama_kelas')
            ->join('kelas', 'kelas.id = santri.id_kelas', 'inner')
            ->where('santri.id_kelas', $idKelas)
            ->findAll();
    }
}
