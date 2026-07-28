<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
// $routes->get('/', 'Home::index');
$routes->get('/', 'Auth::login');

$routes->get('login', 'Auth::login');
$routes->post('auth/process', 'Auth::process');
$routes->get('loading', 'Auth::loading');
$routes->get('logout', 'Auth::logout');

$routes->get('kelas', 'KelasController::index');

$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);

// Grouping agar akses lebih aman
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    // Manajemen Kelas
    $routes->get('kelas', 'Admin\Kelas::index');
    $routes->post('kelas/store', 'Admin\Kelas::store');
    $routes->post('kelas/update/(:num)', 'Admin\Kelas::update/$1');
    $routes->get('kelas/delete/(:num)', 'Admin\Kelas::delete/$1');

    $routes->get('santri', 'Admin\Santri::index');

    // Manajemen Ustadz/Guru/Pengajar
    $routes->get('ustadz', 'Admin\Ustadz::index');
    $routes->post('ustadz/store', 'Admin\Ustadz::store');
    $routes->post('ustadz/update/(:num)', 'Admin\Ustadz::update/$1');
    $routes->get('ustadz/delete/(:num)', 'Admin\Ustadz::delete/$1');

    // Manajemen Wali Santri
    $routes->get('wali-santri', 'Admin\Wali::index');
    $routes->post('wali-santri/store', 'Admin\Wali::store');
    $routes->post('wali-santri/update/(:num)', 'Admin\Wali::update/$1');
    $routes->get('wali-santri/delete/(:num)', 'Admin\Wali::delete/$1');

    $routes->get('hafalan', 'Admin\Hafalan::index');
    $routes->get('statistik-hafalan', 'Admin\Statistik::index');
    $routes->get('administrasi', 'Admin\Administrasi::index');
    $routes->get('esertifikat', 'Admin\Esertifikat::index');
    $routes->get('ekartu', 'Admin\Ekartu::index');
    $routes->get('pengaturan', 'Admin\Pengaturan::index');
});

$routes->group('guru', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'Guru\Dashboard::index');
    $routes->get('santri', 'Guru\Santri::index');
    $routes->get('hafalan', 'Guru\Hafalan::index');
    $routes->get('riwayat-hafalan', 'Guru\RiwayatHafalan::index');
    $routes->get('statistik-hafalan', 'Guru\Statistik::index');
    $routes->get('pengaturan', 'Guru\Pengaturan::index');
});

$routes->group('wali', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'Wali\Dashboard::index');
    $routes->get('riwayat-hafalan', 'Wali\RiwayatHafalan::index');
    $routes->get('riwayat-pembayaran', 'Wali\RiwayatPembayaran::index');
    $routes->get('esertifikat', 'Wali\Esertifikat::index');
    $routes->get('statistik-hafalan', 'Wali\Statistik::index');
    $routes->get('ekartu', 'Wali\Ekartu::index');
    $routes->get('pengaturan', 'Wali\Pengaturan::index');
});
