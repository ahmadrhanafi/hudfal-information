<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\WaliModel;

class Wali extends BaseController
{
    protected $waliModel;

    public function __construct()
    {
        $this->waliModel = new WaliModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Wali Santri',
            'wali'  => $this->waliModel->findAll(),
            'role'  => session()->get('role') ?? 'admin'
        ];

        return view('admin/wali', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'nama_wali'   => 'required|min_length[3]',
            'no_hp'  => 'required|numeric|min_length[10]',
            'alamat' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Gagal validasi data wali santri.');
        }

        $this->waliModel->save([
            'nama_wali'   => $this->request->getVar('nama_wali'),
            'no_hp'  => $this->request->getVar('no_hp'),
            'alamat' => $this->request->getVar('alamat'),
        ]);

        return redirect()->to(base_url('admin/wali-santri'))->with('success', 'Data wali santri berhasil ditambahkan!');
    }

    public function update($id)
    {
        $this->waliModel->update($id, [
            'nama_wali'   => $this->request->getVar('nama_wali'),
            'no_hp'  => $this->request->getVar('no_hp'),
            'alamat' => $this->request->getVar('alamat'),
        ]);

        return redirect()->to(base_url('admin/wali-santri'))->with('success', 'Data wali santri berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->waliModel->delete($id);
        return redirect()->to(base_url('admin/wali-santri'))->with('success', 'Data wali santri berhasil dihapus!');
    }
}
