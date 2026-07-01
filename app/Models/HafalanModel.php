<?php

namespace App\Models;

use CodeIgniter\Model;

class HafalanModel extends Model
{
    protected $table = 'hafalan';
    protected $allowedFields = ['id_santri', 'id_ustadz', 'surah', 'ayat_mulai', 'ayat_selesai', 'predikat', 'created_at'];

    // Fungsi khusus untuk statistik (Workflow Rule 2)
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
}
