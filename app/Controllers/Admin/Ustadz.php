<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Ustadz extends BaseController
{
    public function index()
    {
        $role = session()->get('role');

        // Redirect ke controller spesifik per role
        if ($role == 'admin') {
            return view('admin/data_ustadz');
        } elseif ($role == 'ustadz') {
            return redirect()->to('/login');
        } else {
            return redirect()->to('/login');
        }
    }
}
