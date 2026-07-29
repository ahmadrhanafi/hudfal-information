<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\HafalanModel;

class RiwayatHafalan extends BaseController
{
    protected $hafalanModel;

    public function __construct()
    {
        $this->hafalanModel = new HafalanModel();
    }

    public function index()
    {
        $data = [
            'riwayat' => $this->hafalanModel->getRiwayatHafalan()
        ];

        return view('guru/riwayat_hafalan', $data);
    }
}
