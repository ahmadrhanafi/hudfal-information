<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;

class Profile extends BaseController
{
    public function index()
    {
        $userId = session()->get('id');

        return view('guru/profile');
    }
}
