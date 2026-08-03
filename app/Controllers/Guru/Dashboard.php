<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\HafalanModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $refId = session()->get('ref_id');

        // Ambil data guru beserta nama kelasnya
        $guru = $db->table('guru')
            ->select('guru.*, kelas.nama_kelas')
            ->join('kelas', 'kelas.id = guru.id_kelas_diampu', 'left')
            ->where('guru.id', $refId)
            ->get()
            ->getRowArray();

        $setoranHafalan = [];
        $infoKelasBinaan = null;
        $totalSantriBinaan = 0;
        $totalSetoranHariIni = 0;
        $totalJadwalHariIni = 1;

        if ($guru && !empty($guru['id_kelas_diampu'])) {
            $idKelas = $guru['id_kelas_diampu'];

            $totalSantriBinaan = $db->table('santri')
                ->where('id_kelas', $idKelas)
                ->countAllResults();

            $tanggalHariIni = date('Y-m-d');
            $totalSetoranHariIni = $db->table('hafalan')
                ->join('santri', 'santri.id = hafalan.id_santri')
                ->where('santri.id_kelas', $idKelas)
                ->where('DATE(hafalan.created_at)', $tanggalHariIni)
                ->countAllResults();

            $setoranHafalan = $db->table('hafalan')
                ->select('hafalan.*, santri.nama_santri, kelas.nama_kelas')
                ->join('santri', 'santri.id = hafalan.id_santri')
                ->join('kelas', 'kelas.id = santri.id_kelas')
                ->where('santri.id_kelas', $idKelas)
                ->orderBy('hafalan.created_at', 'DESC')
                ->limit(5)
                ->get()
                ->getResultArray();

            $infoKelasBinaan = $db->table('kelas')
                ->where('id', $idKelas)
                ->get()
                ->getRowArray();
        }

        $data = [
            'title'               => 'Dashboard Guru',
            'setoran'             => $setoranHafalan,
            'kelas_binaan'        => $infoKelasBinaan,
            'total_santri_binaan' => $totalSantriBinaan,
            'total_setoran_hari_ini' => $totalSetoranHariIni,
            'guru'                => $guru
        ];

        return view('guru/dashboard', $data);
    }
}
