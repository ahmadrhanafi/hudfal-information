<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\HafalanModel;
use App\Models\SantriModel;
use App\Models\GuruModel;
use App\Models\KelasModel;

class Hafalan extends BaseController
{
    protected $hafalanModel;
    protected $santriModel;
    protected $guruModel;
    protected $kelasModel;

    public function __construct()
    {
        $this->hafalanModel = new HafalanModel();
        $this->santriModel = new SantriModel();
        $this->guruModel = new GuruModel();
        $this->kelasModel = new KelasModel();

        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            header('Location: ' . base_url('login'));
            exit();
        }
    }
    public function index()
    {
        $role = session()->get('role');
        $namakelas = $this->kelasModel->findAll();

        if ($role == 'admin') {
            $data = [
                'title' => 'Data Hafalan',
                'icon' => 'fa-solid fa-book-quran',
                'hafalan' => $this->hafalanModel->getHafalanWithRelations()->paginate(6, 'hafalan'),
                'pager' => $this->hafalanModel->pager,
                'santri' => $this->santriModel->findAll(),
                'guru' => $this->guruModel->findAll(),
                'kelas' => $this->kelasModel->findAll(),
                'role' => $role,
            ];

            return view('admin/data_hafalan', $data);
        } elseif ($role == 'guru') {
            return redirect()->to('/guru/hafalan');
        } else {
            return redirect()->to('/login');
        }
    }

    public function getSurahByJuz($juz)
    {
        if (CI_DEBUG) {
            service('toolbar')->respond(); // matikan sementara
        }

        $model = new \App\Models\HafalanModel();
        $data = $model->getSurahByJuz($juz);

        return $this->response->setJSON($data);
    }
    public function getSantriByGuru($idGuru)
    {
        $guru = $this->guruModel->find($idGuru);

        if (!$guru || empty($guru['id_kelas_diampu'])) {
            return $this->response->setJSON([]);
        }

        $idKelas = $guru['id_kelas_diampu'];

        $santri = $this->santriModel->where('id_kelas', $idKelas)->findAll();

        return $this->response->setJSON($santri);
    }

    public function store()
    {
        // Validasi input form
        if (
            !$this->validate([
                'id_santri' => 'required|numeric',
                'id_guru' => 'required|numeric',
                'jenis' => 'required',
                'juz' => 'required|numeric',
                'surah' => 'required',
                'ayat_mulai' => 'required|numeric',
                'ayat_selesai' => 'required|numeric',
                'predikat' => 'required'
            ])
        ) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan! Mohon lengkapi data dengan benar.');
        }

        $this->hafalanModel->save([
            'id_santri' => $this->request->getVar('id_santri'),
            'id_guru' => $this->request->getVar('id_guru'),
            'jenis' => $this->request->getVar('jenis'),
            'juz' => $this->request->getVar('juz'),
            'surah' => $this->request->getVar('surah'),
            'ayat_mulai' => $this->request->getVar('ayat_mulai'),
            'ayat_selesai' => $this->request->getVar('ayat_selesai'),
            'predikat' => $this->request->getVar('predikat'),
            'keterangan' => $this->request->getVar('keterangan')
        ]);

        return redirect()->to(base_url('admin/hafalan'))->with('success', 'Data setoran hafalan berhasil ditambahkan!');
    }

    // Method untuk Memperbarui Data Hafalan
    public function update($id)
    {
        // Validasi input form edit
        if (
            !$this->validate([
                'id_santri' => 'required|numeric',
                'id_guru' => 'required|numeric',
                'jenis' => 'required',
                'juz' => 'required|numeric',
                'surah' => 'required',
                'ayat_mulai' => 'required|numeric',
                'ayat_selesai' => 'required|numeric',
                'predikat' => 'required'
            ])
        ) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui! Mohon cek kembali inputan anda.');
        }

        $this->hafalanModel->update($id, [
            'id_santri' => $this->request->getVar('id_santri'),
            'id_guru' => $this->request->getVar('id_guru'),
            'jenis' => $this->request->getVar('jenis'),
            'juz' => $this->request->getVar('juz'),
            'surah' => $this->request->getVar('surah'),
            'ayat_mulai' => $this->request->getVar('ayat_mulai'),
            'ayat_selesai' => $this->request->getVar('ayat_selesai'),
            'predikat' => $this->request->getVar('predikat'),
            'keterangan' => $this->request->getVar('keterangan')
        ]);

        return redirect()->to(base_url('admin/hafalan'))->with('success', 'Data setoran hafalan berhasil diperbarui!');
    }

    // Method untuk Menghapus Data Hafalan
    public function delete($id)
    {
        $hafalan = $this->hafalanModel->find($id);

        if (!$hafalan) {
            return redirect()->to(base_url('admin/hafalan'))->with('error', 'Data hafalan tidak ditemukan.');
        }

        $this->hafalanModel->delete($id);

        return redirect()->to(base_url('admin/hafalan'))->with('success', 'Data hafalan berhasil dihapus!');
    }
}
