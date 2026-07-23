<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;

class Ekartu extends BaseController
{
    public function index()
    {
        return view('wali/ekartu');
    }
}
