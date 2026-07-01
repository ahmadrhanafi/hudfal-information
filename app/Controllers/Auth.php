<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        return view('auth/login');
    }

    public function process()
    {
        $session = session();
        $model = $this->userModel;
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $data = $model->where('username', $username)->first();

        if ($data && password_verify($password, $data['password'])) {
            $session->set([
                'id'      => $data['id'],
                'role'    => $data['role'],
                'name'  => $data['name'],
                'foto'  => $data['foto'] ? base_url('upload/profile/' . $data['foto']) : base_url('upload/profile/default.png'),
                'ref_id'  => $data['ref_id'], // ID Ustadz atau Wali
                'logged_in' => TRUE
            ]);
            return redirect()->to('/loading');
        }
        return redirect()->back()->with('error', 'Username atau Password salah');
    }

    public function loading()
    {
        return view('auth/loading');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
