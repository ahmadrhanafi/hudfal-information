<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\WaliModel;
use App\Models\SantriModel;

class Pengaturan extends BaseController
{
    protected $userModel;
    protected $waliModel;
    protected $santriModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->waliModel = new WaliModel();
        $this->santriModel = new SantriModel();

        if (!session()->get('logged_in') || session()->get('role') !== 'wali') {
            header('Location: ' . base_url('login'));
            exit();
        }
    }

    public function index()
    {
        $userId = session()->get('id');
        $userNama = session()->get('name');

        $wali = null;

        if (!empty($userEmail)) {
        }

        if (!$wali && !empty($userNama)) {
            $wali = $this->waliModel->where('nama_wali', $userNama)->first();
        }

        if (!$wali) {
            $wali = $this->waliModel->find($userId);
        }

        $list_santri = [];
        if ($wali) {
            $list_santri = $this->santriModel->select('santri.*, kelas.nama_kelas')
                ->join('kelas', 'kelas.id = santri.id_kelas', 'left')
                ->where('santri.id_wali', $wali['id'])
                ->findAll();
        }

        $data = [
            'title' => 'Pengaturan Akun Wali',
            'wali' => $wali,
            'list_santri' => $list_santri
        ];

        return view('wali/pengaturan', $data);
    }

    public function updateProfile()
    {
        $userId = session()->get('id');
        $userNama = session()->get('nama');

        // Cari data wali yang sedang login
        $wali = $this->waliModel->where('nama_wali', $userNama)->first();
        if (!$wali) {
            $wali = $this->waliModel->find($userId);
        }

        if (!$wali) {
            return redirect()->to('/wali/pengaturan')->with('error', 'Data profil wali tidak ditemukan.');
        }

        // Update menggunakan allowedFields yang sah di WaliModel
        $this->waliModel->update($wali['id'], [
            'nama_wali' => $this->request->getPost('nama_wali'),
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
        ]);

        return redirect()->to('/wali/pengaturan')->with('success', 'Informasi kontak wali berhasil diperbarui.');
    }

    public function updatePassword()
    {
        $userId = session()->get('id');
        $user = $this->userModel->find($userId);

        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if (!password_verify($currentPassword, $user['password'])) {
            return redirect()->to('/wali/pengaturan')->with('error', 'Kata sandi saat ini salah!');
        }

        if (strlen($newPassword) < 8) {
            return redirect()->to('/wali/pengaturan')->with('error', 'Kata sandi baru minimal harus 8 karakter!');
        }

        if ($newPassword !== $confirmPassword) {
            return redirect()->to('/wali/pengaturan')->with('error', 'Konfirmasi kata sandi baru tidak cocok!');
        }

        $this->userModel->update($userId, [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/wali/pengaturan')->with('success', 'Kata sandi berhasil diperbarui.');
    }
}