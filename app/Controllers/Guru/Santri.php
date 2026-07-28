<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;

class Santri extends BaseController
{
    public function index()
    {
        $role = session()->get('role');

        if ($role == 'guru') {
            return view('guru/data_santri');
        } elseif ($role == 'admin') {
            return redirect()->to('/admin/data_santri');
        } else {
            return redirect()->to('/login');
        }
    }
}
