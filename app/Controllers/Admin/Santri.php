<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SantriModel;
use App\Models\KelasModel;
use App\Models\WaliModel;
use Dompdf\Dompdf;

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
        // Tambahkan validasi untuk tempat_lahir dan tanggal_lahir
        if (
            !$this->validate([
                'nama_santri' => 'required|min_length[3]',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required|valid_date',
                'jenis_kelamin' => 'required|in_list[L,P]',
                'id_kelas' => 'required|numeric',
                'id_wali' => 'required|numeric',
            ])
        ) {
            return redirect()->back()->withInput()->with('error', 'Gagal validasi data santri. Periksa kembali inputan Anda.');
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

        $this->santriModel->save([
            'nis' => $nis,
            'nama_santri' => $this->request->getVar('nama_santri'),
            'tempat_lahir' => $this->request->getVar('tempat_lahir'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'id_kelas' => $this->request->getVar('id_kelas'),
            'id_wali' => $this->request->getVar('id_wali'),
            'status_aktif' => 'Aktif',
        ]);

        return redirect()->to(base_url('admin/santri'))->with('success', 'Data santri berhasil ditambahkan! NIS: ' . $nis);
    }

    public function update($id)
    {
        if (
            !$this->validate([
                'nama_santri' => 'required|min_length[3]',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required|valid_date',
                'jenis_kelamin' => 'required|in_list[L,P]',
                'id_kelas' => 'required|numeric',
                'id_wali' => 'required|numeric',
            ])
        ) {
            return redirect()->back()->withInput()->with('error', 'Gagal validasi data santri. Periksa kembali inputan Anda.');
        }

        $santriLama = $this->santriModel->find($id);

        $nis = $this->request->getVar('nis');
        if (empty($nis)) {
            $nis = $santriLama['nis'] ?? '';
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
        ]);

        return redirect()->to(base_url('admin/santri'))->with('success', 'Data santri berhasil diperbarui!');
    }

    public function delete($id)
    {
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

        $dompdf = new Dompdf();
        $html = view('admin/cetak_ekartu_santri', ['santri' => $santri]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('a7', 'landscape');
        $dompdf->render();
        $dompdf->stream("Kartu_Santri_" . $santri['nama_santri'] . ".pdf", ["Attachment" => 0]);
    }
}