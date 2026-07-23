<?php

namespace App\Controllers\Ustadz;

use App\Controllers\BaseController;

class Santri extends BaseController
{
    public function index()
    {
        $role = session()->get('role');

        // Redirect ke controller spesifik per role
        if ($role == 'ustadz') {
            return view('ustadz/data_santri');
        } elseif ($role == 'admin') {
            return redirect()->to('/admin/data_santri');
        } else {
            return redirect()->to('/login');
        }
    }
}
