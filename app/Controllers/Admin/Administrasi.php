<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PembayaranModel;
use App\Models\SantriModel;
use App\Models\KelasModel;

class Administrasi extends BaseController
{
    protected $pembayaranModel;
    protected $santriModel;
    protected $kelasModel;

    public function __construct()
    {
        $this->pembayaranModel = new PembayaranModel();
        $this->santriModel     = new SantriModel();
        $this->kelasModel      = new KelasModel();
    }

    public function index()
    {
        $perPage = 10;

        // Ambil nilai filter dari parameter URL (GET), jika kosong gunakan bulan/tahun saat ini
        $selectedMonth = $this->request->getGet('month') ?? date('m');
        $selectedYear  = $this->request->getGet('year') ?? date('Y');
        $selectedStatus = $this->request->getGet('status') ?? '';
        $keyword       = $this->request->getGet('keyword') ?? '';

        // Base query untuk pembayaran
        $builder = $this->pembayaranModel->getPembayaranWithSantri();

        // Filter berdasarkan Bulan & Tahun
        if (!empty($selectedMonth)) {
            $builder->where('MONTH(pembayaran.tanggal)', $selectedMonth);
            $builder->where('YEAR(pembayaran.tanggal)', $selectedYear);
        }

        // Filter berdasarkan Status jika dipilih
        if (!empty($selectedStatus)) {
            $builder->where('pembayaran.status', $selectedStatus);
        }

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('santri.nama_santri', $keyword)
                ->orLike('wali.nama_wali', $keyword)
                ->orLike('pembayaran.keterangan', $keyword)
                ->groupEnd();
        }

        // Hitung Total Pembayaran Masuk (Status Lunas) menggunakan query murni
        $totalBulanIni = $this->pembayaranModel->db->table('pembayaran')
            ->selectSum('jumlah')
            ->where('status', 'Lunas')
            ->where('MONTH(tanggal)', $selectedMonth)
            ->where('YEAR(tanggal)', $selectedYear)
            ->get()
            ->getRow()
            ->jumlah ?? 0;

        // Hitung Jumlah Transaksi Lunas
        $countLunasBulanIni = $this->pembayaranModel->db->table('pembayaran')
            ->where('status', 'Lunas')
            ->where('MONTH(tanggal)', $selectedMonth)
            ->where('YEAR(tanggal)', $selectedYear)
            ->countAllResults();

        // Hitung Jumlah Pending / Belum Lunas
        $countPending = $this->pembayaranModel->db->table('pembayaran')
            ->whereIn('status', ['Pending', 'Menunggu Verifikasi', 'tertunda'])
            ->where('MONTH(tanggal)', $selectedMonth)
            ->where('YEAR(tanggal)', $selectedYear)
            ->countAllResults();

        $data = [
            'title'              => 'Administrasi',
            'icon'               => 'fa-solid fa-file-invoice-dollar',
            'administrasi'       => $builder->paginate($perPage, 'administrasi'),
            'pager'              => $this->pembayaranModel->pager,
            'listKelas'          => $this->kelasModel->findAll(),
            'listSantri'         => $this->santriModel->select('santri.id, santri.nama_santri, santri.id_kelas, kelas.nama_kelas')
                ->join('kelas', 'kelas.id = santri.id_kelas', 'left')
                ->where('santri.status_aktif', 'Aktif')
                ->findAll(),
            'role'               => session()->get('role') ?? 'admin',
            'totalBulanIni'      => $totalBulanIni,
            'countLunasBulanIni' => $countLunasBulanIni,
            'countPending'       => $countPending,
            'selectedMonth'      => $selectedMonth,
            'selectedYear'       => $selectedYear,
            'selectedStatus'     => $selectedStatus,
            'keyword'            => $keyword
        ];

        return view('admin/administrasi', $data);
    }

    public function store()
    {
        $targetType = $this->request->getPost('target_type') ?? 'satuan';

        $rules = [
            'target_type'      => 'required|in_list[satuan,kelas,semua]',
            'tanggal'          => 'required|valid_date',
            'jenis_pembayaran' => 'required|string|max_length[100]',
            'jumlah'           => 'required|numeric',
            'status'           => 'required|in_list[Lunas,Pending,Gagal,Menunggu Verifikasi]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $targetSantriIds = [];

        if ($targetType === 'satuan') {
            $targetSantriIds = [$this->request->getPost('id_santri')];
        } elseif ($targetType === 'kelas') {
            $idKelas = $this->request->getPost('id_kelas');
            $santriKelas = $this->santriModel->where('id_kelas', $idKelas)
                ->where('status_aktif', 'Aktif')
                ->findAll();
            $targetSantriIds = array_column($santriKelas, 'id');
        } else {
            $semuaSantri = $this->santriModel->where('status_aktif', 'Aktif')
                ->findAll();
            $targetSantriIds = array_column($semuaSantri, 'id');
        }

        // Validasi jika ternyata daftar santri kosong
        if (empty($targetSantriIds) || empty($targetSantriIds[0])) {
            return redirect()->back()->withInput()->with('error', 'Tidak ada santri aktif yang ditemukan pada target tersebut.');
        }

        $dataForm = [
            'tanggal'          => $this->request->getPost('tanggal'),
            'jenis_pembayaran' => $this->request->getPost('jenis_pembayaran'),
            'jumlah'           => $this->request->getPost('jumlah'),
            'status'           => $this->request->getPost('status'),
            'keterangan'       => $this->request->getPost('keterangan'),
            'created_at'       => date('Y-m-d H:i:s')
        ];

        $batchData = [];
        foreach ($targetSantriIds as $idSantri) {
            $tmp = $dataForm;
            $tmp['id_santri'] = $idSantri;
            $batchData[] = $tmp;
        }

        // Simpan menggunakan insertBatch
        $this->pembayaranModel->insertBatch($batchData);

        return redirect()->to(base_url('admin/administrasi'))->with('success', 'Berhasil! Data tagihan ditambahkan ke ' . count($targetSantriIds) . ' santri.');
    }

    public function update($id)
    {
        $rules = [
            'id_santri'        => 'required|integer',
            'tanggal'          => 'required|valid_date',
            'jenis_pembayaran' => 'required|string|max_length[100]',
            'jumlah'           => 'required|numeric',
            'status'           => 'required|in_list[Lunas,Pending,Gagal,Menunggu Verifikasi]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->pembayaranModel->update($id, [
            'id_santri'        => $this->request->getPost('id_santri'),
            'tanggal'          => $this->request->getPost('tanggal'),
            'jenis_pembayaran' => $this->request->getPost('jenis_pembayaran'),
            'jumlah'           => $this->request->getPost('jumlah'),
            'status'           => $this->request->getPost('status'),
            'keterangan'       => $this->request->getPost('keterangan'),
        ]);

        return redirect()->to(base_url('admin/administrasi'))->with('success', 'Data pembayaran berhasil diperbarui!');
    }

    // Method Verifikasi Cepat oleh Admin (Ubah status jadi Lunas)
    public function verifikasi($id)
    {
        $pembayaran = $this->pembayaranModel->find($id);

        if (!$pembayaran) {
            return redirect()->to(base_url('admin/administrasi'))->with('error', 'Data pembayaran tidak ditemukan!');
        }

        $this->pembayaranModel->update($id, [
            'status' => 'Lunas'
        ]);

        return redirect()->to(base_url('admin/administrasi'))->with('success', 'Pembayaran berhasil diverifikasi menjadi Lunas!');
    }

    public function delete($id)
    {
        $pembayaran = $this->pembayaranModel->find($id);

        if (!$pembayaran) {
            return redirect()->to(base_url('admin/administrasi'))->with('error', 'Data pembayaran tidak ditemukan!');
        }

        $this->pembayaranModel->delete($id);

        return redirect()->to(base_url('admin/administrasi'))->with('success', 'Data pembayaran berhasil dihapus!');
    }

    public function exportExcel()
    {
        $selectedMonth  = $this->request->getGet('month') ?? date('m');
        $selectedYear   = $this->request->getGet('year') ?? date('Y');
        $selectedStatus = $this->request->getGet('status') ?? '';

        // Ambil data sesuai filter yang sedang aktif
        $builder = $this->pembayaranModel->getPembayaranWithSantri();

        if (!empty($selectedMonth)) {
            $builder->where('MONTH(pembayaran.tanggal)', $selectedMonth);
            $builder->where('YEAR(pembayaran.tanggal)', $selectedYear);
        }

        if (!empty($selectedStatus)) {
            $builder->where('pembayaran.status', $selectedStatus);
        }

        $dataPembayaran = $builder->findAll();

        // Nama file berdasarkan bulan rekap
        $filename = "Rekap-Keuangan-Bulan-" . $selectedMonth . "-" . $selectedYear . ".xls";

        // Header agar browser mendownloadnya sebagai file Excel
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Buat tabel HTML sederhana yang otomatis dibaca rapi oleh Excel
        echo '<table border="1">';
        echo '<thead>';
        echo '<tr style="background-color: #d1e7dd;">';
        echo '<th>No</th>';
        echo '<th>Nama Santri</th>';
        echo '<th>Kelas</th>';
        echo '<th>Tanggal</th>';
        echo '<th>Jenis Pembayaran</th>';
        echo '<th>Jumlah (Rp)</th>';
        echo '<th>Status</th>';
        echo '<th>Keterangan</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $no = 1;
        foreach ($dataPembayaran as $row) {
            echo '<tr>';
            echo '<td>' . $no++ . '</td>';
            echo '<td>' . $row['nama_santri'] . '</td>';
            echo '<td>' . ($row['nama_kelas'] ?? '-') . '</td>';
            echo '<td>' . $row['tanggal'] . '</td>';
            echo '<td>' . $row['jenis_pembayaran'] . '</td>';
            echo '<td>' . $row['jumlah'] . '</td>';
            echo '<td>' . $row['status'] . '</td>';
            echo '<td>' . ($row['keterangan'] ?? '-') . '</td>';
            echo '</td>';
        }

        echo '</tbody>';
        echo '</table>';
        exit();
    }
}
