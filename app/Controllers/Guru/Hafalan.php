<?php

namespace App\Controllers\Guru;

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
    }

    public function index()
    {
        $idGuru = session()->get('ref_id');
        $idKelas = session()->get('id_kelas');

        $guru = $this->guruModel->find($idGuru);
        $id_kelas_diampu = $guru['id_kelas_diampu'] ?? $idKelas;
        $kelas = $this->kelasModel->find($id_kelas_diampu);

        $data = [
            'title' => 'Data Hafalan',
            'icon' => 'fa-solid fa-book-quran',
            'nama_kelas' => $kelas['nama_kelas'] ?? '-',
            'hafalan' => $this->hafalanModel->getHafalanByGuru($idGuru)->paginate(6, 'hafalan'),
            'pager' => $this->hafalanModel->pager,
            'santri' => $this->santriModel->getSantriByKelas($id_kelas_diampu),
            'guru' => $this->guruModel->findAll()
        ];

        return view('guru/data_hafalan', $data);
    }

    public function getSurahByJuz($juz)
    {
        $model = new \App\Models\HafalanModel();
        $data = $model->getSurahByJuz($juz);
        return $this->response->setJSON($data);
    }

    public function store()
    {
        if (
            !$this->validate([
                'id_santri' => 'required|numeric',
                'jenis' => 'required',
                'juz' => 'required|numeric',
                'surah' => 'required',
                'ayat_mulai' => 'required|numeric',
                'ayat_selesai' => 'required|numeric',
                'predikat' => 'required'
            ])
        ) {
            return redirect()->back()->withInput()->with('error', 'Mohon lengkapi data dengan benar.');
        }

        // TAMBAHAN: Validasi Logika Ayat
        $ayatMulai = $this->request->getVar('ayat_mulai');
        $ayatSelesai = $this->request->getVar('ayat_selesai');

        if ($ayatSelesai < $ayatMulai) {
            return redirect()->back()->withInput()->with('error', 'Ayat selesai tidak boleh lebih kecil dari ayat mulai.');
        }

        $this->hafalanModel->save([
            'id_santri' => $this->request->getVar('id_santri'),
            'id_guru' => session()->get('ref_id'),
            'jenis' => $this->request->getVar('jenis'),
            'juz' => $this->request->getVar('juz'),
            'surah' => $this->request->getVar('surah'),
            'ayat_mulai' => $ayatMulai,
            'ayat_selesai' => $ayatSelesai,
            'predikat' => $this->request->getVar('predikat'),
            'keterangan' => $this->request->getVar('keterangan')
        ]);

        return redirect()->to(base_url('guru/hafalan'))->with('success', 'Data berhasil ditambahkan!');
    }

    public function update($id)
    {
        $hafalan = $this->hafalanModel->find($id);
        if (!$hafalan || $hafalan['id_guru'] != session()->get('ref_id')) {
            return redirect()->to(base_url('guru/hafalan'))->with('error', 'Akses ditolak! Data tidak ditemukan atau bukan milik Anda.');
        }

        if (
            !$this->validate([
                'id_santri' => 'required|numeric',
                'jenis' => 'required',
                'juz' => 'required|numeric',
                'surah' => 'required',
                'ayat_mulai' => 'required|numeric',
                'ayat_selesai' => 'required|numeric',
                'predikat' => 'required'
            ])
        ) {
            return redirect()->back()->withInput()->with('error', 'Mohon cek kembali inputan.');
        }

        $this->hafalanModel->update($id, [
            'id_santri' => $this->request->getVar('id_santri'),
            'id_guru' => session()->get('ref_id'),
            'jenis' => $this->request->getVar('jenis'),
            'juz' => $this->request->getVar('juz'),
            'surah' => $this->request->getVar('surah'),
            'ayat_mulai' => $this->request->getVar('ayat_mulai'),
            'ayat_selesai' => $this->request->getVar('ayat_selesai'),
            'predikat' => $this->request->getVar('predikat'),
            'keterangan' => $this->request->getVar('keterangan')
        ]);

        return redirect()->to(base_url('guru/hafalan'))->with('success', 'Data berhasil diperbarui!');
    }

    public function delete($id)
    {
        $hafalan = $this->hafalanModel->find($id);

        if (!$hafalan || $hafalan['id_guru'] != session()->get('ref_id')) {
            return redirect()->to(base_url('guru/hafalan'))->with('error', 'Akses ditolak! Anda tidak berhak menghapus data ini.');
        }

        $this->hafalanModel->delete($id);

        return redirect()->to(base_url('guru/hafalan'))->with('success', 'Data berhasil dihapus!');
    }
}