<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1" style="text-transform: none !important;">Data Santri Binaan</h3>
            <p class="text-muted mb-0 small" style="text-transform: none !important;">Daftar santri yang berada di bawah perwalian atau kelas yang Anda ajar.</p>
        </div>
        <!-- Opsional: Tombol Tambah jika Ustadz diberi akses input data -->
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm" style="text-transform: none !important;">
                <i class="fa-solid fa-print text-success me-1"></i> Cetak Daftar Kelas
            </button>
        </div>
    </div>

    <!-- Filter & Search Toolbar Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-body p-3">
            <div class="row g-3 align-items-center">
                <div class="col-lg-9">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-0 ps-3 text-muted">
                            <i class="fa-solid fa-search"></i>
                        </span>
                        <input type="text" class="form-control bg-light border-0 py-2" placeholder="Cari nama santri...">
                    </div>
                </div>
                <div class="col-lg-3">
                    <select class="form-select form-select-sm bg-light border-0 py-2">
                        <option selected>Filter: Semua Kelas</option>
                        <option value="8a">Kelas 8A (Wali Kelas)</option>
                        <option value="8b">Kelas 8B</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="py-3 ps-4" style="width: 5%;">No</th>
                            <th class="py-3" style="width: 30%;">Nama Santri</th>
                            <th class="py-3" style="width: 15%;">NIS</th>
                            <th class="py-3" style="width: 15%;">Kelas</th>
                            <th class="py-3 text-center" style="width: 15%;">Status</th>
                            <th class="py-3 text-end pe-4" style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Contoh Baris Data 1 (Santri Aktif) -->
                        <tr>
                            <td class="ps-4 fw-medium text-muted">1</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.9rem;">
                                        AZ
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold text-dark" style="font-size: 0.9rem;">Ahmad Zaki Al-Faruq</h6>
                                        <small class="text-muted">Putra Bpk. Abdullah</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="font-monospace text-secondary small">202401001</span></td>
                            <td><span class="badge bg-light text-dark border px-2 py-1">Kelas 8A</span></td>
                            <td class="text-center">
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill small fw-semibold">Aktif</span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="<?= base_url('ustadz/santri/detail/1') ?>" class="btn btn-sm btn-light text-primary border-0 rounded-2" title="Lihat Detail Akademik">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('ustadz/hafalan/santri/1') ?>" class="btn btn-sm btn-light text-success border-0 rounded-2" title="Lihat Hafalan">
                                        <i class="fa-solid fa-book-quran"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <!-- Contoh Baris Data 2 (Santri Izin/Sakit) -->
                        <tr>
                            <td class="ps-4 fw-medium text-muted">2</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.9rem;">
                                        FN
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold text-dark" style="font-size: 0.9rem;">Fatimah Nurul Aini</h6>
                                        <small class="text-muted">Putri Bpk. Mahmud</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="font-monospace text-secondary small">202401002</span></td>
                            <td><span class="badge bg-light text-dark border px-2 py-1">Kelas 8A</span></td>
                            <td class="text-center">
                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-1 rounded-pill small fw-semibold">Izin</span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="<?= base_url('ustadz/santri/detail/2') ?>" class="btn btn-sm btn-light text-primary border-0 rounded-2" title="Lihat Detail Akademik">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('ustadz/hafalan/santri/2') ?>" class="btn btn-sm btn-light text-success border-0 rounded-2" title="Lihat Hafalan">
                                        <i class="fa-solid fa-book-quran"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Card Footer / Pagination -->
        <div class="card-footer bg-white border-0 py-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <span class="text-muted small">Menampilkan 1 hingga 2 dari total 28 santri binaan</span>
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled"><span class="page-link rounded-start-3">Sebelumnya</span></li>
                    <li class="page-item active"><span class="page-link bg-success border-success">1</span></li>
                    <li class="page-item"><a class="page-link text-success rounded-end-3" href="#">Berikutnya</a></li>
                </ul>
            </nav>
        </div>
    </div>

</div>

<?= $this->endSection() ?>