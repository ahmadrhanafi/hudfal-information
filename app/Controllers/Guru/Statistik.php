<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\KelasModel;
use App\Models\HafalanModel;
use Dompdf\Dompdf;

class Statistik extends BaseController
{
    protected $guruModel;
    protected $kelasModel;
    protected $hafalanModel;

    public function __construct()
    {
        $this->guruModel = new GuruModel();
        $this->kelasModel = new KelasModel();
        $this->hafalanModel = new HafalanModel();
    }

    public function index()
    {
        $userId = session()->get('id');
        $user   = (new \App\Models\UserModel())->find($userId);

        $id_guru = $user['ref_id'] ?? null;
        $guru = $this->guruModel->find($id_guru);
        $id_kelas_diampu = $guru['id_kelas_diampu'] ?? null;

        $kelas = $this->kelasModel->find($id_kelas_diampu);
        $nama_kelas = $kelas['nama_kelas'] ?? 'Belum Ada Kelas';

        $periode = $this->request->getGet('periode') ?? 'bulan_ini';

        $data = [
            'title'          => 'Statistik Hafalan Kelas',
            'nama_kelas'     => $nama_kelas,
            'rata_setoran'   => $this->hafalanModel->getRataRataKelas($id_guru, $periode),
            'juz_dominan'    => $this->hafalanModel->getJuzDominanKelas($id_guru, $periode),
            'predikat_umum'  => $this->hafalanModel->getPredikatTerbanyakKelas($id_guru, $periode),
            'capaian_juz'    => $this->hafalanModel->getProgressJuzKelas($id_guru, $periode),
            'grafik_setoran' => $this->hafalanModel->getGrafikSetoranKelas($id_guru, $periode),
            'rekap_santri'    => $this->hafalanModel->getRekapSantriKelas($id_guru, $periode),
        ];

        return view('guru/statistik_hafalan', $data);
    }

    public function export()
    {
        $userId = session()->get('id');
        $user   = (new \App\Models\UserModel())->find($userId);
        $id_guru = $user['ref_id'] ?? null;

        $guru = $this->guruModel->find($id_guru);
        $id_kelas_diampu = $guru['id_kelas_diampu'] ?? null;
        $kelas = $this->kelasModel->find($id_kelas_diampu);

        $periode = $this->request->getGet('periode') ?? 'bulan_ini';

        $data = [
            'nama_guru'      => $guru['nama_guru'] ?? '-',
            'nama_kelas'     => $kelas['nama_kelas'] ?? '-',
            'periode'        => $periode,
            'rata_setoran'   => $this->hafalanModel->getRataRataKelas($id_guru, $periode),
            'juz_dominan'    => $this->hafalanModel->getJuzDominanKelas($id_guru, $periode),
            'predikat_umum'  => $this->hafalanModel->getPredikatTerbanyakKelas($id_guru, $periode),
            'capaian_juz'    => $this->hafalanModel->getProgressJuzKelas($id_guru, $periode),
            'detail_hafalan' => $this->hafalanModel->getDetailHafalanByPeriode($id_guru, $periode),
        ];

        $html = view('guru/cetak_laporan_statistik', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $nama_file = 'Laporan_Statistik_' . str_replace(' ', '_', $kelas['nama_kelas'] ?? 'Kelas') . '.pdf';
        $dompdf->stream($nama_file, ['Attachment' => false]);
    }
}
