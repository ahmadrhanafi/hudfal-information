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
            $namaWali = null;

            if ($data['role'] == 'guru' && !empty($data['ref_id'])) {
                $db = \Config\Database::connect();
                $guru = $db->table('guru')
                    ->select('guru.id_kelas_diampu, guru.status_aktif, kelas.nama_kelas')
                    ->join('kelas', 'kelas.id = guru.id_kelas_diampu', 'left')
                    ->where('guru.id', $data['ref_id'])
                    ->get()
                    ->getRowArray();

                if ($guru) {
                    if (strtolower($guru['status_aktif']) == 'non-aktif') {
                        return redirect()->back()->with('error', 'Akun Anda sudah non-aktif. Silakan hubungi admin.');
                    }
                    $idKelas = $guru['id_kelas_diampu'];
                    $namaKelas = $guru['nama_kelas'];
                }
            } elseif ($data['role'] == 'wali' && !empty($data['ref_id'])) {
                $db = \Config\Database::connect();
                $wali = $db->table('wali')
                    ->select('nama_wali')
                    ->where('id', $data['ref_id'])
                    ->get()
                    ->getRowArray();

                if ($wali) {
                    $namaWali = $wali['nama_wali'];
                }
            }

            $session->set([
                'id' => $data['id'],
                'role' => $data['role'],
                'name' => $data['name'],
                'nama_wali' => $namaWali ? $namaWali : $data['name'], // Simpan nama wali
                'foto' => !empty($data['foto']) ? base_url('upload/profile/' . $data['foto']) : base_url('upload/profile/default.png'),
                'ref_id' => $data['ref_id'],
                'id_kelas' => $idKelas,
                'nama_kelas' => $namaKelas ? $namaKelas : 'Belum Ada Kelas',
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
