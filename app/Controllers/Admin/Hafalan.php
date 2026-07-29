<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\HafalanModel;
use App\Models\SantriModel;
use App\Models\GuruModel;

class Hafalan extends BaseController
{
    protected $hafalanModel;
    protected $santriModel;
    protected $guruModel;

    public function __construct()
    {
        $this->hafalanModel = new HafalanModel();
        $this->santriModel = new SantriModel();
        $this->guruModel = new GuruModel();
    }
    public function index()
    {
        $role = session()->get('role');

        if ($role == 'admin') {
            $data = [
                'title'   => 'Monitoring Data Hafalan',
                'hafalan' => $this->hafalanModel->getHafalanWithRelations(),
                'santri'  => $this->santriModel->findAll(),
                'guru'    => $this->guruModel->findAll(),
                'role'    => $role
            ];

            return view('admin/data_hafalan', $data);
        } elseif ($role == 'guru') {
            return redirect()->to('/guru/hafalan');
        } else {
            return redirect()->to('/login');
        }
    }

    public function store()
    {
        // Validasi input form
        if (!$this->validate([
            'id_santri'  => 'required|numeric',
            'id_guru'      => 'required|numeric',
            'jenis'      => 'required',
            'juz'        => 'required|numeric',
            'surah'      => 'required',
            'ayat_mulai' => 'required|numeric',
            'ayat_selesai' => 'required|numeric',
            'predikat'   => 'required'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan! Mohon lengkapi data dengan benar.');
        }

        $this->hafalanModel->save([
            'id_santri'    => $this->request->getVar('id_santri'),
            'id_guru'      => $this->request->getVar('id_guru'),
            'jenis'        => $this->request->getVar('jenis'),
            'juz'          => $this->request->getVar('juz'),
            'surah'        => $this->request->getVar('surah'),
            'ayat_mulai'   => $this->request->getVar('ayat_mulai'),
            'ayat_selesai' => $this->request->getVar('ayat_selesai'),
            'predikat'     => $this->request->getVar('predikat'),
            'keterangan'   => $this->request->getVar('keterangan')
        ]);

        return redirect()->to(base_url('admin/hafalan'))->with('success', 'Data setoran hafalan berhasil ditambahkan!');
    }

    // Method untuk Memperbarui Data Hafalan
    public function update($id)
    {
        // Validasi input form edit
        if (!$this->validate([
            'id_santri'    => 'required|numeric',
            'id_guru'      => 'required|numeric',
            'jenis'        => 'required',
            'juz'          => 'required|numeric',
            'surah'        => 'required',
            'ayat_mulai'   => 'required|numeric',
            'ayat_selesai' => 'required|numeric',
            'predikat'     => 'required'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui! Mohon cek kembali inputan anda.');
        }

        $this->hafalanModel->update($id, [
            'id_santri'    => $this->request->getVar('id_santri'),
            'id_guru'      => $this->request->getVar('id_guru'),
            'jenis'        => $this->request->getVar('jenis'),
            'juz'          => $this->request->getVar('juz'),
            'surah'        => $this->request->getVar('surah'),
            'ayat_mulai'   => $this->request->getVar('ayat_mulai'),
            'ayat_selesai' => $this->request->getVar('ayat_selesai'),
            'predikat'     => $this->request->getVar('predikat'),
            'keterangan'   => $this->request->getVar('keterangan')
        ]);

        return redirect()->to(base_url('admin/hafalan'))->with('success', 'Data setoran hafalan berhasil diperbarui!');
    }

    // Method untuk Menghapus Data Hafalan
    public function delete($id)
    {
        $hafalan = $this->hafalanModel->find($id);

        if (!$hafalan) {
            return redirect()->to(base_url('admin/hafalan'))->with('error', 'Data hafalan tidak ditemukan.');
        }

        $this->hafalanModel->delete($id);

        return redirect()->to(base_url('admin/hafalan'))->with('success', 'Data hafalan berhasil dihapus!');
    }
}
