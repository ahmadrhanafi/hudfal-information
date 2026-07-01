<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $role = session()->get('role');
        // Arahkan ke folder masing-masing
        return view($role . '/dashboard');
    }
}
