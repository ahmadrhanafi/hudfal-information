<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\HafalanModel;
use App\Models\SantriModel;

class RiwayatHafalan extends BaseController
{
    protected $hafalanModel;
    protected $santriModel;

    public function __construct()
    {
        $this->hafalanModel = new HafalanModel();
        $this->santriModel = new SantriModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $idKelasGuru = session()->get('id_kelas');

        $builder = $this->santriModel->select('santri.*, kelas.nama_kelas, users.name as nama_wali')
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
            $hafalanModel = new \App\Models\HafalanModel();
            $bulanIni = date('m');
            $tahunIni = date('Y');

            $totalSetoranBulanIni = $hafalanModel->whereIn('id_santri', $idSantriKelas)
                ->where('MONTH(created_at)', $bulanIni)
                ->where('YEAR(created_at)', $tahunIni)
                ->countAllResults();

            $santriAktifBulanIni = $hafalanModel->select('id_santri')
                ->whereIn('id_santri', $idSantriKelas)
                ->where('MONTH(created_at)', $bulanIni)
                ->where('YEAR(created_at)', $tahunIni)
                ->groupBy('id_santri')
                ->countAllResults();

            $dominantPredikat = $hafalanModel->select('predikat, COUNT(predikat) as jumlah')
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
            'title'                   => 'Riwayat Hafalan Santri',
            'santri'                  => $santri,
            'keyword'                 => $keyword,
            'total_setoran_bulan_ini' => $totalSetoranBulanIni,
            'santri_aktif'            => $santriAktifBulanIni,
            'total_santri'            => count($santri),
            'predikat_umum'           => $predikatUmum
        ];

        return view('guru/riwayat_hafalan', $data);
    }

    // Menampilkan detail riwayat setoran hafalan per santri
    public function detail($id_santri)
    {
        $santri = $this->santriModel->select('santri.*, kelas.nama_kelas')
            ->join('kelas', 'kelas.id = santri.id_kelas', 'left')
            ->where('santri.id', $id_santri)
            ->first();

        if (!$santri) {
            return redirect()->back()->with('error', 'Data santri tidak ditemukan.');
        }

        // Ambil semua riwayat hafalan berdasarkan id_santri
        $riwayat = $this->hafalanModel->where('id_santri', $id_santri)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $data = [
            'title'   => 'Detail Riwayat Hafalan - ' . $santri['nama_santri'],
            'santri'  => $santri,
            'riwayat' => $riwayat
        ];

        return view('guru/_detail_riwayat_hafalan', $data); // Sesuaikan path view lo
    }
}
