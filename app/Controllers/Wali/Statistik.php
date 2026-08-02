<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;
use App\Models\SantriModel;
use App\Models\HafalanModel;
use App\Models\UserModel;
use Dompdf\Dompdf;

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

        $santri = $this->santriModel->where('id_wali', $id_wali)->first();

        $id_santri   = $santri['id'] ?? null;
        $nama_santri = $santri['nama_santri'] ?? 'Ananda';

        $periode = $this->request->getGet('periode') ?? 'bulan_ini';

        $rawGrafik = $this->hafalanModel->getGrafikAyatBulanan($id_santri, $periode);

        $chartLabels = [];
        $chartData   = [];

        if (!empty($rawGrafik)) {
            foreach ($rawGrafik as $row) {
                $tgl = $row['tanggal'] ?? $row['created_at'] ?? date('Y-m-d');
                $chartLabels[] = date('d M Y', strtotime($tgl));
                $chartData[]   = $row['total'] ?? 0;
            }
        } else {
            $chartLabels = ['-'];
            $chartData   = [0];
        }

        $data = [
            'title'         => 'Statistik Hafalan Ananda',
            'santri'        => $santri,
            'nama_santri'   => $nama_santri,
            'periode'       => $periode,
            'total_juz'     => $this->hafalanModel->getTotalJuzSelesai($id_santri, $periode),
            'streak'        => $this->hafalanModel->getStreakHarian($id_santri),
            'rata_predikat' => $this->hafalanModel->getRataPredikatSantri($id_santri, $periode),
            'komposisi'     => $this->hafalanModel->getKomposisiSetoran($id_santri, $periode),
            'chart_labels'  => $chartLabels,
            'chart_data'    => $chartData,
            'detail_juz'    => $this->hafalanModel->getDetailCapaianJuz($id_santri, $periode),
        ];

        return view('wali/statistik_hafalan', $data);
    }

    // Method untuk Unduh Laporan Statistik Ananda oleh Wali
    public function export()
    {
        $userId = session()->get('id');
        $user   = (new UserModel())->find($userId);
        $id_wali = $user['ref_id'] ?? $userId;

        $santri = $this->santriModel->where('id_wali', $id_wali)->first();
        $id_santri   = $santri['id'] ?? null;
        $nama_santri = $santri['nama_santri'] ?? 'Ananda';

        $periode = $this->request->getGet('periode') ?? 'bulan_ini';

        $data = [
            'nama_santri'    => $nama_santri,
            'periode'        => $periode,
            'total_juz'      => $this->hafalanModel->getTotalJuzSelesai($id_santri, $periode),
            'rata_predikat'  => $this->hafalanModel->getRataPredikatSantri($id_santri, $periode),
            'komposisi'      => $this->hafalanModel->getKomposisiSetoran($id_santri, $periode),
            'detail_hafalan' => $this->hafalanModel->getDetailHafalanSantriByPeriode($id_santri, $periode),
        ];

        return view('wali/cetak_laporan_santri', $data);
    }
}
