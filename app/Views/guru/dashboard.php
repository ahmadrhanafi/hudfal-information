<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Welcome Banner / Hero Section -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 position-relative overflow-hidden">
        <div class="card-body p-4 p-md-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill mb-2 fw-semibold small">
                        <i class="fa-solid fa-chalkboard-user me-1"></i> Portal Pengajar Pesantren
                    </span>
                    <h2 class="fw-bold text-dark mb-2" style="text-transform: none !important;">Ahlan wa Sahlan, Ustadz Ahmad Hidayat, Lc.</h2>
                    <p class="text-muted mb-3 small" style="text-transform: none !important;">
                        Berikut adalah ringkasan jadwal mengajar hari ini, rekap setoran hafalan santri binaan, dan tugas pengarsipan nilai.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="<?= base_url('ustadz/hafalan/tambah') ?>" class="btn btn-success btn-sm px-3 rounded-pill shadow-sm" style="text-transform: none !important;">
                            <i class="fa-solid fa-plus me-1"></i> Input Setoran Baru
                        </a>
                        <a href="<?= base_url('ustadz/absensi') ?>" class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm" style="text-transform: none !important;">
                            <i class="fa-solid fa-clipboard-user text-success me-1"></i> Absensi Kelas
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 text-center d-none d-lg-block">
                    <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto text-success" style="width: 120px; height: 120px;">
                        <i class="fa-solid fa-mosque fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Ringkasan Kartu -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-15 p-3 rounded-3 text-success">
                        <i class="fa-solid fa-users fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">SANTRI BINAAN WALI KELAS</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">28 <span class="fs-6 fw-normal text-muted">Santri</span></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-15 p-3 rounded-3 text-primary">
                        <i class="fa-solid fa-book-quran fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">SETORAN HARI INI</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">12 <span class="fs-6 fw-normal text-muted">Santri</span></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-15 p-3 rounded-3 text-warning">
                        <i class="fa-solid fa-calendar-check fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">JADWAL MENGAJAR</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">3 <span class="fs-6 fw-normal text-muted">Sesi Hari Ini</span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Bawah: Jadwal Mengajar & Setoran Terbaru -->
    <div class="row g-4">
        <!-- Jadwal Mengajar Hari Ini -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-bold text-dark m-0" style="text-transform: none !important;">
                            <i class="fa-solid fa-clock text-success me-2"></i> Jadwal Mengajar
                        </h5>
                        <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 small">Hari Ini</span>
                    </div>
                    <p class="text-muted small mb-4" style="text-transform: none !important;">Daftar kelas dan sesi pengajaran yang harus dihadiri hari ini.</p>

                    <!-- Item Jadwal 1 -->
                    <div class="d-flex align-items-start gap-3 p-3 bg-light rounded-4 mb-3">
                        <div class="bg-success text-white rounded-3 p-2 text-center" style="min-width: 55px;">
                            <small class="d-block fw-bold" style="font-size: 0.7rem;">SESI 1</small>
                            <span style="font-size: 0.8rem;">07:30</span>
                        </div>
                        <div>
                            <h6 class="fw-semibold text-dark mb-1" style="font-size: 0.9rem;">Tahfidz Al-Qur'an (Juz 30)</h6>
                            <p class="text-muted small mb-1">Kelas 8 Tsanawiyah Putra</p>
                            <span class="badge bg-white text-success border px-2 py-0" style="font-size: 0.75rem;">Berlangsung / Aktif</span>
                        </div>
                    </div>

                    <!-- Item Jadwal 2 -->
                    <div class="d-flex align-items-start gap-3 p-3 bg-light rounded-4 mb-2">
                        <div class="bg-secondary text-white rounded-3 p-2 text-center" style="min-width: 55px;">
                            <small class="d-block fw-bold" style="font-size: 0.7rem;">SESI 2</small>
                            <span style="font-size: 0.8rem;">10:00</span>
                        </div>
                        <div>
                            <h6 class="fw-semibold text-dark mb-1" style="font-size: 0.9rem;">Kajian Kitab Kuning (Safinah)</h6>
                            <p class="text-muted small mb-0">Kelas 7 Tsanawiyah</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Aktivitas Setoran Hafalan Terbaru -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-bold text-dark m-0" style="text-transform: none !important;">
                            <i class="fa-solid fa-list-check text-success me-2"></i> Setoran Hafalan Terbaru
                        </h5>
                        <a href="<?= base_url('ustadz/hafalan') ?>" class="text-success small fw-semibold text-decoration-none">Lihat Semua <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                    <p class="text-muted small mb-3" style="text-transform: none !important;">Catatan setoran santri yang baru saja diuji hari ini.</p>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                <tr>
                                    <th class="py-2 ps-3">Nama Santri</th>
                                    <th class="py-2">Capaian</th>
                                    <th class="py-2 text-center">Predikat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-semibold text-dark small">Ahmad Zaki Al-Faruq</div>
                                        <small class="text-muted" style="font-size: 0.75rem;">Kelas 8 Tsanawiyah</small>
                                    </td>
                                    <td>
                                        <span class="small text-dark d-block">Surah An-Nazi'at</span>
                                        <small class="text-muted" style="font-size: 0.75rem;">Ayat 1-20</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill" style="font-size: 0.75rem;">Mumtaz</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-semibold text-dark small">Muhammad Farhan</div>
                                        <small class="text-muted" style="font-size: 0.75rem;">Kelas 8 Tsanawiyah</small>
                                    </td>
                                    <td>
                                        <span class="small text-dark d-block">Surah An-Naba'</span>
                                        <small class="text-muted" style="font-size: 0.75rem;">Ayat 1-40</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded-pill" style="font-size: 0.75rem;">Jayyid</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>