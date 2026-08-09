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
    }

    public function index()
    {
        $userId = session()->get('id');
        $data['user'] = $this->userModel->find($userId);

        return view('admin/profile', $data);
    }

    public function updateProfile()
    {
        $userId = session()->get('id');
        $user = $this->userModel->find($userId);

        // Validasi input
        $rules = [
            'name' => 'required|min_length[3]',
            'username' => "required|min_length[3]|is_unique[users.username,id,{$userId}]",
        ];

        // Jika user berniat mengganti password
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

        // Handle Upload Foto
        $fileFoto = $this->request->getFile('foto');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('upload/profile', $namaFoto);

            // Hapus foto lama jika bukan default
            if (!empty($user['foto']) && file_exists('upload/profile/' . $user['foto'])) {
                @unlink('upload/profile/' . $user['foto']);
            }

            $dataUpdate['foto'] = $namaFoto;
            // Update session foto juga
            session()->set('foto', base_url('upload/profile/' . $namaFoto));
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
