<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $santriModel = new \App\Models\SantriModel();

        // Ambil data anak berdasarkan id_wali dari session
        $data['anak'] = $santriModel->where('id_wali', session()->get('ref_id'))->findAll();

        return view('wali/dashboard', $data);
    }
}
