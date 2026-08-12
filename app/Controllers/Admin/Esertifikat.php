<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SantriModel;

class Esertifikat extends BaseController
{
    protected $santriModel;

    public function __construct()
    {
        $this->santriModel = new SantriModel();

        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            header('Location: ' . base_url('login'));
            exit();
        }
    }

    public function index()
    {
        // Ambil data santri beserta kelas dan walinya dari fungsi yang sudah ada
        $data['sertifikat'] = $this->santriModel->getSantriWithRelations();

        return view('admin/esertifikat', $data);
    }
}
