<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $guruModel = new \App\Models\GuruModel();
        $santriModel = new \App\Models\SantriModel();

        $guru = $guruModel->find(session()->get('ref_id'));

        $data['santri'] = $guru ? $santriModel->where('id_kelas', $guru['id_kelas_diampu'])->findAll() : [];

        return view('guru/dashboard', $data);
    }
}
