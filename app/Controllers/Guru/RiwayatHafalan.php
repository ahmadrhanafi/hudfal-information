<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\HafalanModel;
use App\Models\SantriModel;
use App\Models\GuruModel;
use App\Models\KelasModel;

class RiwayatHafalan extends BaseController
{
    protected $hafalanModel;
    protected $santriModel;
    protected $guruModel;
    protected $kelasModel;

    public function __construct()
    {
        $this->hafalanModel = new HafalanModel();
        $this->santriModel = new SantriModel();
        $this->guruModel = new GuruModel();
        $this->kelasModel = new KelasModel();

        if (!session()->get('logged_in') || session()->get('role') !== 'guru') {
            header('Location: ' . base_url('login'));
            exit();
        }
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        $namaGuru = session()->get('name');
        $idGuru = session()->get('ref_id');

        $idKelasGuru = session()->get('id_kelas');
        if (empty($idKelasGuru) && !empty($idGuru)) {
            $guru = $this->guruModel->find($idGuru);
            if (!$guru) {
                $guru = $this->guruModel->where('nama_guru', $namaGuru)->first();
            }
            $idKelasGuru = $guru['id_kelas_diampu'] ?? null;
        }

        // Ambil string nama kelas untuk ditampilkan di view
        $namaKelasString = '-';
        if (!empty($idKelasGuru)) {
            $kelas = $this->kelasModel->find($idKelasGuru);
            $namaKelasString = $kelas['nama_kelas'] ?? '-';
        }

        $builder = $this->santriModel->select('santri.*, kelas.nama_kelas, users.name as nama_wali, santri.foto')
            ->join('kelas', 'kelas.id = santri.id_kelas', 'left')
            ->join('users', 'users.ref_id = santri.id_wali AND users.role = "wali"', 'left');

        if (!empty($idKelasGuru)) {
            $builder->where('santri.id_kelas', $idKelasGuru);
        } else {
            $builder->where('santri.id_kelas', 0);
        }

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('santri.nama_santri', $keyword)
                ->orLike('santri.nis', $keyword)
                ->groupEnd();
        }

        $santri = $builder->orderBy('santri.nama_santri', 'ASC')->findAll();

        $idSantriKelas = array_column($santri, 'id');

        $totalSetoranBulanIni = 0;
        $santriAktifBulanIni = 0;
        $predikatUmum = 'Belum Ada';

        if (!empty($idSantriKelas)) {
            $bulanIni = date('m');
            $tahunIni = date('Y');

            $totalSetoranBulanIni = $this->hafalanModel->whereIn('id_santri', $idSantriKelas)
                ->where('MONTH(created_at)', $bulanIni)
                ->where('YEAR(created_at)', $tahunIni)
                ->countAllResults();

            $santriAktifBulanIni = $this->hafalanModel->select('id_santri')
                ->whereIn('id_santri', $idSantriKelas)
                ->where('MONTH(created_at)', $bulanIni)
                ->where('YEAR(created_at)', $tahunIni)
                ->groupBy('id_santri')
                ->countAllResults();

            $dominantPredikat = $this->hafalanModel->select('predikat, COUNT(predikat) as jumlah')
                ->whereIn('id_santri', $idSantriKelas)
                ->where('MONTH(created_at)', $bulanIni)
                ->where('YEAR(created_at)', $tahunIni)
                ->groupBy('predikat')
                ->orderBy('jumlah', 'DESC')
                ->first();

            if (!empty($dominantPredikat)) {
                $predikatUmum = ucwords($dominantPredikat['predikat']);
            }
        }

        $data = [
            'title' => 'Riwayat Hafalan',
            'santri' => $santri,
            'keyword' => $keyword,
            'nama_kelas' => $namaKelasString,
            'total_setoran_bulan_ini' => $totalSetoranBulanIni,
            'santri_aktif' => $santriAktifBulanIni,
            'total_santri' => count($santri),
            'predikat_umum' => $predikatUmum
        ];

        return view('guru/riwayat_hafalan', $data);
    }

    // Menampilkan detail riwayat setoran hafalan per santri
    public function detail($id_santri)
    {
        $santri = $this->santriModel->select('santri.*, kelas.nama_kelas, santri.foto')
            ->join('kelas', 'kelas.id = santri.id_kelas', 'left')
            ->where('santri.id', $id_santri)
            ->first();

        if (!$santri) {
            return redirect()->back()->with('error', 'Data santri tidak ditemukan.');
        }

        $riwayat = $this->hafalanModel->where('id_santri', $id_santri)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Detail Riwayat Hafalan - ' . $santri['nama_santri'],
            'icon' => 'fa-solid fa-book-quran',
            'santri' => $santri,
            'riwayat' => $riwayat
        ];

        return view('guru/_detail_riwayat_hafalan', $data);
    }

    public function ekspor()
    {
        $idGuru = session()->get('ref_id');
        $namaGuru = session()->get('name');
        $idKelasGuru = session()->get('id_kelas');

        if (empty($idKelasGuru) && !empty($idGuru)) {
            $guru = $this->guruModel->find($idGuru);
            if (!$guru) {
                $guru = $this->guruModel->where('nama_guru', $namaGuru)->first();
            }
            $idKelasGuru = $guru['id_kelas_diampu'] ?? null;
        }

        if (empty($idKelasGuru)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki kelas yang diampu untuk diekspor.');
        }

        $kelas = $this->kelasModel->find($idKelasGuru);
        $namaKelas = $kelas['nama_kelas'] ?? 'Kelas';

        $santri = $this->santriModel->select('santri.*, kelas.nama_kelas')
            ->join('kelas', 'kelas.id = santri.id_kelas', 'left')
            ->where('santri.id_kelas', $idKelasGuru)
            ->orderBy('santri.nama_santri', 'ASC')
            ->findAll();

        $filename = 'Rekap_Hafalan_' . str_replace(' ', '_', $namaKelas) . '_' . date('Y-m-d') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        fputcsv($output, ['No', 'NIS', 'Nama Santri', 'Jenis Kelamin', 'Kelas', 'Total Setoran Bulan Ini']);

        $no = 1;
        $bulanIni = date('m');
        $tahunIni = date('Y');

        foreach ($santri as $s) {
            $totalSetoran = $this->hafalanModel->where('id_santri', $s['id'])
                ->where('MONTH(created_at)', $bulanIni)
                ->where('YEAR(created_at)', $tahunIni)
                ->countAllResults();

            $jk = ($s['jenis_kelamin'] == 'L') ? 'Laki-laki' : 'Perempuan';

            fputcsv($output, [
                $no++,
                $s['nis'],
                $s['nama_santri'],
                $jk,
                $s['nama_kelas'],
                $totalSetoran . ' Setoran'
            ]);
        }

        fclose($output);
        exit();
    }
}
