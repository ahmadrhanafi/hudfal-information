<?php

namespace App\Controllers\Ustadz;

use App\Controllers\BaseController;

class RiwayatHafalan extends BaseController
{
    public function index()
    {
        return view('ustadz/riwayat_hafalan');
    }
}
