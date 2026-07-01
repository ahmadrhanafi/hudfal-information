<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $role = session()->get('role');

        // Redirect ke controller spesifik per role
        if ($role == 'admin') {
            return view('admin/dashboard');
        } elseif ($role == 'ustadz') {
            return redirect()->to('/ustadz/dashboard');
        } else {
            return redirect()->to('/wali/dashboard');
        }
    }
}
