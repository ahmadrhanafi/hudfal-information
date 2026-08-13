<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\SantriModel;
use App\Models\GuruModel;
use App\Models\KelasModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Santri extends BaseController
{
    protected $santriModel;
    protected $guruModel;
    protected $kelasModel;

    public function __construct()
    {
        $this->santriModel = new SantriModel();
        $this->guruModel = new GuruModel();
        $this->kelasModel = new KelasModel();

        if (!session()->get('logged_in') || session()->get('role') !== 'guru') {
            header('Location: ' . base_url('login'));
            exit();
        }
    }

    public function index()
    {
        $role = session()->get('role');
        $namaGuru = session()->get('name');

        if ($role == 'guru') {
            $guru = $this->guruModel->where('nama_guru', $namaGuru)->first();

            if (!$guru) {
                $guru = $this->guruModel->like('nama_guru', str_replace(['Ust.', 'Ustz.'], '', $namaGuru))->first();
            }

            $idKelasDiampu = $guru ? $guru['id_kelas_diampu'] : null;

            $namaKelasString = '-';
            if ($idKelasDiampu) {
                $kelas = $this->kelasModel->find($idKelasDiampu);
                $namaKelasString = $kelas['nama_kelas'] ?? '-';
            }

            $keyword = $this->request->getGet('keyword');
            $status = $this->request->getGet('status');

            $santri = $this->santriModel->searchSantri($keyword, $idKelasDiampu, $status);

            // Jika searchSantri mengembalikan query builder, tambahkan paginate(10) atau findAll()
            // Contoh jika pakai pagination: 
            // $santri = $this->santriModel->searchSantri($keyword, $idKelasDiampu, $status)->paginate(10, 'santri');

            $data = [
                'title' => 'Data Santri',
                'icon' => 'fa-solid fa-user-graduate',
                'santri' => $santri,
                'nama_kelas' => $namaKelasString,
                'role' => $role
            ];

            return view('guru/data_santri', $data);
        } elseif ($role == 'admin') {
            return redirect()->to('/admin/santri');
        } else {
            return redirect()->to('/login');
        }
    }

    public function detail($id)
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
            'santri' => $santri
        ];

        return view('guru/santri-detail', $data);
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

        // Konfigurasi Options Dompdf untuk Production (Hosting)
        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('chroot', FCPATH);

        $dompdf = new \Dompdf\Dompdf($options);

        $html = view('guru/cetak_ekartu_santri', [
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

    public function cetak()
    {
        $role = session()->get('role');
        if ($role !== 'guru') {
            return redirect()->to('/login');
        }

        $namaGuru = session()->get('name');
        $guru = $this->guruModel->where('nama_guru', $namaGuru)->first();

        if (!$guru) {
            $guru = $this->guruModel->like('nama_guru', str_replace(['Ust.', 'Ustz.'], '', $namaGuru))->first();
        }

        $idKelasDiampu = $guru ? $guru['id_kelas_diampu'] : null;

        $santri = $this->santriModel->searchSantri(null, $idKelasDiampu, null);

        $kelasModel = new \App\Models\KelasModel();
        $kelas = $kelasModel->find($idKelasDiampu);

        $data = [
            'nama_guru' => $guru['nama_guru'] ?? '-',
            'nama_kelas' => $kelas['nama_kelas'] ?? 'Semua Kelas',
            'santri' => $santri
        ];

        // FITUR OPSIONAL: Jika diakses dengan /cetak?print=1 di URL, tampilkan debug isinya
        if ($this->request->getGet('print') == 1) {
            echo "<pre>";
            print_r($data);
            echo "</pre>";
            exit;
        }

        $html = view('guru/cetak_data_santri', $data);

        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $nama_kelas_bersih = preg_replace('/[^A-Za-z0-9\-_]/', '_', $kelas['nama_kelas'] ?? 'Binaan');
        $nama_file = 'Laporan_Santri_' . $nama_kelas_bersih . '.pdf';

        $dompdf->stream($nama_file, ['Attachment' => true]);
        exit;
    }
}
