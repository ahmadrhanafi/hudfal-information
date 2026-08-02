<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\SantriModel;
use App\Models\GuruModel;

class Santri extends BaseController
{
    protected $santriModel;
    protected $guruModel;

    public function __construct()
    {
        $this->santriModel = new SantriModel();
        $this->guruModel = new GuruModel();
    }
    public function index()
    {
        $role = session()->get('role');

        // Asumsikan saat login Anda juga menyimpan NIP atau ID Guru di session, 
        // atau kita cari berdasarkan nama yang sedang aktif.
        $namaGuru = session()->get('name');

        if ($role == 'guru') {
            $guru = $this->guruModel->where('nama_guru', $namaGuru)->first();

            if (!$guru) {
                $guru = $this->guruModel->like('nama_guru', str_replace(['Ust.', 'Ustz.'], '', $namaGuru))->first();
            }

            $idKelasDiampu = $guru ? $guru['id_kelas_diampu'] : null;

            $keyword = $this->request->getGet('keyword');
            $status = $this->request->getGet('status');

            $santri = $this->santriModel->searchSantri($keyword, $idKelasDiampu, $status);

            $data = [
                'title'  => 'Data Santri',
                'icon'   => 'fa-solid fa-user-graduate',
                'santri' => $santri,
                'role'   => $role
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
            'title'  => 'Detail Santri',
            'santri' => $santri
        ];

        return view('guru/santri-detail', $data);
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

        // Ambil data santri khusus kelas yang diajar guru tersebut (tanpa keyword/status agar tercetak semua)
        $santri = $this->santriModel->searchSantri(null, $idKelasDiampu, null);

        // Ambil nama kelas untuk judul laporan/nama file
        $kelasModel = new \App\Models\KelasModel();
        $kelas = $kelasModel->find($idKelasDiampu);

        $data = [
            'nama_guru'  => $guru['nama_guru'] ?? '-',
            'nama_kelas' => $kelas['nama_kelas'] ?? 'Semua Kelas',
            'santri'     => $santri
        ];

        $html = view('guru/cetak_data_santri', $data);

        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $nama_file = 'Laporan_Santri_' . str_replace(' ', '_', $kelas['nama_kelas'] ?? 'Binaan') . '.pdf';

        $dompdf->stream($nama_file, ['Attachment' => true]);
        exit;
    }
}
