<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;
use App\Models\SantriModel;
use App\Models\HafalanModel;

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
        $id_wali = session()->get('id'); // Sesuaikan dengan key session wali di sistem lu

        // Ambil data santri / ananda yang dibina oleh wali ini
        // (Jika satu wali bisa punya banyak anak, bisa pakai findAll(), kalau 1 anak pakai first())
        $santri = $this->santriModel->where('id_wali', $id_wali)->first();

        $id_santri   = $santri['id'] ?? null;
        $nama_santri = $santri['nama_santri'] ?? 'Ananda';

        // Lempar data hasil kalkulasi model ke view wali
        $data = [
            'title'          => 'Statistik Hafalan Ananda',
            'nama_santri'    => $nama_santri,
            'total_juz'      => $this->hafalanModel->getTotalJuzSelesai($id_santri),
            'streak_hari'    => $this->hafalanModel->getStreakHarian($id_santri),
            'rata_predikat'  => $this->hafalanModel->getRataPredikatSantri($id_santri),
            'komposisi'      => $this->hafalanModel->getKomposisiSetoran($id_santri),
            'grafik_ayat'    => $this->hafalanModel->getGrafikAyatBulanan($id_santri),
            'detail_juz'     => $this->hafalanModel->getDetailCapaianJuz($id_santri),
        ];

        return view('wali/statistik_hafalan', $data);
    }
}
