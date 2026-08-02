<?php

namespace App\Controllers\Wali;

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
        $idWali = session()->get('ref_id');

        $santriList = $this->santriModel->select('santri.*, kelas.nama_kelas')
            ->join('kelas', 'kelas.id = santri.id_kelas', 'left')
            ->where('santri.id_wali', $idWali)
            ->findAll();

        $idSantriDipilih = $this->request->getGet('id_santri');

        if (empty($idSantriDipilih) && !empty($santriList)) {
            $idSantriDipilih = $santriList[0]['id'];
        }

        $santriAktif = null;
        $riwayat = [];

        if (!empty($idSantriDipilih)) {
            $santriAktif = $this->santriModel->select('santri.*, kelas.nama_kelas')
                ->join('kelas', 'kelas.id = santri.id_kelas', 'left')
                ->where('santri.id', $idSantriDipilih)
                ->first();

            if ($santriAktif) {
                $riwayat = $this->hafalanModel->select('hafalan.*, guru.nama_guru as nama_penguji')
                    ->join('guru', 'guru.id = hafalan.id_guru', 'left')
                    ->where('hafalan.id_santri', $idSantriDipilih)
                    ->orderBy('hafalan.created_at', 'DESC')
                    ->findAll();
            }
        }

        $data = [
            'title'        => 'Riwayat Hafalan',
            'icon'         => 'fa-solid fa-history',
            'santri_list'  => $santriList,
            'santri_aktif' => $santriAktif,
            'riwayat'      => $riwayat
        ];

        return view('wali/riwayat_hafalan', $data);
    }
}
