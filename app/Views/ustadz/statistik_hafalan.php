<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1" style="text-transform: none !important;">Statistik Hafalan Santri Binaan</h3>
            <p class="text-muted mb-0 small" style="text-transform: none !important;">Analisis grafik perkembangan setoran, rata-rata hafalan, dan evaluasi kelas bimbingan Anda.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm" style="text-transform: none !important;">
                <i class="fa-solid fa-download text-success me-1"></i> Unduh Laporan Kelas
            </button>
            <div class="dropdown">
                <button class="btn btn-success btn-sm px-3 rounded-pill shadow-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" style="text-transform: none !important;">
                    <i class="fa-solid fa-filter me-1"></i> Periode: Bulan Ini
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                    <li><a class="dropdown-item small" href="#">Minggu Ini</a></li>
                    <li><a class="dropdown-item small" href="#">Bulan Ini</a></li>
                    <li><a class="dropdown-item small" href="#">Semester Ini</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Analitik Ringkasan Kartu -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-15 p-3 rounded-3 text-success">
                        <i class="fa-solid fa-chart-line fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">RATA-RATA SETORAN KELAS</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">28.2 <span class="fs-6 fw-normal text-muted">Ayat / Hari</span></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-15 p-3 rounded-3 text-primary">
                        <i class="fa-solid fa-trophy fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">JUZ DOMINAN KELAS</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">Juz 30 <span class="fs-6 fw-normal text-success">(65%)</span></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-15 p-3 rounded-3 text-warning">
                        <i class="fa-solid fa-star fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">PREDIKAT TERBANYAK</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">Mumtaz <span class="fs-6 fw-normal text-muted">(Sangat Baik)</span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik & Breakdown Bagian Bawah -->
    <div class="row g-4">
        <!-- Grafik Utama (Placeholder Chart.js / Visualisasi Kelas) -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="fw-bold text-dark m-0" style="text-transform: none !important;">
                            <i class="fa-solid fa-chart-area text-success me-2"></i> Grafik Progres Hafalan Kelas Binaan
                        </h5>
                        <span class="badge bg-light text-secondary border">Kelas 8 Tsanawiyah</span>
                    </div>

                    <!-- Box simulasi area grafik -->
                    <div class="alert alert-light border border-2 border-dashed rounded-4 text-center py-5 text-muted my-3">
                        <i class="fa-solid fa-chart-line fa-3x mb-3 text-success opacity-50"></i>
                        <h6 class="fw-bold text-dark">Visualisasi Statistik Hafalan Santri</h6>
                        <p class="mb-0 small" style="text-transform: none !important;">Grafik tren setoran harian dan mingguan santri binaan termuat otomatis via pustaka Chart.js.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Berdasarkan Juz (Kelas Binaan) -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-4" style="text-transform: none !important;">
                        <i class="fa-solid fa-layer-group text-success me-2"></i> Capaian Juz Kelas
                    </h5>

                    <!-- Progress Bar 1 -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between small fw-semibold mb-1">
                            <span class="text-dark">Juz 30 (Amma)</span>
                            <span class="text-success">65%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success rounded-pill" role="progressbar" style="width: 65%;"></div>
                        </div>
                    </div>

                    <!-- Progress Bar 2 -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between small fw-semibold mb-1">
                            <span class="text-dark">Juz 29</span>
                            <span class="text-primary">20%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary rounded-pill" role="progressbar" style="width: 20%;"></div>
                        </div>
                    </div>

                    <!-- Progress Bar 3 -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between small fw-semibold mb-1">
                            <span class="text-dark">Juz 1 (Al-Baqarah)</span>
                            <span class="text-warning">10%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning rounded-pill" role="progressbar" style="width: 10%;"></div>
                        </div>
                    </div>

                    <!-- Progress Bar 4 -->
                    <div class="mb-2">
                        <div class="d-flex justify-content-between small fw-semibold mb-1">
                            <span class="text-dark">Lainnya</span>
                            <span class="text-secondary">5%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-secondary rounded-pill" role="progressbar" style="width: 5%;"></div>
                        </div>
                    </div>

                    <div class="mt-4 pt-2 text-center">
                        <small class="text-muted">Persentase dihitung dari total target hafalan kelas binaan aktif.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>