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

            $namaKelas = null;
            $idKelas = null;

            if ($data['role'] == 'guru' && !empty($data['ref_id'])) {
                $db = \Config\Database::connect();
                $guru = $db->table('guru')
                    ->select('guru.id_kelas_diampu, kelas.nama_kelas')
                    ->join('kelas', 'kelas.id = guru.id_kelas_diampu', 'left')
                    ->where('guru.id', $data['ref_id'])
                    ->get()
                    ->getRowArray();

                if ($guru) {
                    $idKelas = $guru['id_kelas_diampu'];
                    $namaKelas = $guru['nama_kelas'];
                }
            }

            $session->set([
                'id'             => $data['id'],
                'role'           => $data['role'],
                'name'           => $data['name'],
                'foto'           => !empty($data['foto']) ? base_url('upload/profile/' . $data['foto']) : base_url('upload/profile/default.png'),
                'ref_id'         => $data['ref_id'],
                'id_kelas'       => $idKelas,
                'nama_kelas'     => $namaKelas ? $namaKelas : 'Belum Ada Kelas',
                'logged_in'      => TRUE
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
