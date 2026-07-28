<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;

class Pengaturan extends BaseController
{
    public function index()
    {
        return view('guru/pengaturan');
    }
}
