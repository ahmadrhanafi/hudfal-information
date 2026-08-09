<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\GuruModel;

class Kelas extends BaseController
{
    protected $kelasModel;
    protected $guruModel;

    public function __construct()
    {
        $this->kelasModel = new KelasModel();
        $this->guruModel = new GuruModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('kelas');
        $builder->select('kelas.*, guru.nama_guru, guru.nip, guru.status_aktif, (SELECT COUNT(id) FROM santri WHERE santri.id_kelas = kelas.id AND santri.status_aktif = "Aktif") as total_santri');
        $builder->join('guru', 'guru.id_kelas_diampu = kelas.id', 'left');

        $kelasWithTotal = $builder->get()->getResultArray();
        $guruList = $this->guruModel->where('id_kelas_diampu IS NULL', null, false)
            ->orWhere('id_kelas_diampu', '')
            ->findAll();

        $data = [
            'title' => 'Data Kelas',
            'icon' => 'fa-solid fa-school',
            'kelas' => $kelasWithTotal,
            'guruList' => $guruList,
            'role' => session()->get('role') ?? 'admin'
        ];

        return view('admin/kelas', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kelas',
            'role' => session()->get('role') ?? 'admin'
        ];

        return view('kelas/create', $data);
    }

    public function store()
    {
        // Validasi sederhana
        if (
            !$this->validate([
                'nama_kelas' => 'required|min_length[3]|is_unique[kelas.nama_kelas]'
            ])
        ) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kelasModel->save([
            'nama_kelas' => $this->request->getVar('nama_kelas')
        ]);

        return redirect()->to(base_url('admin/kelas'))->with('success', 'Data kelas berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Kelas',
            'kelas' => $this->kelasModel->find($id),
            'role' => session()->get('role') ?? 'admin'
        ];

        if (empty($data['kelas'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kelas dengan ID ' . $id . ' tidak ditemukan.');
        }

        return view('kelas/edit', $data);
    }

    public function update($id)
    {
        $this->kelasModel->update($id, [
            'nama_kelas' => $this->request->getVar('nama_kelas')
        ]);

        return redirect()->to(base_url('admin/kelas'))->with('success', 'Data kelas berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->kelasModel->delete($id);
        return redirect()->to(base_url('admin/kelas'))->with('success', 'Data kelas berhasil dihapus!');
    }
}
