<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\KelasModel;

class Ustadz extends BaseController
{
    protected $guruModel;
    protected $kelasModel;

    public function __construct()
    {
        $this->guruModel  = new GuruModel();
        $this->kelasModel = new KelasModel();
    }

    public function index()
    {
        $role = session()->get('role');

        $data = [
            'title' => 'Data Ustadz / Guru',
            'guru'  => $this->guruModel->getGuruWithKelas(),
            'kelas' => $this->kelasModel->findAll(),
            'role'  => session()->get('role') ?? 'admin'
        ];

        // Redirect ke controller spesifik per role
        if ($role == 'admin') {
            return view('admin/data_ustadz', $data);
        } elseif ($role == 'ustadz') {
            return redirect()->to('/login');
        } else {
            return redirect()->to('/login');
        }
    }

    public function store()
    {
        if (!$this->validate([
            'nip'             => 'required|numeric|is_unique[guru.nip]',
            'nama'            => 'required|min_length[3]',
            'jenis_kelamin'   => 'required|in_list[L,P]',
            'id_kelas_diampu' => 'required|numeric'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Gagal validasi data guru.');
        }

        $this->guruModel->save([
            'nip'             => $this->request->getVar('nip'),
            'nama'            => $this->request->getVar('nama'),
            'jenis_kelamin'   => $this->request->getVar('jenis_kelamin'),
            'id_kelas_diampu' => $this->request->getVar('id_kelas_diampu'),
        ]);

        return redirect()->to(base_url('admin/ustadz'))->with('success', 'Data ustadz berhasil ditambahkan!');
    }

    public function update($id)
    {
        $this->guruModel->update($id, [
            'nip'             => $this->request->getVar('nip'),
            'nama'            => $this->request->getVar('nama'),
            'jenis_kelamin'   => $this->request->getVar('jenis_kelamin'),
            'id_kelas_diampu' => $this->request->getVar('id_kelas_diampu'),
        ]);

        return redirect()->to(base_url('admin/ustadz'))->with('success', 'Data ustadz berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->guruModel->delete($id);
        return redirect()->to(base_url('admin/ustadz'))->with('success', 'Data ustadz berhasil dihapus!');
    }
}
