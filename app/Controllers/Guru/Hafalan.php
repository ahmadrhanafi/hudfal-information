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
        $this->santriModel  = new SantriModel();
        $this->guruModel = new GuruModel();
        $this->kelasModel = new KelasModel();
    }

    public function index()
    {
        $idGuru  = session()->get('ref_id');
        $idKelas = session()->get('id_kelas');

        $guru = $this->guruModel->find($idGuru);
        $id_kelas_diampu = $guru['id_kelas_diampu'] ?? $idKelas;

        $kelas = $this->kelasModel->find($id_kelas_diampu);

        $namaKelasString = $kelas['nama_kelas'] ?? '-';

        $data = [
            'title'      => 'Data Hafalan',
            'icon'       => 'fa-solid fa-book-quran',
            'nama_kelas' => $namaKelasString,
            'hafalan'    => $this->hafalanModel->getHafalanByGuru($idGuru)->paginate(10, 'hafalan'),
            'pager'      => $this->hafalanModel->pager,
            'santri'     => $this->santriModel->getSantriByKelas($id_kelas_diampu),
            'guru'       => $this->guruModel->findAll()
        ];

        return view('guru/data_hafalan', $data);
    }

    public function store()
    {
        // Validasi input form
        if (!$this->validate([
            'id_santri'  => 'required|numeric',
            'id_guru'      => 'required|numeric',
            'jenis'      => 'required',
            'juz'        => 'required|numeric',
            'surah'      => 'required',
            'ayat_mulai' => 'required|numeric',
            'ayat_selesai' => 'required|numeric',
            'predikat'   => 'required'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan! Mohon lengkapi data dengan benar.');
        }

        $this->hafalanModel->save([
            'id_santri'    => $this->request->getVar('id_santri'),
            'id_guru'      => $this->request->getVar('id_guru'),
            'jenis'        => $this->request->getVar('jenis'),
            'juz'          => $this->request->getVar('juz'),
            'surah'        => $this->request->getVar('surah'),
            'ayat_mulai'   => $this->request->getVar('ayat_mulai'),
            'ayat_selesai' => $this->request->getVar('ayat_selesai'),
            'predikat'     => $this->request->getVar('predikat'),
            'keterangan'   => $this->request->getVar('keterangan')
        ]);

        return redirect()->to(base_url('guru/hafalan'))->with('success', 'Data setoran hafalan berhasil ditambahkan!');
    }

    // Method untuk Memperbarui Data Hafalan
    public function update($id)
    {
        // Validasi input form edit (id_guru dihapus dari validasi form karena tidak ada di input modal)
        if (!$this->validate([
            'id_santri'    => 'required|numeric',
            'jenis'        => 'required',
            'juz'          => 'required|numeric',
            'surah'        => 'required',
            'ayat_mulai'   => 'required|numeric',
            'ayat_selesai' => 'required|numeric',
            'predikat'     => 'required'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui! Mohon cek kembali inputan anda.');
        }

        $this->hafalanModel->update($id, [
            'id_santri'    => $this->request->getVar('id_santri'),
            'jenis'        => $this->request->getVar('jenis'),
            'juz'          => $this->request->getVar('juz'),
            'surah'        => $this->request->getVar('surah'),
            'ayat_mulai'   => $this->request->getVar('ayat_mulai'),
            'ayat_selesai' => $this->request->getVar('ayat_selesai'),
            'predikat'     => $this->request->getVar('predikat'),
            'keterangan'   => $this->request->getVar('keterangan')
        ]);

        // Arahkan kembali ke halaman hafalan guru (sesuaikan dengan role kamu saat ini)
        return redirect()->to(base_url('guru/hafalan'))->with('success', 'Data setoran hafalan berhasil diperbarui!');
    }

    // Method untuk Menghapus Data Hafalan
    public function delete($id)
    {
        $hafalan = $this->hafalanModel->find($id);

        if (!$hafalan) {
            return redirect()->to(base_url('guru/hafalan'))->with('error', 'Data hafalan tidak ditemukan.');
        }

        $this->hafalanModel->delete($id);

        return redirect()->to(base_url('guru/hafalan'))->with('success', 'Data hafalan berhasil dihapus!');
    }
}
