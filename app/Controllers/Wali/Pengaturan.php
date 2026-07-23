<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;

class Pengaturan extends BaseController
{
    public function index()
    {
        return view('wali/pengaturan');
    }
}
