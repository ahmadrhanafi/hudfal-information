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

        return $builder->orderBy('hafalan.created_at', 'DESC');
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
            ->orderBy('hafalan.created_at', 'DESC');
    }

    public function getRiwayatHafalan()
    {
        return $this->select('hafalan.*, santri.nama_santri')
            ->join('santri', 'santri.id = hafalan.id_santri', 'left')
            ->orderBy('hafalan.created_at', 'DESC')
            ->findAll();
    }

    // ==========================================
    // HELPER FILTER PERIODE
    // ==========================================
    private function applyPeriodeFilter($builder, $periode)
    {
        if ($periode == 'minggu_ini') {
            $builder->where('hafalan.created_at >=', date('Y-m-d', strtotime('-7 days')));
        } elseif ($periode == 'bulan_ini') {
            $builder->where('MONTH(hafalan.created_at)', date('m'))
                ->where('YEAR(hafalan.created_at)', date('Y'));
        } elseif ($periode == 'semester_ini') {
            $bulanIni = date('n');
            $tahunIni = date('Y');
            if ($bulanIni >= 1 && $bulanIni <= 6) {
                $builder->where('hafalan.created_at >=', "$tahunIni-01-01")
                    ->where('hafalan.created_at <=', "$tahunIni-06-30");
            } else {
                $builder->where('hafalan.created_at >=', "$tahunIni-07-01")
                    ->where('hafalan.created_at <=', "$tahunIni-12-31");
            }
        }
        return $builder;
    }

    // ==========================================
    // STATISTIK KELAS (DENGAN FILTER PERIODE)
    // ==========================================

    public function getRataRataKelas($id_guru, $periode = 'bulan_ini')
    {
        if (!$id_guru) return 0;

        $builder = $this->select("AVG((ayat_selesai - ayat_mulai) + 1) as rata_rata")
            ->where('id_guru', $id_guru);

        $this->applyPeriodeFilter($builder, $periode);
        $result = $builder->first();

        return round($result['rata_rata'] ?? 0, 1);
    }

    public function getJuzDominanKelas($id_guru, $periode = 'bulan_ini')
    {
        if (!$id_guru) return ['nama' => 'Juz 30', 'persentase' => 0];

        $builder = $this->select('juz, COUNT(*) as total')
            ->where('id_guru', $id_guru);

        $this->applyPeriodeFilter($builder, $periode);
        $query = $builder->groupBy('juz')
            ->orderBy('total', 'DESC')
            ->first();

        if (!$query) return ['nama' => 'Juz 30', 'persentase' => 0];

        // Hitung total keseluruhan pada periode yang sama
        $builderTotal = $this->where('id_guru', $id_guru);
        $this->applyPeriodeFilter($builderTotal, $periode);
        $totalSemua = $builderTotal->countAllResults(false);

        $persentase = $totalSemua > 0 ? round(($query['total'] / $totalSemua) * 100) : 0;

        return [
            'nama' => 'Juz ' . $query['juz'],
            'persentase' => $persentase
        ];
    }

    public function getPredikatTerbanyakKelas($id_guru, $periode = 'bulan_ini')
    {
        if (!$id_guru) return ['predikat' => 'Mumtaz', 'keterangan' => 'Sangat Baik'];

        $builder = $this->select('predikat, COUNT(*) as total')
            ->where('id_guru', $id_guru);

        $this->applyPeriodeFilter($builder, $periode);
        $query = $builder->groupBy('predikat')
            ->orderBy('total', 'DESC')
            ->first();

        $predikat = $query['predikat'] ?? 'Mumtaz';

        $ket = 'Sangat Baik';
        if ($predikat == 'Jayyid Jiddan') $ket = 'Baik Sekali';
        elseif ($predikat == 'Jayyid') $ket = 'Baik';

        return ['predikat' => $predikat, 'keterangan' => $ket];
    }

    public function getProgressJuzKelas($id_guru, $periode = 'bulan_ini')
    {
        if (!$id_guru) return [];

        $builder = $this->select('juz, COUNT(*) as jumlah')
            ->where('id_guru', $id_guru);

        $this->applyPeriodeFilter($builder, $periode);
        return $builder->groupBy('juz')->findAll();
    }

    public function getGrafikSetoranKelas($id_guru, $periode = 'bulan_ini')
    {
        if (!$id_guru) return [];

        $builder = $this->select("DATE(created_at) as created_at, COUNT(*) as total")
            ->where('id_guru', $id_guru);

        $this->applyPeriodeFilter($builder, $periode);
        return $builder->groupBy("DATE(created_at)")
            ->orderBy("DATE(created_at)", "ASC")
            ->findAll();
    }

    // Method untuk mengambil rincian data laporan cetak
    public function getDetailHafalanByPeriode($id_guru, $periode = 'bulan_ini')
    {
        if (!$id_guru) return [];

        $this->select('hafalan.*, santri.nama_santri');
        $this->join('santri', 'santri.id = hafalan.id_santri');
        $this->where('hafalan.id_guru', $id_guru);

        $this->applyPeriodeFilter($this, $periode);

        return $this->orderBy('hafalan.created_at', 'DESC')->findAll();
    }

    public function getRekapSantriKelas($id_guru, $periode = 'bulan_ini')
    {
        if (!$id_guru) return [];

        $builder = $this->db->table('hafalan');
        $builder->select('santri.nama_santri, COUNT(hafalan.id) as total_setoran, AVG((hafalan.ayat_selesai - hafalan.ayat_mulai) + 1) as rata_ayat, MAX(hafalan.juz) as juz_terakhir');
        $builder->join('santri', 'santri.id = hafalan.id_santri');
        $builder->where('hafalan.id_guru', $id_guru);

        $this->applyPeriodeFilter($builder, $periode);

        $builder->groupBy('hafalan.id_santri');
        return $builder->get()->getResultArray();
    }

    // ==========================================
    // --- Statistik Khusus Wali Santri ---
    // ==========================================

    public function getDetailHafalanSantriByPeriode($id_santri, $periode = 'bulan_ini')
    {
        if (!$id_santri) return [];
        $builder = $this->select('*')->where('id_santri', $id_santri);
        $this->applyPeriodeFilter($builder, $periode);
        return $builder->orderBy('created_at', 'DESC')->findAll();
    }

    public function getTotalJuzSelesai($id_santri)
    {
        if (!$id_santri) return 0;

        $result = $this->select('COUNT(DISTINCT juz) as total_juz')
            ->where('id_santri', $id_santri)
            ->first();

        return $result['total_juz'] ?? 0;
    }

    public function getStreakHarian($id_santri)
    {
        if (!$id_santri) return 0;
        return 14; // Default/dummy aman untuk streak aktif
    }

    public function getRataPredikatSantri($id_santri)
    {
        if (!$id_santri) return ['predikat' => '-', 'keterangan' => '-'];

        $query = $this->select('predikat, COUNT(*) as total')
            ->where('id_santri', $id_santri)
            ->groupBy('predikat')
            ->orderBy('total', 'DESC')
            ->first();

        $predikat = $query['predikat'] ?? 'Mumtaz';
        return ['predikat' => $predikat, 'keterangan' => 'Sangat Baik'];
    }

    public function getKomposisiSetoran($id_santri)
    {
        if (!$id_santri) return ['ziyadah' => 0, 'murojaah' => 0];

        $total = $this->where('id_santri', $id_santri)->countAllResults();
        if ($total == 0) return ['ziyadah' => 0, 'murojaah' => 0];

        $ziyadah = $this->where('id_santri', $id_santri)->where('jenis', 'ziyadah')->countAllResults();

        $persenZiyadah = round(($ziyadah / $total) * 100);
        $persenMurojaah = 100 - $persenZiyadah;

        return [
            'ziyadah' => $persenZiyadah,
            'murojaah' => $persenMurojaah
        ];
    }

    public function getGrafikAyatBulanan($id_santri, $periode = 'bulan_ini')
    {
        $builder = $this->db->table('hafalan'); // Sesuaikan nama tabel kamu
        $builder->select('DATE(created_at) as created_at, COUNT(*) as total');
        $builder->where('id_santri', $id_santri);

        // Filter berdasarkan periode
        if ($periode == 'minggu_ini') {
            $builder->where('created_at >=', date('Y-m-d', strtotime('-7 days')));
        } elseif ($periode == 'bulan_ini') {
            $builder->where('MONTH(created_at)', date('m'));
            $builder->where('YEAR(created_at)', date('Y'));
        } elseif ($periode == 'semester_ini') {
            $builder->where('created_at >=', date('Y-m-d', strtotime('-6 months')));
        }

        $builder->groupBy('DATE(created_at)');
        $builder->orderBy('created_at', 'ASC');

        return $builder->get()->getResultArray();
    }

    public function getDetailCapaianJuz($id_santri, $periode = 'bulan_ini')
    {
        if (!$id_santri) return [];

        $builder = $this->select('juz, MAX(surah) as surah, COUNT(id) as total_setoran, MAX(predikat) as predikat')
            ->where('id_santri', $id_santri);

        $this->applyPeriodeFilter($builder, $periode);

        return $builder->groupBy('juz')->findAll();
    }
}
