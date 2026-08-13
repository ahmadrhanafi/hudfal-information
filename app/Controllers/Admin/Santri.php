<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SantriModel;
use App\Models\KelasModel;
use App\Models\WaliModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Santri extends BaseController
{
    protected $santriModel;
    protected $kelasModel;
    protected $waliModel;

    public function __construct()
    {
        $this->santriModel = new SantriModel();
        $this->kelasModel = new KelasModel();
        $this->waliModel = new WaliModel();

        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            header('Location: ' . base_url('login'));
            exit();
        }
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $selectedKelas = $this->request->getGet('id_kelas');
        $selectedStatus = $this->request->getGet('status');

        $kelasModel = new \App\Models\KelasModel();
        $waliModel = new \App\Models\WaliModel();

        $data = [
            'title' => 'Data Santri',
            'icon' => 'fa-solid fa-user-graduate',
            'santri' => $this->santriModel->searchSantri($keyword, $selectedKelas, $selectedStatus),
            'kelas' => $kelasModel->findAll(),
            'wali' => $waliModel->findAll(),
            'keyword' => $keyword,
            'selectedKelas' => $selectedKelas,
            'selectedStatus' => $selectedStatus,
            'role' => session()->get('role') ?? 'admin'
        ];

        return view('admin/data_santri', $data);
    }

    public function store()
    {
        // Validasi input termasuk file foto (opsional/boleh kosong, tapi kalau diisi harus gambar valid)
        if (
            !$this->validate([
                'nama_santri' => 'required|min_length[3]',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required|valid_date',
                'jenis_kelamin' => 'required|in_list[L,P]',
                'id_kelas' => 'required|numeric',
                'id_wali' => 'required|numeric',
                'foto' => 'uploaded[foto]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]'
            ])
        ) {
            return redirect()->back()->withInput()->with('error', 'Gagal validasi data santri atau format foto salah (Maks. 2MB, format JPG/JPEG/PNG).');
        }

        $tahun = date('Y');
        $idKelas = str_pad($this->request->getVar('id_kelas'), 2, '0', STR_PAD_LEFT);

        $lastSantri = $this->santriModel
            ->like('nis', $tahun . $idKelas, 'after')
            ->orderBy('id', 'DESC')
            ->first();

        if ($lastSantri) {
            $noUrut = (int) substr($lastSantri['nis'], -3) + 1;
        } else {
            $noUrut = 1;
        }

        $nis = $tahun . $idKelas . str_pad($noUrut, 3, '0', STR_PAD_LEFT);

        // Handle Upload Foto
        $fileFoto = $this->request->getFile('foto');
        $namaFoto = null;

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/santri', $namaFoto);
        }

        $this->santriModel->save([
            'nis' => $nis,
            'nama_santri' => $this->request->getVar('nama_santri'),
            'tempat_lahir' => $this->request->getVar('tempat_lahir'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'id_kelas' => $this->request->getVar('id_kelas'),
            'id_wali' => $this->request->getVar('id_wali'),
            'status_aktif' => 'Aktif',
            'foto' => $namaFoto,
        ]);

        return redirect()->to(base_url('admin/santri'))->with('success', 'Data santri berhasil ditambahkan! NIS: ' . $nis);
    }

    public function update($id)
    {
        // Validasi update (foto bersifat opsional saat update, hanya divalidasi jika diunggah)
        $rules = [
            'nama_santri' => 'required|min_length[3]',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|valid_date',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'id_kelas' => 'required|numeric',
            'id_wali' => 'required|numeric',
        ];

        $fileFoto = $this->request->getFile('foto');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $rules['foto'] = 'is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal validasi data santri. Periksa kembali inputan Anda.');
        }

        $santriLama = $this->santriModel->find($id);

        $nis = $this->request->getVar('nis');
        if (empty($nis)) {
            $nis = $santriLama['nis'] ?? '';
        }

        $namaFoto = $santriLama['foto']; // Tetap pakai foto lama by default

        // Jika ada file foto baru yang di-upload
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/santri', $namaFoto);

            // Hapus foto lama jika ada
            if (!empty($santriLama['foto']) && file_exists('uploads/santri/' . $santriLama['foto'])) {
                unlink('uploads/santri/' . $santriLama['foto']);
            }
        }

        $this->santriModel->update($id, [
            'nis' => $nis,
            'nama_santri' => $this->request->getVar('nama_santri'),
            'tempat_lahir' => $this->request->getVar('tempat_lahir'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'id_kelas' => $this->request->getVar('id_kelas'),
            'id_wali' => $this->request->getVar('id_wali'),
            'status_aktif' => $this->request->getVar('status_aktif') ?? 'Aktif',
            'foto' => $namaFoto,
        ]);

        return redirect()->to(base_url('admin/santri'))->with('success', 'Data santri berhasil diperbarui!');
    }

    public function delete($id)
    {
        // Ambil data untuk hapus file fisik fotonya juga
        $santri = $this->santriModel->find($id);
        if ($santri && !empty($santri['foto'])) {
            if (file_exists('uploads/santri/' . $santri['foto'])) {
                unlink('uploads/santri/' . $santri['foto']);
            }
        }

        $this->santriModel->delete($id);
        return redirect()->to(base_url('admin/santri'))->with('success', 'Data santri berhasil dihapus!');
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

        return view('admin/santri-detail', $data);
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

        $html = view('admin/cetak_ekartu_santri', [
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