<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\SantriModel;
use App\Models\HafalanModel;

class Dashboard extends BaseController
{
    protected $guruModel;
    protected $santriModel;
    protected $hafalanModel;
    protected $pembayaranModel;

    public function __construct()
    {
        $this->guruModel = new GuruModel();
        $this->santriModel = new SantriModel();
        $this->hafalanModel = new HafalanModel();
    }

    public function index()
    {
        $periode = $this->request->getGet('periode') ?? 'bulan_ini';

        $grafikData = $this->hafalanModel->getGrafikSetoranGlobal($periode);

        $data = [
            'title' => 'Dashboard Admin',
            'icon' => 'fa-solid fa-gauge',
            'periode' => $periode,
            'total_ustadz' => $this->guruModel->where('status_aktif', 'Aktif')->countAllResults(),
            'total_santri' => $this->santriModel->countAll(),
            'total_setoran' => $this->hafalanModel->countAll(),
            'total_khatam' => $this->santriModel->where('status_aktif', 'lulus')->countAllResults(),
            'grafik_data' => $grafikData,
        ];

        return view('admin/dashboard', $data);
    }
}
