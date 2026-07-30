<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\HafalanModel;
use App\Models\SantriModel;

class RiwayatHafalan extends BaseController
{
    protected $hafalanModel;
    protected $santriModel;

    public function __construct()
    {
        $this->hafalanModel = new HafalanModel();
        $this->santriModel = new SantriModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $idKelasGuru = session()->get('id_kelas');
        $builder = $this->santriModel->select('santri.*, kelas.nama_kelas')
            ->join('kelas', 'kelas.id = santri.id_kelas', 'left');

        if (!empty($idKelasGuru)) {
            $builder->where('santri.id_kelas', $idKelasGuru);
        } else {
            $builder->where('santri.id_kelas', 0);
        }

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('santri.nama_santri', $keyword)
                ->orLike('santri.nis', $keyword)
                ->groupEnd();
        }

        $data = [
            'title'   => 'Riwayat Hafalan Santri',
            'santri'  => $builder->findAll(),
            'keyword' => $keyword
        ];

        return view('guru/riwayat_hafalan', $data);
    }

    // Menampilkan detail riwayat setoran hafalan per santri
    public function detail($id_santri)
    {
        $santri = $this->santriModel->select('santri.*, kelas.nama_kelas')
            ->join('kelas', 'kelas.id = santri.id_kelas', 'left')
            ->where('santri.id', $id_santri)
            ->first();

        if (!$santri) {
            return redirect()->back()->with('error', 'Data santri tidak ditemukan.');
        }

        // Ambil semua riwayat hafalan berdasarkan id_santri
        $riwayat = $this->hafalanModel->where('id_santri', $id_santri)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $data = [
            'title'   => 'Detail Riwayat Hafalan - ' . $santri['nama_santri'],
            'santri'  => $santri,
            'riwayat' => $riwayat
        ];

        return view('guru/_detail_riwayat_hafalan', $data); // Sesuaikan path view lo
    }
}
