<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;

class Profile extends BaseController
{
    public function index()
    {
        $userId = session()->get('id');

        return view('wali/profile');
    }
}
