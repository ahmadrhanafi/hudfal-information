<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;
use App\Models\SantriModel;
use App\Models\HafalanModel;

class Dashboard extends BaseController
{
    protected $santriModel;
    protected $hafalanModel;

    public function __construct()
    {
        $this->santriModel  = new SantriModel();
        $this->hafalanModel = new HafalanModel();
    }

    public function index()
    {
        $santriModel  = new SantriModel();
        $hafalanModel = new HafalanModel();
        $idWali       = session()->get('ref_id') ?? session()->get('id');

        $anak = $santriModel->select('santri.*, kelas.nama_kelas')
            ->join('kelas', 'kelas.id = santri.id_kelas', 'left')
            ->where('santri.id_wali', $idWali)
            ->findAll();

        if (!empty($anak)) {
            foreach ($anak as &$a) {
                $a['stat_total_setoran'] = $hafalanModel->where('id_santri', $a['id'])->countAllResults();

                $terakhir = $hafalanModel->select('juz, ayat_mulai, ayat_selesai')
                    ->where('id_santri', $a['id'])
                    ->orderBy('created_at', 'DESC')
                    ->first();

                if ($terakhir) {
                    $a['stat_juz'] = 'Juz ' . $terakhir['juz'] . ' (Ayat ' . $terakhir['ayat_mulai'] . '-' . $terakhir['ayat_selesai'] . ')';
                } else {
                    $a['stat_juz'] = 'Belum ada setoran';
                }
            }
            unset($a);
        }

        $idsAnak = array_column($anak, 'id');
        $setoranTerbaru = [];
        if (!empty($idsAnak)) {
            $setoranTerbaru = $hafalanModel->select('hafalan.*, santri.nama_santri as nama_santri, santri.nis')
                ->join('santri', 'santri.id = hafalan.id_santri', 'inner')
                ->whereIn('hafalan.id_santri', $idsAnak)
                ->orderBy('hafalan.created_at', 'DESC')
                ->limit(5)
                ->findAll();
        }

        $data = [
            'title'           => 'Dashboard Wali',
            'anak'            => $anak,
            'setoran_terbaru' => $setoranTerbaru,
            'stat_jumlah_anak' => count($anak)
        ];

        return view('wali/dashboard', $data);
    }

    public function detailSantri($id)
    {
        $santri = $this->santriModel->select('santri.*, kelas.nama_kelas, wali.nama_wali, wali.no_hp as no_hp_wali, wali.alamat as alamat_wali')
            ->join('kelas', 'kelas.id = santri.id_kelas', 'left')
            ->join('wali', 'wali.id = santri.id_wali', 'left')
            ->find($id);

        if (!$santri) {
            return redirect()->to(base_url('admin/santri'))->with('error', 'Data santri tidak ditemukan.');
        }

        $data = [
            'title'  => 'Detail Santri',
            'icon'   => 'fa-solid fa-user-graduate',
            'santri' => $santri
        ];

        return view('wali/santri-detail', $data);
    }
}
