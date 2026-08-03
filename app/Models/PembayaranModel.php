<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table            = 'pembayaran';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;

    protected $allowedFields    = [
        'id_santri',
        'tanggal',
        'jenis_pembayaran',
        'jumlah',
        'status',
        'keterangan',
        'created_at',
        'updated_at',
        'bukti_pembayaran',
        'bank_tujuan',
        'tanggal_konfirmasi'
    ];

    // Method untuk mengambil data pembayaran beserta relasi ke tabel santri dan kelas
    public function getPembayaranWithSantri()
    {
        return $this->select('pembayaran.*, santri.nama_santri, kelas.nama_kelas')
            ->join('santri', 'santri.id = pembayaran.id_santri', 'left')
            ->join('kelas', 'kelas.id = santri.id_kelas', 'left')
            ->orderBy('pembayaran.created_at', 'DESC');
    }
}
