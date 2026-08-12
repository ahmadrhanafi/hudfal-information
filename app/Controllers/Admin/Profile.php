<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();

        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            header('Location: ' . base_url('login'));
            exit();
        }
    }

    public function index()
    {
        $userId = session()->get('id');
        $data['user'] = $this->userModel->find($userId);

        return view('admin/profile', $data);
    }

    public function update()
    {
        $userId = session()->get('id');
        $user = $this->userModel->find($userId);

        // Validasi input (ditambah validasi untuk foto)
        $rules = [
            'name' => 'required|min_length[3]',
            'username' => "required|min_length[3]|is_unique[users.username,id,{$userId}]",
            'foto' => 'max_size[foto,2048]|is_image[foto]|ext_in[foto,png,jpg,jpeg]',
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'required|min_length[6]';
            $rules['pass_confirm'] = 'required|matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dataUpdate = [
            'name' => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
        ];

        $fileFoto = $this->request->getFile('foto');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();

            $folderTujuan = 'uploads/profile/';
            $fileFoto->move($folderTujuan, $namaFoto);

            if (!empty($user['foto']) && file_exists($folderTujuan . $user['foto'])) {
                @unlink($folderTujuan . $user['foto']);
            }

            $dataUpdate['foto'] = $namaFoto;

            session()->set('foto', $namaFoto);
        }

        // Handle Password Baru
        if ($this->request->getPost('password')) {
            $dataUpdate['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($userId, $dataUpdate);

        // Update session name jika berubah
        session()->set('name', $dataUpdate['name']);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
