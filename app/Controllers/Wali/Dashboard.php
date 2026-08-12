<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;
use App\Models\SantriModel;
use App\Models\HafalanModel;
use App\Models\PembayaranModel;
use Dompdf\Dompdf;

class Dashboard extends BaseController
{
    protected $santriModel;
    protected $hafalanModel;
    protected $pembayaranModel;

    public function __construct()
    {
        $this->santriModel = new SantriModel();
        $this->hafalanModel = new HafalanModel();
        $this->pembayaranModel = new PembayaranModel();

        if (!session()->get('logged_in') || session()->get('role') !== 'wali') {
            header('Location: ' . base_url('login'));
            exit();
        }
    }

    public function index()
    {
        $santriModel = new SantriModel();
        $this->hafalanModel = new HafalanModel();
        $idWali = session()->get('ref_id') ?? session()->get('id');

        $anak = $santriModel->select('santri.*, kelas.nama_kelas')
            ->join('kelas', 'kelas.id = santri.id_kelas', 'left')
            ->where('santri.id_wali', $idWali)
            ->findAll();

        if (!empty($anak)) {
            foreach ($anak as &$a) {
                $a['stat_total_setoran'] = $this->hafalanModel->where('id_santri', $a['id'])->countAllResults();

                $terakhir = $this->hafalanModel->select('juz, ayat_mulai, ayat_selesai')
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
        $tagihanTerbaru = [];

        if (!empty($idsAnak)) {
            $setoranTerbaru = $this->hafalanModel->select('hafalan.*, santri.nama_santri as nama_santri, santri.nis')
                ->join('santri', 'santri.id = hafalan.id_santri', 'inner')
                ->whereIn('hafalan.id_santri', $idsAnak)
                ->orderBy('hafalan.created_at', 'DESC')
                ->limit(5)
                ->findAll();

            $tagihanTerbaru = $this->pembayaranModel->select('pembayaran.*, santri.nama_santri, kelas.nama_kelas')
                ->join('santri', 'santri.id = pembayaran.id_santri', 'inner')
                ->join('kelas', 'kelas.id = santri.id_kelas', 'left')
                ->whereIn('pembayaran.id_santri', $idsAnak)
                ->orderBy('pembayaran.created_at', 'DESC')
                ->limit(4)
                ->findAll();
        }

        $data = [
            'title' => 'Dashboard Wali',
            'anak' => $anak,
            'setoran_terbaru' => $setoranTerbaru,
            'tagihan_terbaru' => $tagihanTerbaru,
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
            'title' => 'Detail Santri',
            'icon' => 'fa-solid fa-user-graduate',
            'santri' => $santri
        ];

        return view('wali/santri-detail', $data);
    }

    public function cetakKartu($id)
    {
        $santri = $this->santriModel->select('santri.*, kelas.nama_kelas, wali.no_hp as no_hp_wali, wali.alamat as alamat_wali')
            ->join('kelas', 'kelas.id = santri.id_kelas', 'left')
            ->join('wali', 'wali.id = santri.id_wali', 'left')
            ->find($id);

        if (!$santri)
            return redirect()->back();

        $dompdf = new Dompdf();
        $html = view('wali/cetak_ekartu_santri', ['santri' => $santri]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('a7', 'landscape');
        $dompdf->render();
        $dompdf->stream("Kartu_Santri_" . $santri['nama_santri'] . ".pdf", ["Attachment" => 0]);
    }
}
