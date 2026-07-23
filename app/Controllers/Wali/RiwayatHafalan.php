<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;

class RiwayatHafalan extends BaseController
{
    public function index()
    {
        return view('wali/riwayat_hafalan');
    }
}
