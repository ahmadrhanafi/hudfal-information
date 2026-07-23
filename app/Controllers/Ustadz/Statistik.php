<?php

namespace App\Controllers\Ustadz;

use App\Controllers\BaseController;

class Statistik extends BaseController
{
    public function index()
    {
        return view('ustadz/statistik_hafalan');
    }
}
