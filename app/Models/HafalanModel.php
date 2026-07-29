<?php

namespace App\Models;

use CodeIgniter\Model;

class HafalanModel extends Model
{
    protected $table            = 'hafalan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    // Sesuaikan dengan kolom yang ada di database migration
    protected $allowedFields    = [
        'id_santri',
        'id_guru',
        'jenis',
        'juz',
        'surah',
        'ayat_mulai',
        'ayat_selesai',
        'predikat',
        'keterangan'
    ];

    // Mengaktifkan fitur timestamp otomatis (created_at & updated_at)
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Fungsi untuk mengambil data hafalan lengkap dengan relasi santri dan guru
    public function getHafalanWithRelations($id = null)
    {
        $builder = $this->select('hafalan.*, santri.nama_santri, guru.nama_guru')
            ->join('santri', 'santri.id = hafalan.id_santri')
            ->join('guru', 'guru.id = hafalan.id_guru');

        if ($id) {
            return $builder->where('hafalan.id', $id)->first();
        }

        return $builder->orderBy('hafalan.created_at', 'DESC')->findAll();
    }

    // Fungsi khusus untuk statistik
    public function getStatistikHafalan($id_santri = null)
    {
        $builder = $this->db->table('hafalan');
        $builder->select('surah, COUNT(*) as jumlah_setoran');
        if ($id_santri) {
            $builder->where('id_santri', $id_santri);
        }
        $builder->groupBy('surah');
        return $builder->get()->getResultArray();
    }

    public function getHafalanByGuru($idGuru)
    {
        return $this->select('hafalan.*, santri.nama_santri, guru.nama_guru')
            ->join('santri', 'santri.id = hafalan.id_santri')
            ->join('guru', 'guru.id = hafalan.id_guru')
            ->where('hafalan.id_guru', $idGuru)
            ->orderBy('hafalan.created_at', 'DESC')
            ->findAll();
    }
}
