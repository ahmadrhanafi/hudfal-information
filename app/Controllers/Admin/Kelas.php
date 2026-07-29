<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KelasModel;

class Kelas extends BaseController
{
    protected $kelasModel;

    public function __construct()
    {
        $this->kelasModel = new KelasModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('kelas');
        $builder->select('kelas.*, COUNT(santri.id) as total_santri');
        $builder->join('santri', 'santri.id_kelas = kelas.id', 'left');
        $builder->groupBy('kelas.id');
        $kelasWithTotal = $builder->get()->getResultArray();

        $data = [
            'title' => 'Data Kelas',
            'kelas' => $kelasWithTotal,
            'role'  => session()->get('role') ?? 'admin'
        ];

        return view('admin/kelas', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kelas',
            'role'  => session()->get('role') ?? 'admin'
        ];

        return view('kelas/create', $data);
    }

    public function store()
    {
        // Validasi sederhana
        if (!$this->validate([
            'nama_kelas' => 'required|min_length[3]|is_unique[kelas.nama_kelas]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kelasModel->save([
            'nama_kelas' => $this->request->getVar('nama_kelas')
        ]);

        return redirect()->to(base_url('admin/kelas'))->with('success', 'Data kelas berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Kelas',
            'kelas' => $this->kelasModel->find($id),
            'role'  => session()->get('role') ?? 'admin'
        ];

        if (empty($data['kelas'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kelas dengan ID ' . $id . ' tidak ditemukan.');
        }

        return view('kelas/edit', $data);
    }

    public function update($id)
    {
        $this->kelasModel->update($id, [
            'nama_kelas' => $this->request->getVar('nama_kelas')
        ]);

        return redirect()->to(base_url('admin/kelas'))->with('success', 'Data kelas berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->kelasModel->delete($id);
        return redirect()->to(base_url('admin/kelas'))->with('success', 'Data kelas berhasil dihapus!');
    }
}
