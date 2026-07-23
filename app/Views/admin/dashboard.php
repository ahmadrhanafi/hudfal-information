<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Welcome Banner Modern -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 position-relative overflow-hidden">
                <div class="position-absolute end-0 bottom-0 translate-middle-y me-5 d-none d-lg-block opacity-10">
                    <i class="fa-solid fa-mosque fa-7x text-success"></i>
                </div>
                <div style="z-index: 1;">
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-semibold mb-2" style="text-transform: none !important;">
                        <i class="fa-solid fa-circle-check me-1"></i> Panel Administrator
                    </span>
                    <h3 class="fw-bold text-dark mb-1" style="text-transform: none !important;">Selamat Datang, <?= session()->get('name') ?>! 👋</h3>
                    <p class="text-muted mb-0" style="text-transform: none !important;">Berikut adalah ringkasan data operasional sistem informasi pesantren Hudfal saat ini.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Cards Row -->
    <div class="row g-4 mb-4">
        <!-- Card 1: Total Ustadz -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-primary">
                            <i class="fa-solid fa-chalkboard-user fa-lg"></i>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold" style="text-transform: none !important;">Aktif</span>
                    </div>
                    <h6 class="text-muted mb-1 font-monospace small" style="text-transform: none !important;">TOTAL USTADZ</h6>
                    <h2 class="fw-bold text-dark mb-0">12</h2>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Santri -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-success bg-opacity-10 p-3 rounded-3 text-success">
                            <i class="fa-solid fa-user-graduate fa-lg"></i>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success fw-semibold" style="text-transform: none !important;">Keseluruhan</span>
                    </div>
                    <h6 class="text-muted mb-1 font-monospace small" style="text-transform: none !important;">TOTAL SANTRI</h6>
                    <h2 class="fw-bold text-dark mb-0">148</h2>
                </div>
            </div>
        </div>

        <!-- Card 3: Setoran Hafalan -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-3 text-warning">
                            <i class="fa-solid fa-book-quran fa-lg"></i>
                        </div>
                        <span class="badge bg-warning bg-opacity-10 text-warning fw-semibold" style="text-transform: none !important;">Bulan Ini</span>
                    </div>
                    <h6 class="text-muted mb-1 font-monospace small" style="text-transform: none !important;">SETORAN HAFALAN</h6>
                    <h2 class="fw-bold text-dark mb-0">520</h2>
                </div>
            </div>
        </div>

        <!-- Card 4: Administrasi -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-danger bg-opacity-10 p-3 rounded-3 text-danger">
                            <i class="fa-solid fa-file-invoice-dollar fa-lg"></i>
                        </div>
                        <span class="badge bg-danger bg-opacity-10 text-danger fw-semibold" style="text-transform: none !important;">Pembayaran</span>
                    </div>
                    <h6 class="text-muted mb-1 font-monospace small" style="text-transform: none !important;">PEMBAYARAN MASUK</h6>
                    <h2 class="fw-bold text-dark mb-0">Rp 12.5 Juta</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Bawah: Grafik & Menu Pintasan -->
    <div class="row g-4">
        <!-- Kolom Grafik / Aktivitas -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="fw-bold text-dark m-0" style="text-transform: none !important;">
                            <i class="fa-solid fa-chart-line text-success me-2"></i> Statistik Perkembangan Hafalan
                        </h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Bulan Ini
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Minggu Ini</a></li>
                                <li><a class="dropdown-item" href="#">Bulan Ini</a></li>
                                <li><a class="dropdown-item" href="#">Tahun Ini</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert alert-light border border-2 border-dashed rounded-4 text-center py-5 text-muted">
                        <i class="fa-solid fa-chart-pie fa-2x mb-2 text-secondary opacity-50"></i>
                        <p class="mb-0 small" style="text-transform: none !important;">Grafik aktivitas sistem akan dirender di sini setelah dihubungkan dengan database.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Menu Pintasan -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-success text-white h-100 position-relative overflow-hidden">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-white bg-opacity-25 p-3 rounded-3 text-white me-3">
                                <i class="fa-solid fa-bolt fa-lg"></i>
                            </div>
                            <h5 class="fw-bold m-0 text-white" style="text-transform: none !important;">Menu Pintasan</h5>
                        </div>
                        <p class="small text-white-50 mb-4" style="text-transform: none !important;">Akses cepat fitur utama administrasi pesantren tanpa harus mencari di menu sidebar.</p>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="<?= base_url('admin/santri') ?>" class="btn btn-light text-success fw-semibold rounded-3 py-2 text-start px-3 shadow-sm d-flex align-items-center justify-content-between" style="text-transform: none !important;">
                            <span><i class="fa-solid fa-user-plus me-2 text-success"></i> Kelola Data Santri</span>
                            <i class="fa-solid fa-arrow-right small"></i>
                        </a>
                        <a href="<?= base_url('admin/administrasi') ?>" class="btn btn-light text-success fw-semibold rounded-3 py-2 text-start px-3 shadow-sm d-flex align-items-center justify-content-between" style="text-transform: none !important;">
                            <span><i class="fa-solid fa-receipt me-2 text-success"></i> Cek Pembayaran</span>
                            <i class="fa-solid fa-arrow-right small"></i>
                        </a>
                        <a href="<?= base_url('admin/ustadz') ?>" class="btn btn-light text-success fw-semibold rounded-3 py-2 text-start px-3 shadow-sm d-flex align-items-center justify-content-between" style="text-transform: none !important;">
                            <span><i class="fa-solid fa-chalkboard-user me-2 text-success"></i> Data Ustadz & Kelas</span>
                            <i class="fa-solid fa-arrow-right small"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>