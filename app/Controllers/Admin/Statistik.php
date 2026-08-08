<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\HafalanModel;

class Statistik extends BaseController
{
    protected $hafalanModel;

    public function __construct()
    {
        $this->hafalanModel = new HafalanModel();
    }

    public function index()
    {
        $periode = $this->request->getGet('periode') ?? 'tahun_ini';

        $data = [
            'title' => 'Statistik Hafalan',
            'icon' => 'fa-solid fa-chart-line',
            'periode' => $periode,
            'rata_setoran' => $this->hafalanModel->getRataRataGlobal($periode),
            'juz_dominan' => $this->hafalanModel->getJuzDominanGlobal($periode),
            'predikat_umum' => $this->hafalanModel->getPredikatTerbanyakGlobal($periode),
            'capaian_juz' => $this->hafalanModel->getProgressJuzGlobal($periode),
            'grafik_setoran' => $this->hafalanModel->getGrafikSetoranGlobal($periode),
        ];

        return view('admin/statistik_hafalan', $data);
    }

    public function export()
    {
        $periode = $this->request->getGet('periode') ?? 'tahun_ini';

        $data = [
            'periode' => $periode,
            'rata_setoran' => $this->hafalanModel->getRataRataGlobal($periode),
            'juz_dominan' => $this->hafalanModel->getJuzDominanGlobal($periode),
            'predikat_umum' => $this->hafalanModel->getPredikatTerbanyakGlobal($periode),
            'capaian_juz' => $this->hafalanModel->getProgressJuzGlobal($periode),
            'grafik_setoran' => $this->hafalanModel->getGrafikSetoranGlobal($periode),
        ];

        $html = view('admin/cetak_statistik_hafalan', $data);

        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $nama_file = 'Laporan_Statistik_Setiap_Santri_' . strtoupper($periode) . '.pdf';

        $dompdf->stream($nama_file, ['Attachment' => true]);
        exit;
    }
}
