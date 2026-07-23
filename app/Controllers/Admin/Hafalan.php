<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Hafalan extends BaseController
{
    public function index()
    {
        $role = session()->get('role');

        // Redirect ke controller spesifik per role
        if ($role == 'admin') {
            return view('admin/data_hafalan');
        } elseif ($role == 'ustadz') {
            return redirect()->to('/ustadz/data_hafalan');
        } else {
            return redirect()->to('/login');
        }
    }
}
