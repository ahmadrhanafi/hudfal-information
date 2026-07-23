<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        // Ambil data statistik khusus admin jika diperlukan di sini
        return view('admin/dashboard');
    }
}
