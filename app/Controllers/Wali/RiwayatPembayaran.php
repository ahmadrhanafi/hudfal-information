<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;

class RiwayatPembayaran extends BaseController
{
    public function index()
    {
        return view('wali/riwayat_pembayaran');
    }
}
