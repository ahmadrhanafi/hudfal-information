<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1" style="text-transform: none !important;">e-Sertifikat & Penghargaan Ananda</h3>
            <p class="text-muted mb-0 small" style="text-transform: none !important;">Koleksi sertifikat digital dan piagam penghargaan prestasi akademik maupun tahfidz ananda.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm" style="text-transform: none !important;">
                <i class="fa-solid fa-share-nodes text-success me-1"></i> Bagikan Portofolio
            </button>
        </div>
    </div>

    <!-- Ringkasan Statistik Sertifikat -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-15 p-3 rounded-3 text-success">
                        <i class="fa-solid fa-award fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">TOTAL SERTIFIKAT</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">4 <span class="fs-6 fw-normal text-muted">Piagam</span></h3>
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
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">KATEGORI TAHFIDZ</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">2 <span class="fs-6 fw-normal text-success">Sertifikat</span></h3>
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
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">KATEGORI AKADEMIK / LOMBA</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">2 <span class="fs-6 fw-normal text-muted">Sertifikat</span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-body p-3">
            <div class="row g-3 align-items-center">
                <div class="col-lg-7">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-0 ps-3 text-muted">
                            <i class="fa-solid fa-search"></i>
                        </span>
                        <input type="text" class="form-control bg-light border-0 py-2" placeholder="Cari nama sertifikat atau jenis kegiatan...">
                    </div>
                </div>
                <div class="col-lg-5">
                    <select class="form-select form-select-sm bg-light border-0 py-2">
                        <option selected>Filter Kategori: Semua Sertifikat</option>
                        <option value="tahfidz">Tahfidz Al-Qur'an</option>
                        <option value="akademik">Akademik & Kelas</option>
                        <option value="lomba">Lomba / Ekstrakurikuler</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid Kartu e-Sertifikat -->
    <div class="row g-4">
        <!-- Item Sertifikat 1 -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100 overflow-hidden">
                <div class="bg-success bg-opacity-10 p-4 text-center position-relative">
                    <span class="badge bg-success text-white position-absolute top-0 end-0 m-3 px-3 py-1 rounded-pill small">Tahfidz</span>
                    <i class="fa-solid fa-certificate fa-4x text-success my-3"></i>
                </div>
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <span class="text-muted small" style="font-size: 0.75rem;"><i class="fa-regular fa-calendar me-1"></i> 15 Juni 2026</span>
                        <h5 class="fw-bold text-dark mt-1 mb-2" style="font-size: 1rem;">Sertifikat Khatam Juz 30 (Amma)</h5>
                        <p class="text-muted small mb-3" style="text-transform: none !important;">Diberikan atas keberhasilan menyelesaikan setoran hafalan Juz 30 dengan predikat Mumtaz.</p>
                    </div>
                    <div class="d-flex gap-2 pt-2 border-top">
                        <a href="#" class="btn btn-sm btn-outline-success w-100 rounded-pill" title="Pratinjau Sertifikat">
                            <i class="fa-solid fa-eye me-1"></i> Pratinjau
                        </a>
                        <a href="#" class="btn btn-sm btn-success w-100 rounded-pill" title="Unduh PDF">
                            <i class="fa-solid fa-download me-1"></i> Unduh PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Item Sertifikat 2 -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100 overflow-hidden">
                <div class="bg-primary bg-opacity-10 p-4 text-center position-relative">
                    <span class="badge bg-primary text-white position-absolute top-0 end-0 m-3 px-3 py-1 rounded-pill small">Akademik</span>
                    <i class="fa-solid fa-award fa-4x text-primary my-3"></i>
                </div>
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <span class="text-muted small" style="font-size: 0.75rem;"><i class="fa-regular fa-calendar me-1"></i> 10 Januari 2026</span>
                        <h5 class="fw-bold text-dark mt-1 mb-2" style="font-size: 1rem;">Juara 1 Kelas 8 Tsanawiyah Semester Ganjil</h5>
                        <p class="text-muted small mb-3" style="text-transform: none !important;">Penghargaan atas prestasi peringkat pertama dalam bidang akademik kelas 8 Tsanawiyah.</p>
                    </div>
                    <div class="d-flex gap-2 pt-2 border-top">
                        <a href="#" class="btn btn-sm btn-outline-primary w-100 rounded-pill" title="Pratinjau Sertifikat">
                            <i class="fa-solid fa-eye me-1"></i> Pratinjau
                        </a>
                        <a href="#" class="btn btn-sm btn-primary w-100 rounded-pill" title="Unduh PDF">
                            <i class="fa-solid fa-download me-1"></i> Unduh PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Item Sertifikat 3 -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100 overflow-hidden">
                <div class="bg-warning bg-opacity-10 p-4 text-center position-relative">
                    <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3 px-3 py-1 rounded-pill small">Lomba</span>
                    <i class="fa-solid fa-trophy fa-4x text-warning my-3"></i>
                </div>
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <span class="text-muted small" style="font-size: 0.75rem;"><i class="fa-regular fa-calendar me-1"></i> 17 Agustus 2025</span>
                        <h5 class="fw-bold text-dark mt-1 mb-2" style="font-size: 1rem;">Juara 2 Lomba Pidato Bahasa Arab Antar Pesantren</h5>
                        <p class="text-muted small mb-3" style="text-transform: none !important;">Penghargaan prestasi lomba tingkat antar pesantren dalam rangka peringatan HUT RI.</p>
                    </div>
                    <div class="d-flex gap-2 pt-2 border-top">
                        <a href="#" class="btn btn-sm btn-outline-warning text-dark w-100 rounded-pill" title="Pratinjau Sertifikat">
                            <i class="fa-solid fa-eye me-1"></i> Pratinjau
                        </a>
                        <a href="#" class="btn btn-sm btn-warning text-dark w-100 rounded-pill" title="Unduh PDF">
                            <i class="fa-solid fa-download me-1"></i> Unduh PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Footer / Pagination -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mt-4 py-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <span class="text-muted small">Menampilkan 1 hingga 3 dari total 4 e-sertifikat tersimpan</span>
        <nav>
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled"><span class="page-link rounded-start-3">Sebelumnya</span></li>
                <li class="page-item active"><span class="page-link bg-success border-success">1</span></li>
                <li class="page-item"><a class="page-link text-success rounded-end-3" href="#">Berikutnya</a></li>
            </ul>
        </nav>
    </div>

</div>

<?= $this->endSection() ?>