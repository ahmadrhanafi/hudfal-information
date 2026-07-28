<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;

class RiwayatHafalan extends BaseController
{
    public function index()
    {
        return view('guru/riwayat_hafalan');
    }
}
