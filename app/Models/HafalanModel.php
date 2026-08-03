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

    // ==========================================
    // GLOBAL DI DASHBOARD ADMIN    
    // ==========================================

    // Contoh fungsi pendukung di HafalanModel.php untuk Admin
    public function getRataRataGlobal($periode = 'tahun_ini')
    {
        // Sesuaikan logika filter tanggal berdasarkan $periode ('bulan_ini', 'semester_ini', 'tahun_ini')
        // Contoh return nilai rata-rata ayat/hari:
        return 24.5;
    }

    public function getJuzDominanGlobal($periode = 'tahun_ini')
    {
        return ['juz' => '30', 'persen' => 42];
    }

    public function getPredikatTerbanyakGlobal($periode = 'tahun_ini')
    {
        return 'Mumtaz';
    }

    public function getProgressJuzGlobal($periode = 'tahun_ini')
    {
        $builder = $this->db->table($this->table);

        if ($periode == 'bulan_ini') {
            $builder->where('MONTH(created_at)', date('m'));
            $builder->where('YEAR(created_at)', date('Y'));
        } elseif ($periode == 'bulan_lalu') {
            $builder->where('MONTH(created_at)', date('m', strtotime('-1 month')));
            $builder->where('YEAR(created_at)', date('Y', strtotime('-1 month')));
        } elseif ($periode == 'tahun_lalu') {
            $builder->where('YEAR(created_at)', date('Y', strtotime('-1 year')));
        } else {
            $builder->where('YEAR(created_at)', date('Y'));
        }

        $builder->select("juz, SUM((ayat_selesai - ayat_mulai) + 1) as total_ayat_juz");
        $builder->groupBy("juz");
        $result = $builder->get()->getResultArray();

        $grandTotalAyat = array_sum(array_column($result, 'total_ayat_juz'));

        $dataMentah = [];
        foreach ($result as $row) {
            $juzAngka = $row['juz'];
            $jumlahAyat = (int)$row['total_ayat_juz'];
            $persen = ($grandTotalAyat > 0) ? round(($jumlahAyat / $grandTotalAyat) * 100) : 0;

            $dataMentah[] = [
                'nama' => 'Juz ' . $juzAngka,
                'persen' => $persen,
                'total' => $jumlahAyat
            ];
        }

        usort($dataMentah, function ($a, $b) {
            return $b['total'] <=> $a['total'];
        });

        $warnaList = ['success', 'primary', 'warning', 'info', 'danger', 'secondary'];
        $output = [];

        foreach ($dataMentah as $index => $item) {
            $output[] = [
                'nama' => $item['nama'],
                'persen' => $item['persen'],
                'color' => $warnaList[$index % count($warnaList)]
            ];
        }

        if (empty($output)) {
            $output = [
                ['nama' => 'Belum ada data setoran', 'persen' => 0, 'color' => 'secondary']
            ];
        }

        return $output;
    }

    public function getGrafikSetoranGlobal($periode = 'bulan_ini')
    {
        $builder = $this->db->table($this->table);
        $labels = [];
        $values = [];

        // 1. JIKA FILTER MINGGU INI -> Tampilkan per Hari dalam Minggu Ini (Senin - Minggu)
        if ($periode == 'minggu_ini') {
            $builder->select("DATE(created_at) as tanggal, MIN(created_at) as created_at, COUNT(DISTINCT id_santri) as total_santri");
            $builder->where('YEARWEEK(created_at, 1)', 'YEARWEEK(NOW(), 1)');
            $builder->groupBy("DATE(created_at)");
            $result = $builder->get()->getResultArray();

            $dataPerHari = [];
            foreach ($result as $row) {
                $translation = [
                    'Monday' => 'Senin',
                    'Tuesday' => 'Selasa',
                    'Wednesday' => 'Rabu',
                    'Thursday' => 'Kamis',
                    'Friday' => 'Jumat',
                    'Saturday' => 'Sabtu',
                    'Sunday' => 'Minggu'
                ];
                $hariIndo = $translation[$row['nama_hari']] ?? $row['nama_hari'];
                $dataPerHari[$hariIndo] = (int)$row['total_santri'];
            }

            $daftarHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            foreach ($daftarHari as $hari) {
                $labels[] = $hari;
                $values[] = $dataPerHari[$hari] ?? 0;
            }
        }
        // 2. JIKA FILTER BULAN INI -> Tampilkan per Tanggal (1 sampai 30/31)
        elseif ($periode == 'bulan_ini') {
            $targetBulan = date('m');
            $targetTahun = date('Y');
            $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $targetBulan, $targetTahun);

            $builder->select("DAY(created_at) as hari_angka, COUNT(DISTINCT id_santri) as total_santri");
            $builder->where('MONTH(created_at)', $targetBulan);
            $builder->where('YEAR(created_at)', $targetTahun);
            $builder->groupBy("DAY(created_at)");
            $result = $builder->get()->getResultArray();

            $dataPerHari = [];
            foreach ($result as $row) {
                $dataPerHari[(int)$row['hari_angka']] = (int)$row['total_santri'];
            }

            for ($i = 1; $i <= $jumlahHari; $i++) {
                $labels[] = $i;
                $values[] = $dataPerHari[$i] ?? 0;
            }
        }
        // 3. JIKA FILTER TAHUN INI -> Tampilkan 12 Bulan (Januari - Desember)
        else {
            $tahunDipilih = date('Y');

            $builder->select("MONTH(created_at) as bulan_angka, COUNT(DISTINCT id_santri) as total_santri");
            $builder->where('YEAR(created_at)', $tahunDipilih);
            $builder->groupBy("MONTH(created_at)");
            $result = $builder->get()->getResultArray();

            $dataPerBulan = [];
            foreach ($result as $row) {
                $dataPerBulan[(int)$row['bulan_angka']] = (int)$row['total_santri'];
            }

            $namaBulan = [
                1 => 'Jan',
                2 => 'Feb',
                3 => 'Mar',
                4 => 'Apr',
                5 => 'Mei',
                6 => 'Jun',
                7 => 'Jul',
                8 => 'Agu',
                9 => 'Sep',
                10 => 'Okt',
                11 => 'Nov',
                12 => 'Des'
            ];

            for ($i = 1; $i <= 12; $i++) {
                $labels[] = $namaBulan[$i];
                $values[] = $dataPerBulan[$i] ?? 0;
            }
        }

        return [
            'labels' => $labels,
            'values' => $values
        ];
    }

    // -------------------------------------------------------------------------

    // Fungsi untuk mengambil data hafalan lengkap dengan relasi santri dan guru
    public function getHafalanWithRelations($id = null)
    {
        $builder = $this->select('hafalan.*, santri.nama_santri, guru.nama_guru, kelas.nama_kelas AS nama_kelas')
            ->join('santri', 'santri.id = hafalan.id_santri', 'left')
            ->join('guru', 'guru.id = hafalan.id_guru', 'left')
            ->join('kelas', 'kelas.id = guru.id_kelas_diampu', 'left');

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
        $builder = $this->db->table('hafalan');
        $builder->select('
        santri.nama_santri, 
        COUNT(hafalan.id) as frekuensi_setor, 
        SUM((hafalan.ayat_selesai - hafalan.ayat_mulai) + 1) as total_ayat,
        AVG((hafalan.ayat_selesai - hafalan.ayat_mulai) + 1) as rata_ayat,
        MAX(hafalan.juz) as juz_terakhir
    ');
        $builder->join('santri', 'santri.id = hafalan.id_santri');
        $builder->where('hafalan.id_guru', $id_guru);

        // Contoh filter periode sederhana
        if ($periode == 'bulan_ini') {
            $builder->where('MONTH(hafalan.created_at)', date('m'));
            $builder->where('YEAR(hafalan.created_at)', date('Y'));
        }

        $builder->groupBy('hafalan.id_santri');
        $builder->orderBy('total_ayat', 'DESC');

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

    public function getGrafikAyatDuaGaris($id_santri, $periode)
    {
        $builder = $this->db->table('hafalan');
        $builder->select("DATE(created_at) as tanggal, 
                      SUM(CASE WHEN jenis = 'ziyadah' THEN (ayat_selesai - ayat_mulai + 1) ELSE 0 END) as ziyadah,
                      SUM(CASE WHEN jenis = 'murojaah' THEN (ayat_selesai - ayat_mulai + 1) ELSE 0 END) as murojaah");
        $builder->where('id_santri', $id_santri);

        if ($periode == 'bulan_ini') {
            $builder->where('MONTH(created_at)', date('m'));
            $builder->where('YEAR(created_at)', date('Y'));
        } elseif ($periode == 'minggu_ini') {
            $builder->where('created_at >=', date('Y-m-d', strtotime('-7 days')));
        }

        $builder->groupBy('DATE(created_at)');
        $builder->orderBy('tanggal', 'ASC');

        return $builder->get()->getResultArray();
    }


    // ==========================================
    // TAMBAHAN UNTUK RIWAYAT & STATISTIK WALI
    // ==========================================

    public function getRiwayatBySantri($idSantri, $periode = 'bulan_ini')
    {
        if (!$idSantri) return [];

        $builder = $this->select('hafalan.*, guru.nama_guru, guru.no_hp')
            ->join('guru', 'guru.id = hafalan.id_guru', 'left')
            ->where('hafalan.id_santri', $idSantri);

        $this->applyPeriodeFilter($builder, $periode);

        return $builder->orderBy('hafalan.created_at', 'DESC')->findAll();
    }

    public function getStatistikRingkasBySantri($idSantri, $periode = 'bulan_ini')
    {
        if (!$idSantri) {
            return [
                'juz_aktif' => '-',
                'total_setoran' => 0,
                'predikat_dominan' => '-'
            ];
        }

        $riwayatFiltered = $this->getRiwayatBySantri($idSantri, $periode);
        $totalSetoran = count($riwayatFiltered);

        $juzQuery = $this->select('juz')
            ->where('id_santri', $idSantri);
        $this->applyPeriodeFilter($juzQuery, $periode);
        $juzData = $juzQuery->orderBy('created_at', 'DESC')->first();
        $juzAktif = $juzData ? 'Juz ' . $juzData['juz'] : '-';

        $predikatData = $this->getRataPredikatSantri($idSantri);
        $predikatDominan = is_array($predikatData) ? ($predikatData['predikat'] ?? '-') : '-';

        return [
            'juz_aktif'        => $juzAktif,
            'total_setoran'    => $totalSetoran,
            'predikat_dominan' => $predikatDominan
        ];
    }
}
