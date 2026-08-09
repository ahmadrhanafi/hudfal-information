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

        // Ambil guru yang AKTIF DAN (belum punya kelas atau id kelas kosong)
        $guruList = $this->guruModel->where('status_aktif', 'Aktif')
            ->groupStart()
            ->where('id_kelas_diampu IS NULL', null, false)
            ->orWhere('id_kelas_diampu', '')
            ->groupEnd()
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

    public function store()
    {
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

        $kelasId = $this->kelasModel->insertID();
        $idGuru = $this->request->getVar('id_guru');

        if (!empty($idGuru)) {
            $this->guruModel->update($idGuru, [
                'id_kelas_diampu' => $kelasId
            ]);
        }

        return redirect()->to(base_url('admin/kelas'))->with('success', 'Data kelas berhasil ditambahkan!');
    }

    public function update($id)
    {
        if (
            !$this->validate([
                'nama_kelas' => 'required|min_length[3]|is_unique[kelas.nama_kelas,id,' . $id . ']'
            ])
        ) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kelasModel->update($id, [
            'nama_kelas' => $this->request->getVar('nama_kelas')
        ]);

        $idGuruBaru = $this->request->getVar('id_guru');

        $guruLama = $this->guruModel->where('id_kelas_diampu', $id)->findAll();
        foreach ($guruLama as $g) {
            $this->guruModel->update($g['id'], ['id_kelas_diampu' => null]);
        }

        if (!empty($idGuruBaru)) {
            $this->guruModel->update($idGuruBaru, [
                'id_kelas_diampu' => $id
            ]);
        }

        return redirect()->to(base_url('admin/kelas'))->with('success', 'Data kelas berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->kelasModel->delete($id);
        return redirect()->to(base_url('admin/kelas'))->with('success', 'Data kelas berhasil dihapus!');
    }
}