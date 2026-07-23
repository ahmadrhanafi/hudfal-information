<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Welcome Banner / Hero Section -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 position-relative overflow-hidden">
        <div class="card-body p-4 p-md-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill mb-2 fw-semibold small">
                        <i class="fa-solid fa-house-chimney-user me-1"></i> Portal Wali Santri
                    </span>
                    <h2 class="fw-bold text-dark mb-2" style="text-transform: none !important;">Ahlan wa Sahlan, Ayah / Bunda</h2>
                    <p class="text-muted mb-3 small" style="text-transform: none !important;">
                        Pantau perkembangan hafalan Al-Qur'an, status kehadiran, serta informasi pembayaran sekolah ananda <strong>Ahmad Zaki Al-Faruq</strong> di sini.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="<?= base_url('wali/hafalan') ?>" class="btn btn-success btn-sm px-3 rounded-pill shadow-sm" style="text-transform: none !important;">
                            <i class="fa-solid fa-book-quran me-1"></i> Lihat Detail Hafalan
                        </a>
                        <a href="<?= base_url('wali/administrasi') ?>" class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm" style="text-transform: none !important;">
                            <i class="fa-solid fa-wallet text-success me-1"></i> Cek Tagihan SPP
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 text-center d-none d-lg-block">
                    <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto text-success" style="width: 120px; height: 120px;">
                        <i class="fa-solid fa-child-reaching fa-3x"></i>
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
                        <i class="fa-solid fa-award fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">TOTAL HAFALAN TERCAPAI</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">Juz 30 <span class="fs-6 fw-normal text-success">(42%)</span></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-15 p-3 rounded-3 text-primary">
                        <i class="fa-solid fa-clipboard-check fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">KEHADIRAN BULAN INI</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">98% <span class="fs-6 fw-normal text-muted">Hadir</span></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-15 p-3 rounded-3 text-warning">
                        <i class="fa-solid fa-file-invoice-dollar fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">STATUS SPP BULAN INI</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">Lunas <span class="fs-6 fw-normal text-success"><i class="fa-solid fa-circle-check"></i></span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Bawah: Setoran Hafalan Terbaru & Informasi Tagihan -->
    <div class="row g-4">
        <!-- Setoran Hafalan Terbaru Ananda -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-bold text-dark m-0" style="text-transform: none !important;">
                            <i class="fa-solid fa-book-open-reader text-success me-2"></i> Setoran Hafalan Terbaru Ananda
                        </h5>
                        <a href="<?= base_url('wali/hafalan') ?>" class="text-success small fw-semibold text-decoration-none">Riwayat Lengkap <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                    <p class="text-muted small mb-3" style="text-transform: none !important;">Catatan setoran terakhir yang diuji oleh ustadz pengampu di pesantren.</p>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                <tr>
                                    <th class="py-2 ps-3">Tanggal</th>
                                    <th class="py-2">Capaian Surah</th>
                                    <th class="py-2 text-center">Predikat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-semibold text-dark small">23 Juli 2026</div>
                                        <small class="text-muted" style="font-size: 0.75rem;">Sesi Pagi</small>
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
                                        <div class="fw-semibold text-dark small">21 Juli 2026</div>
                                        <small class="text-muted" style="font-size: 0.75rem;">Sesi Pagi</small>
                                    </td>
                                    <td>
                                        <span class="small text-dark d-block">Surah An-Nazi'at</span>
                                        <small class="text-muted" style="font-size: 0.75rem;">Ayat 21-46</small>
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

        <!-- Ringkasan Profil & Pengumuman Pesantren -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-3" style="text-transform: none !important;">
                        <i class="fa-solid fa-bullhorn text-success me-2"></i> Pengumuman Pesantren
                    </h5>
                    <p class="text-muted small mb-4" style="text-transform: none !important;">Informasi penting langsung dari pengurus asrama dan akademik.</p>

                    <!-- Item Pengumuman 1 -->
                    <div class="p-3 bg-light rounded-4 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="badge bg-success bg-opacity-10 text-success px-2 py-1" style="font-size: 0.7rem;">Akademik</span>
                            <small class="text-muted" style="font-size: 0.75rem;">20 Juli 2026</small>
                        </div>
                        <h6 class="fw-semibold text-dark mb-1" style="font-size: 0.9rem;">Jadwal Penilaian Tengah Semester (PTS)</h6>
                        <p class="text-muted small mb-0" style="font-size: 0.8rem;">PTS Tahfidz dan Diniyah akan dimulai pada awal bulan Agustus 2026.</p>
                    </div>

                    <!-- Item Pengumuman 2 -->
                    <div class="p-3 bg-light rounded-4 mb-2">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1" style="font-size: 0.7rem;">Asrama</span>
                            <small class="text-muted" style="font-size: 0.75rem;">15 Juli 2026</small>
                        </div>
                        <h6 class="fw-semibold text-dark mb-1" style="font-size: 0.9rem;">Jadwal Kunjungan Wali Santri</h6>
                        <p class="text-muted small mb-0" style="font-size: 0.8rem;">Kunjungan bulanan dibuka pada hari Ahad pekan kedua mendatang.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>