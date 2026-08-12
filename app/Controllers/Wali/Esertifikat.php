<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;

class Esertifikat extends BaseController
{
    public function __construct()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'wali') {
            header('Location: ' . base_url('login'));
            exit();
        }
    }

    public function index()
    {
        return view('wali/esertifikat');
    }
}
