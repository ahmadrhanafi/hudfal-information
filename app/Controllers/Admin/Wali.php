<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\WaliModel;
use App\Models\UserModel;

class Wali extends BaseController
{
    protected $waliModel;
    protected $userModel;

    public function __construct()
    {
        $this->waliModel = new WaliModel();
        $this->userModel = new UserModel();

        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            header('Location: ' . base_url('login'));
            exit();
        }
    }

    public function index()
    {
        $perPage = 8;
        $currentPage = $this->request->getVar('page_wali') ? (int) $this->request->getVar('page_wali') : 1;

        $allWali = $this->waliModel->getWaliWithSantri();
        $total = count($allWali);

        $waliPaging = array_slice($allWali, ($currentPage - 1) * $perPage, $perPage);

        $pager = service('pager');
        $pager->store('wali', $currentPage, $perPage, $total);

        $data = [
            'title' => 'Data Wali Santri',
            'icon' => 'fa-solid fa-users',
            'wali' => $waliPaging,
            'pager' => $pager,
            'role' => session()->get('role') ?? 'admin'
        ];

        return view('admin/wali', $data);
    }

    public function store()
    {
        if (
            !$this->validate([
                'nama_wali' => 'required|min_length[3]',
                'no_hp' => 'required|numeric|min_length[10]',
                'alamat' => 'required'
            ])
        ) {
            return redirect()->back()->withInput()->with('error', 'Gagal validasi data wali santri.');
        }

        $namaWali = $this->request->getVar('nama_wali');
        $noHp = $this->request->getVar('no_hp');

        // 1. Simpan data wali
        $this->waliModel->save([
            'nama_wali' => $namaWali,
            'no_hp' => $noHp,
            'alamat' => $this->request->getVar('alamat'),
        ]);

        // Ambil ID wali yang baru saja disimpan
        $waliId = $this->waliModel->insertID();

        // 2. Otomatis buatkan akun user yang sinkron dengan struktur migration
        $this->userModel->save([
            'name' => $namaWali,
            'username' => $noHp, // Menggunakan nomor HP sebagai username login
            'password' => password_hash($noHp, PASSWORD_DEFAULT), // Default password dari no HP
            'role' => 'wali',
            'ref_id' => $waliId
        ]);

        return redirect()->to(base_url('admin/wali-santri'))->with('success', 'Data wali santri dan akun login berhasil ditambahkan!');
    }

    public function update($id)
    {
        $namaWali = $this->request->getVar('nama_wali');
        $noHp = $this->request->getVar('no_hp');

        // Update data wali
        $this->waliModel->update($id, [
            'nama_wali' => $namaWali,
            'no_hp' => $noHp,
            'alamat' => $this->request->getVar('alamat'),
        ]);

        // Opsional: Sinkronisasi perubahan nama/username ke tabel users berdasarkan ref_id
        $user = $this->userModel->where('ref_id', $id)->where('role', 'wali')->first();
        if ($user) {
            $this->userModel->update($user['id'], [
                'name' => $namaWali,
                'username' => $noHp
            ]);
        }

        return redirect()->to(base_url('admin/wali-santri'))->with('success', 'Data wali santri berhasil diperbarui!');
    }

    public function delete($id)
    {
        // Hapus akun user yang berelasi dengan wali ini terlebih dahulu
        $this->userModel->where('ref_id', $id)->where('role', 'wali')->delete();

        // Hapus data wali
        $this->waliModel->delete($id);

        return redirect()->to(base_url('admin/wali-santri'))->with('success', 'Data wali santri dan akun login berhasil dihapus!');
    }
}
