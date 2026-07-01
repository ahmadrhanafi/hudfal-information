<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $santriModel = new \App\Models\SantriModel();

        // Ambil data santri yang memiliki id_wali sama dengan session
        $data['anak'] = $santriModel->where('id_wali', session()->get('ref_id'))->findAll();

        return view('wali/dashboard', $data);
    }
}
