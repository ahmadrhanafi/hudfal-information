<?php

namespace App\Controllers\Ustadz;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $ustadzModel = new \App\Models\UstadzModel();
        $santriModel = new \App\Models\SantriModel();

        // Ambil info ustadz dari session
        $ustadz = $ustadzModel->find(session()->get('ref_id'));

        // Ambil data santri berdasarkan ID Kelas yang diajar
        $data['santri'] = $santriModel->where('id_kelas', $ustadz['id_kelas_diampu'])->findAll();

        return view('ustadz/santri/index', $data);
    }
}
