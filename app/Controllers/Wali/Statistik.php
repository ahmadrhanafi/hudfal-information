<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;

class Statistik extends BaseController
{
    public function index()
    {
        return view('wali/statistik_hafalan');
    }
}
