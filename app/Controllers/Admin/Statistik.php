<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Statistik extends BaseController
{
    public function index()
    {
        return view('admin/statistik_hafalan');
    }
}
