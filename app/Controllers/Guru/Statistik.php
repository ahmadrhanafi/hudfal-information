<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;

class Statistik extends BaseController
{
    public function index()
    {
        return view('guru/statistik_hafalan');
    }
}
