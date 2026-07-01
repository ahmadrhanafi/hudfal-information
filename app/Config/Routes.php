<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->get('login', 'Auth::login');
$routes->post('auth/process', 'Auth::process');
$routes->get('loading', 'Auth::loading');
$routes->get('logout', 'Auth::logout');

$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);

// Grouping agar akses lebih aman
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    $routes->get('santri', 'Admin\DataSantri::index');
});

$routes->group('ustadz', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'Ustadz\Dashboard::index');
    $routes->get('santri', 'Ustadz\DataSantri::index');
});

$routes->group('wali', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'Wali\Dashboard::index');
    $routes->get('santri', 'Wali\DataSantri::index');
});
