<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\GuruModel;

class Profile extends BaseController
{
    protected $userModel;
    protected $guruModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->guruModel = new GuruModel();

        if (!session()->get('logged_in') || session()->get('role') !== 'guru') {
            header('Location: ' . base_url('login'));
            exit();
        }
    }

    public function index()
    {
        $userId = session()->get('id');
        $user = $this->userModel->find($userId);

        $guru = null;
        if (!empty($user['ref_id'])) {
            $guru = $this->guruModel->find($user['ref_id']);
        }

        $data = [
            'user' => $user,
            'guru' => $guru
        ];

        return view('guru/profile', $data);
    }

    public function update()
    {
        $userId = session()->get('id');
        $user = $this->userModel->find($userId);

        $rules = [
            'name' => 'required|min_length[3]',
            'username' => "required|min_length[3]|is_unique[users.username,id,{$userId}]",
        ];

        if (!empty($user['ref_id'])) {
            $rules['nip'] = "required|is_unique[guru.nip,id,{$user['ref_id']}]";
            $rules['nama_guru'] = 'required';
            $rules['no_hp'] = 'required';
        }

        if ($this->request->getPost('password')) {
            $rules['password'] = 'required|min_length[6]';
            $rules['pass_confirm'] = 'required|matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dataUserUpdate = [
            'name' => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
        ];

        $fileFoto = $this->request->getFile('foto');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('upload/profile', $namaFoto);

            if (!empty($user['foto']) && file_exists('upload/profile/' . $user['foto'])) {
                @unlink('upload/profile/' . $user['foto']);
            }

            $dataUserUpdate['foto'] = $namaFoto;
            session()->set('foto', base_url('upload/profile/' . $namaFoto));
        }

        if ($this->request->getPost('password')) {
            $dataUserUpdate['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($userId, $dataUserUpdate);
        session()->set('name', $dataUserUpdate['name']);

        if (!empty($user['ref_id'])) {
            $dataGuruUpdate = [
                'nip' => $this->request->getPost('nip'),
                'nama_guru' => $this->request->getPost('nama_guru'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'no_hp' => $this->request->getPost('no_hp'),
            ];
            $this->guruModel->update($user['ref_id'], $dataGuruUpdate);
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}