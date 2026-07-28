<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;

class Hafalan extends BaseController
{
    public function index()
    {
        return view('guru/data_hafalan');
    }
}
