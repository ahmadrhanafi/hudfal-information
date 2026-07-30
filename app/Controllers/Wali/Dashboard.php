<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;
use App\Models\SantriModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $santriModel = new SantriModel();
        $idWali = session()->get('ref_id');

        // Ambil semua data anak berdasarkan id_wali yang login beserta informasi kelasnya
        $anak = $santriModel->select('santri.*, kelas.nama_kelas')
            ->join('kelas', 'kelas.id = santri.id_kelas', 'left')
            ->where('santri.id_wali', $idWali)
            ->findAll();

        $data = [
            'title' => 'Dashboard Wali Santri',
            'anak'  => $anak
        ];

        return view('wali/dashboard', $data);
    }
}
