<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SantriModel;
use App\Models\KelasModel;
use App\Models\WaliModel;

class Santri extends BaseController
{
    protected $santriModel;
    protected $kelasModel;
    protected $waliModel;

    public function __construct()
    {
        $this->santriModel = new SantriModel();
        $this->kelasModel  = new KelasModel();
        $this->waliModel   = new WaliModel();
    }

    public function index()
    {
        $role = session()->get('role');

        // Ambil parameter dari URL (GET)
        $keyword = $this->request->getGet('keyword');
        $idKelas = $this->request->getGet('id_kelas');
        $status  = $this->request->getGet('status');

        $santri = $this->santriModel->searchSantri($keyword, $idKelas, $status);

        $data = [
            'title'          => 'Manajemen Data Santri',
            'santri'         => $santri,
            'kelas'          => $this->kelasModel->findAll(),
            'wali'           => $this->waliModel->findAll(),
            'keyword'        => $keyword,
            'selectedKelas'  => $idKelas,
            'selectedStatus' => $status,
        ];

        if ($role == 'admin') {
            return view('admin/data_santri', $data);
        } elseif ($role == 'ustadz') {
            return redirect()->to('/ustadz/data_santri');
        } else {
            return redirect()->to('/login');
        }
    }

    public function store()
    {
        if (!$this->validate([
            'nis'           => 'required|numeric|is_unique[santri.nis]',
            'nama_santri'   => 'required|min_length[3]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'id_kelas'      => 'required|numeric',
            'id_wali'       => 'required|numeric',
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('error', $validation->listErrors());

            // return redirect()->back()->withInput()->with('error', 'Gagal validasi data santri. Pastikan NIS unik.');
        }

        $this->santriModel->save([
            'nis'           => $this->request->getVar('nis'),
            'nama_santri'   => $this->request->getVar('nama_santri'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'id_kelas'      => $this->request->getVar('id_kelas'),
            'id_wali'       => $this->request->getVar('id_wali'),
            'status_aktif'  => 'Aktif',
        ]);

        return redirect()->to(base_url('admin/santri'))->with('success', 'Data santri berhasil ditambahkan!');
    }

    public function update($id)
    {
        $this->santriModel->update($id, [
            'nis'           => $this->request->getVar('nis'),
            'nama_santri'   => $this->request->getVar('nama_santri'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'id_kelas'      => $this->request->getVar('id_kelas'),
            'id_wali'       => $this->request->getVar('id_wali'),
            'status_aktif'  => $this->request->getVar('status_aktif'),
        ]);

        return redirect()->to(base_url('admin/santri'))->with('success', 'Data santri berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->santriModel->delete($id);
        return redirect()->to(base_url('admin/santri'))->with('success', 'Data santri berhasil dihapus!');
    }

    public function detail($id)
    {
        $santri = $this->santriModel->select('santri.*, kelas.nama_kelas, wali.nama_wali, wali.no_hp as no_hp_wali, wali.alamat as alamat_wali')
            ->join('kelas', 'kelas.id = santri.id_kelas', 'left')
            ->join('wali', 'wali.id = santri.id_wali', 'left')
            ->find($id);

        if (!$santri) {
            return redirect()->to(base_url('admin/santri'))->with('error', 'Data santri tidak ditemukan.');
        }

        $data = [
            'title'  => 'Detail Santri',
            'santri' => $santri
        ];

        return view('admin/santri-detail', $data);
    }
}
