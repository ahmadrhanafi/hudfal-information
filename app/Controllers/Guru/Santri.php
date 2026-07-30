<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\SantriModel;
use App\Models\GuruModel;

class Santri extends BaseController
{
    protected $santriModel;
    protected $guruModel;

    public function __construct()
    {
        $this->santriModel = new SantriModel();
        $this->guruModel = new GuruModel();
    }
    public function index()
    {
        $role = session()->get('role');

        // Asumsikan saat login Anda juga menyimpan NIP atau ID Guru di session, 
        // atau kita cari berdasarkan nama yang sedang aktif.
        $namaGuru = session()->get('name');

        if ($role == 'guru') {
            $guru = $this->guruModel->where('nama_guru', $namaGuru)->first();

            if (!$guru) {
                $guru = $this->guruModel->like('nama_guru', str_replace(['Ust.', 'Ustz.'], '', $namaGuru))->first();
            }

            $idKelasDiampu = $guru ? $guru['id_kelas_diampu'] : null;

            $keyword = $this->request->getGet('keyword');
            $status = $this->request->getGet('status');

            $santri = $this->santriModel->searchSantri($keyword, $idKelasDiampu, $status);

            $data = [
                'title'  => 'Data Santri Binaan',
                'santri' => $santri,
                'role'   => $role
            ];

            return view('guru/data_santri', $data);
        } elseif ($role == 'admin') {
            return redirect()->to('/admin/santri');
        } else {
            return redirect()->to('/login');
        }
    }
}
