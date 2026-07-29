<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\HafalanModel;

class Hafalan extends BaseController
{
    protected $hafalanModel;

    public function __construct()
    {
        $this->hafalanModel = new HafalanModel();
    }
    public function index()
    {
        $role = session()->get('role');

        if ($role == 'admin') {
            // Ambil data hafalan beserta relasi santri dan guru
            $data = [
                'title'   => 'Monitoring Data Hafalan',
                'hafalan' => $this->hafalanModel->getHafalanWithRelations(),
                'role'    => $role
            ];

            return view('admin/data_hafalan', $data);
        } elseif ($role == 'guru') {
            return redirect()->to('/guru/data_hafalan');
        } else {
            return redirect()->to('/login');
        }
    }

    public function delete($id)
    {
        $this->hafalanModel->delete($id);
        return redirect()->to(base_url('admin/hafalan'))->with('success', 'Data hafalan berhasil dihapus!');
    }
}
