<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Profile extends BaseController
{
    public function index()
    {
        $userId = session()->get('id');

        return view('admin/profile');
    }
}
