<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;
use App\Models\HafalanModel;
use App\Models\SantriModel;
use App\Models\GuruModel;

class RiwayatHafalan extends BaseController
{
    protected $hafalanModel;
    protected $santriModel;
    protected $guruModel;

    public function __construct()
    {
        $this->hafalanModel = new HafalanModel();
        $this->santriModel = new SantriModel();
        $this->guruModel = new GuruModel();

        if (!session()->get('logged_in') || session()->get('role') !== 'wali') {
            header('Location: ' . base_url('login'));
            exit();
        }
    }

    public function index()
    {
        $idWali = session()->get('ref_id') ?? session()->get('id');

        // Ambil semua anak wali beserta nama kelasnya
        $santriList = $this->santriModel->select('santri.*, kelas.nama_kelas')
            ->join('kelas', 'kelas.id = santri.id_kelas', 'left')
            ->where('santri.id_wali', $idWali)
            ->findAll();

        $idSantriDipilih = $this->request->getGet('id_santri');

        if (empty($idSantriDipilih) && !empty($santriList)) {
            $idSantriDipilih = $santriList[0]['id'];
        }

        $santriAktif = null;
        $riwayat = [];
        $periode = $this->request->getGet('periode') ?? 'bulan_ini';

        $statistik = [
            'juz_aktif' => '-',
            'total_setoran' => 0,
            'predikat_dominan' => '-'
        ];

        if (!empty($idSantriDipilih)) {
            // Ambil detail santri aktif beserta data guru pengajarnya via join tabel guru
            $santriAktif = $this->santriModel->select('santri.*, kelas.nama_kelas, guru.nama_guru, guru.no_hp as no_hp_guru')
                ->join('kelas', 'kelas.id = santri.id_kelas', 'left')
                ->join('guru', 'guru.id_kelas_diampu = santri.id_kelas', 'left')
                ->where('santri.id', $idSantriDipilih)
                ->first();

            if ($santriAktif) {
                // Ambil data riwayat dan ringkasan dengan filter periode
                $riwayat = $this->hafalanModel->getRiwayatBySantri($idSantriDipilih, $periode);
                $statistik = $this->hafalanModel->getStatistikRingkasBySantri($idSantriDipilih, $periode);
            }
        }

        $data = [
            'title' => 'Riwayat Hafalan',
            'icon' => 'fa-solid fa-history',
            'santri_list' => $santriList,
            'santri_aktif' => $santriAktif,
            'riwayat' => $riwayat,
            'periodeVal' => $periode,
            'juz_aktif' => $statistik['juz_aktif'],
            'total_setoran' => $statistik['total_setoran'],
            'predikat_dominan' => $statistik['predikat_dominan']
        ];

        return view('wali/riwayat_hafalan', $data);
    }
}
