<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Ekartu extends BaseController
{
    public function index()
    {
        return view('admin/ekartu');
    }
}
