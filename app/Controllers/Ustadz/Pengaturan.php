<?php

namespace App\Controllers\Ustadz;

use App\Controllers\BaseController;

class Pengaturan extends BaseController
{
    public function index()
    {
        return view('ustadz/pengaturan');
    }
}
