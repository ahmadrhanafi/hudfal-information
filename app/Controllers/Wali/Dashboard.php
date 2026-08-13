<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;
use App\Models\SantriModel;
use App\Models\HafalanModel;
use App\Models\PembayaranModel;
use Dompdf\Dompdf;
use Dompdf\Options;

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

        $base64FotoSantri = null;

        if (!empty($santri['foto'])) {
            $pathFoto = FCPATH . 'uploads/santri/' . $santri['foto'];
            if (file_exists($pathFoto)) {
                $type = pathinfo($pathFoto, PATHINFO_EXTENSION);
                $data = file_get_contents($pathFoto);
                $base64FotoSantri = 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
        }

        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('chroot', FCPATH);

        $dompdf = new \Dompdf\Dompdf($options);

        $html = view('wali/cetak_ekartu_santri', [
            'santri' => $santri,
            'base64FotoSantri' => $base64FotoSantri
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('a7', 'landscape');
        $dompdf->render();

        if (ob_get_length()) {
            ob_end_clean();
        }

        $namaFile = "Kartu_Santri_" . preg_replace('/[^A-Za-z0-9_]/', '_', $santri['nama_santri']) . ".pdf";

        // Paksa header agar dibaca sebagai aplikasi PDF oleh browser
        header("Content-Type: application/pdf");
        header("Content-Disposition: inline; filename=\"" . $namaFile . "\"");

        echo $dompdf->output();
        exit();
    }
}
