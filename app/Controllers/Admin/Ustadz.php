<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\KelasModel;
use App\Models\UserModel;

class Ustadz extends BaseController
{
    protected $guruModel;
    protected $kelasModel;
    protected $userModel;

    public function __construct()
    {
        $this->guruModel  = new GuruModel();
        $this->kelasModel = new KelasModel();
        $this->userModel  = new UserModel();
    }

    public function index()
    {
        $role = session()->get('role');

        $data = [
            'title' => 'Data Ustadz',
            'icon' => 'fa-solid fa-chalkboard-user',
            'guru'  => $this->guruModel->getGuruWithKelas(),
            'kelas' => $this->kelasModel->findAll(),
            'role'  => session()->get('role') ?? 'admin'
        ];

        if ($role == 'admin') {
            return view('admin/data_ustadz', $data);
        } else {
            return redirect()->to('/login');
        }
    }

    public function store()
    {
        if (!$this->validate([
            'nip'             => 'required|numeric|is_unique[guru.nip]',
            'nama_guru'       => 'required|min_length[3]',
            'no_hp'     => 'required|numeric|min_length[10]',
            'jenis_kelamin'   => 'required|in_list[L,P]',
            'id_kelas_diampu' => 'required|numeric'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Gagal validasi data guru.');
        }

        $nip      = $this->request->getVar('nip');
        $namaGuru = $this->request->getVar('nama_guru');
        $noHp     = $this->request->getVar('no_hp');

        $this->guruModel->save([
            'nip'             => $nip,
            'nama_guru'       => $namaGuru,
            'no_hp'           => $noHp,
            'jenis_kelamin'   => $this->request->getVar('jenis_kelamin'),
            'id_kelas_diampu' => $this->request->getVar('id_kelas_diampu'),
            'status_aktif'    => 'Aktif',
        ]);

        $guruId = $this->guruModel->insertID();

        $this->userModel->save([
            'name'     => $namaGuru,
            'username' => $nip,
            'password' => password_hash($nip, PASSWORD_DEFAULT),
            'role'     => 'guru',
            'ref_id'   => $guruId
        ]);

        return redirect()->to(base_url('admin/ustadz'))->with('success', 'Data ustadz dan akun login berhasil ditambahkan!');
    }

    public function update($id)
    {
        $nip      = $this->request->getVar('nip');
        $namaGuru = $this->request->getVar('nama_guru');
        $noHp     = $this->request->getVar('no_hp');

        $this->guruModel->update($id, [
            'nip'               => $nip,
            'nama_guru'         => $namaGuru,
            'no_hp'             => $noHp,
            'jenis_kelamin'     => $this->request->getVar('jenis_kelamin'),
            'id_kelas_diampu'   => $this->request->getVar('id_kelas_diampu'),
            'status_aktif'      => $this->request->getVar('status_aktif'),
        ]);

        $user = $this->userModel->where('ref_id', $id)->where('role', 'guru')->first();
        if ($user) {
            $this->userModel->update($user['id'], [
                'name'     => $namaGuru,
                'username' => $nip
            ]);
        }

        return redirect()->to(base_url('admin/ustadz'))->with('success', 'Data ustadz berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->userModel->where('ref_id', $id)->where('role', 'guru')->delete();
        $this->guruModel->delete($id);

        return redirect()->to(base_url('admin/ustadz'))->with('success', 'Data ustadz dan akun login berhasil dihapus!');
    }
}
