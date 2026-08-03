<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;
use App\Models\SantriModel;
use App\Models\HafalanModel;
use App\Models\UserModel;

class Statistik extends BaseController
{
    protected $santriModel;
    protected $hafalanModel;

    public function __construct()
    {
        $this->santriModel = new SantriModel();
        $this->hafalanModel = new HafalanModel();
    }

    public function index()
    {
        $userId = session()->get('id');
        $user   = (new UserModel())->find($userId);
        $id_wali = $user['ref_id'] ?? $userId;

        $data['anak'] = $this->santriModel->where('id_wali', $id_wali)->findAll();

        if (empty($data['anak'])) {
            $data['title'] = 'Statistik Hafalan';
            $data['icon']  = 'fa-solid fa-chart-line';
            return view('wali/statistik_hafalan', $data);
        }

        $id_santri_aktif = $this->request->getGet('anak');

        $santri = null;
        if ($id_santri_aktif) {
            foreach ($data['anak'] as $a) {
                if ($a['id'] == $id_santri_aktif) {
                    $santri = $a;
                    break;
                }
            }
        }

        if (!$santri) {
            $santri = $data['anak'][0];
        }

        $id_santri   = $santri['id'];
        $nama_santri = $santri['nama_lengkap'] ?? $santri['nama_santri'] ?? 'Ananda';

        $periode = $this->request->getGet('periode') ?? 'bulan_ini';

        $chartLabels   = [];
        $chartZiyadah  = [];
        $chartMurojaah = [];

        $rawGrafik = $this->hafalanModel->getGrafikAyatDuaGaris($id_santri, $periode);

        if (!empty($rawGrafik)) {
            foreach ($rawGrafik as $row) {
                $tgl = $row['tanggal'] ?? $row['created_at'] ?? date('Y-m-d');
                $chartLabels[]   = date('d M Y', strtotime($tgl));
                $chartZiyadah[]  = $row['ziyadah'] ?? 0;
                $chartMurojaah[] = $row['murojaah'] ?? 0;
            }
        } else {
            $chartLabels   = [date('d M Y')];
            $chartZiyadah  = [0];
            $chartMurojaah = [0];
        }

        $data['title']              = 'Statistik Hafalan';
        $data['icon']               = 'fa-solid fa-chart-line';
        $data['santri']             = $data['anak'];
        $data['selected_santri']    = $santri;
        $data['nama_santri']        = $nama_santri;
        $data['periode']            = $periode;

        $data['total_juz']          = $this->hafalanModel->getTotalJuzSelesai($id_santri);
        $data['streak']             = $this->hafalanModel->getStreakHarian($id_santri);
        $data['rata_predikat']      = $this->hafalanModel->getRataPredikatSantri($id_santri, $periode);
        $data['komposisi']          = $this->hafalanModel->getKomposisiSetoran($id_santri, $periode);
        $data['chart_labels']       = $chartLabels;
        $data['chart_ziyadah']      = $chartZiyadah;
        $data['chart_murojaah']     = $chartMurojaah;
        $data['detail_juz']         = $this->hafalanModel->getDetailCapaianJuz($id_santri, $periode);

        return view('wali/statistik_hafalan', $data);
    }
}
