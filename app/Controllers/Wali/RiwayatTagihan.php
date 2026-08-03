<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;
use App\Models\SantriModel;
use App\Models\PembayaranModel;

class RiwayatTagihan extends BaseController
{
    public function index()
    {
        $santriModel     = new SantriModel();
        $pembayaranModel = new PembayaranModel();

        $idWali = session()->get('ref_id') ?? session()->get('id');

        $anak = $santriModel->where('id_wali', $idWali)->findAll();
        $idsAnak = array_column($anak, 'id');

        $tagihan = [];
        if (!empty($idsAnak)) {
            $tagihan = $pembayaranModel->getPembayaranWithSantri()
                ->whereIn('pembayaran.id_santri', $idsAnak)
                ->findAll();
        }

        $data = [
            'title'   => 'Riwayat Tagihan & Pembayaran',
            'tagihan' => $tagihan,
            'anak'    => $anak
        ];

        return view('wali/riwayat_tagihan', $data);
    }

    // Method baru buat memproses konfirmasi pembayaran dari wali santri
    public function konfirmasi($id)
    {
        $pembayaranModel = new PembayaranModel();

        // 1. Ambil data tagihan berdasarkan ID dan pastikan data tersebut milik anak dari wali yang sedang login (keamanan data)
        $tagihan = $pembayaranModel->find($id);
        if (!$tagihan) {
            return redirect()->back()->with('error', 'Data tagihan tidak ditemukan.');
        }

        // 2. Ambil file bukti pembayaran yang di-upload
        $fileBukti = $this->request->getFile('bukti_pembayaran');

        if ($fileBukti && $fileBukti->isValid() && !$fileBukti->hasMoved()) {
            // Generate nama file acak yang aman
            $namaFileBaru = $fileBukti->getRandomName();

            // Pindahkan file ke folder public/uploads/bukti/
            $fileBukti->move('uploads/bukti', $namaFileBaru);

            // 3. Update data ke database tabel pembayaran
            $pembayaranModel->update($id, [
                'tanggal_konfirmasi' => $this->request->getPost('tanggal_konfirmasi'),
                'bank_tujuan'        => $this->request->getPost('bank_tujuan'),
                'bukti_pembayaran'   => $namaFileBaru,
                'status'             => 'Menunggu Verifikasi'
            ]);

            return redirect()->to(base_url('wali/riwayat-tagihan'))->with('success', 'Bukti pembayaran berhasil dikirim dan sedang menunggu verifikasi admin.');
        }

        return redirect()->back()->with('error', 'Gagal mengupload bukti pembayaran. Pastikan file valid.');
    }

    public function unduhKuitansi($id)
    {
        $pembayaranModel = new PembayaranModel();

        $tagihan = $pembayaranModel->getPembayaranWithSantri()
            ->where('pembayaran.id', $id)
            ->first();

        if (!$tagihan) {
            return redirect()->back()->with('error', 'Data tagihan tidak ditemukan.');
        }

        if ($tagihan['status'] !== 'Lunas') {
            return redirect()->back()->with('error', 'Kuitansi hanya dapat diunduh untuk tagihan yang sudah lunas.');
        }

        $data = [
            'tagihan' => $tagihan
        ];

        $html = view('wali/kuitansi_pdf', $data);

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream('kuitansi_tagihan_' . $tagihan['id'] . '.pdf', ['Attachment' => true]);
    }
}
