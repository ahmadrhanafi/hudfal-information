<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PembayaranModel;
use App\Models\SantriModel;

class Administrasi extends BaseController
{
    protected $pembayaranModel;
    protected $santriModel;

    public function __construct()
    {
        $this->pembayaranModel = new PembayaranModel();
        $this->santriModel     = new SantriModel();
    }

    public function index()
    {
        $perPage = 10; // Jumlah data per halaman

        $data = [
            'title'        => 'Administrasi',
            'icon'         => 'fa-solid fa-file-invoice-dollar',
            'administrasi' => $this->pembayaranModel->getPembayaranWithSantri()->paginate($perPage, 'administrasi'),
            'pager'        => $this->pembayaranModel->pager,
            'listSantri'   => $this->santriModel->select('santri.id, santri.nama_santri, kelas.nama_kelas')
                ->join('kelas', 'kelas.id = santri.id_kelas', 'left')
                ->findAll(),
            'role'         => session()->get('role') ?? 'admin'
        ];

        return view('admin/administrasi', $data);
    }

    public function store()
    {
        $rules = [
            'id_santri'        => 'required|integer',
            'tanggal'          => 'required|valid_date',
            'jenis_pembayaran' => 'required|string|max_length[100]',
            'jumlah'           => 'required|numeric',
            'status'           => 'required|in_list[Lunas,Pending,Gagal,Menunggu Verifikasi]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->pembayaranModel->save([
            'id_santri'        => $this->request->getPost('id_santri'),
            'tanggal'          => $this->request->getPost('tanggal'),
            'jenis_pembayaran' => $this->request->getPost('jenis_pembayaran'),
            'jumlah'           => $this->request->getPost('jumlah'),
            'status'           => $this->request->getPost('status'),
            'keterangan'       => $this->request->getPost('keterangan'),
        ]);

        return redirect()->to(base_url('admin/administrasi'))->with('success', 'Data pembayaran berhasil ditambahkan!');
    }

    public function update($id)
    {
        $rules = [
            'id_santri'        => 'required|integer',
            'tanggal'          => 'required|valid_date',
            'jenis_pembayaran' => 'required|string|max_length[100]',
            'jumlah'           => 'required|numeric',
            'status'           => 'required|in_list[Lunas,Pending,Gagal,Menunggu Verifikasi]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->pembayaranModel->update($id, [
            'id_santri'        => $this->request->getPost('id_santri'),
            'tanggal'          => $this->request->getPost('tanggal'),
            'jenis_pembayaran' => $this->request->getPost('jenis_pembayaran'),
            'jumlah'           => $this->request->getPost('jumlah'),
            'status'           => $this->request->getPost('status'),
            'keterangan'       => $this->request->getPost('keterangan'),
        ]);

        return redirect()->to(base_url('admin/administrasi'))->with('success', 'Data pembayaran berhasil diperbarui!');
    }

    // Method Verifikasi Cepat oleh Admin (Ubah status jadi Lunas)
    public function verifikasi($id)
    {
        $pembayaran = $this->pembayaranModel->find($id);

        if (!$pembayaran) {
            return redirect()->to(base_url('admin/administrasi'))->with('error', 'Data pembayaran tidak ditemukan!');
        }

        $this->pembayaranModel->update($id, [
            'status' => 'Lunas'
        ]);

        return redirect()->to(base_url('admin/administrasi'))->with('success', 'Pembayaran berhasil diverifikasi menjadi Lunas!');
    }

    public function delete($id)
    {
        $pembayaran = $this->pembayaranModel->find($id);

        if (!$pembayaran) {
            return redirect()->to(base_url('admin/administrasi'))->with('error', 'Data pembayaran tidak ditemukan!');
        }

        $this->pembayaranModel->delete($id);

        return redirect()->to(base_url('admin/administrasi'))->with('success', 'Data pembayaran berhasil dihapus!');
    }
}
