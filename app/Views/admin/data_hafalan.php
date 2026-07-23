<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1" style="text-transform: none !important;">Monitoring Data Hafalan</h3>
            <p class="text-muted mb-0 small" style="text-transform: none !important;">Pantau perkembangan setoran hafalan Al-Qur'an, juz, surah, serta predikat nilai santri.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm" style="text-transform: none !important;">
                <i class="fa-solid fa-file-excel text-success me-1"></i> Rekap Laporan
            </button>
            <a href="<?= base_url('admin/hafalan/tambah') ?>" class="btn btn-success btn-sm px-3 rounded-pill shadow-sm" style="text-transform: none !important;">
                <i class="fa-solid fa-plus me-1"></i> Input Setoran Baru
            </a>
        </div>
    </div>

    <!-- Filter & Search Toolbar Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-body p-3">
            <div class="row g-3 align-items-center">
                <div class="col-lg-5">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-0 ps-3 text-muted">
                            <i class="fa-solid fa-search"></i>
                        </span>
                        <input type="text" class="form-control bg-light border-0 py-2" placeholder="Cari nama santri atau ustadz penguji...">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <select class="form-select form-select-sm bg-light border-0 py-2">
                        <option selected>Semua Juz</option>
                        <option value="juz-30">Juz 30 (Amma)</option>
                        <option value="juz-29">Juz 29</option>
                        <option value="juz-1">Juz 1</option>
                    </select>
                </div>
                <div class="col-lg-4 col-md-6">
                    <select class="form-select form-select-sm bg-light border-0 py-2">
                        <option selected>Predikat: Semua Nilai</option>
                        <option value="mumtaz">Mumtaz (Sangat Baik)</option>
                        <option value="jayyid">Jayyid (Baik)</option> maqbul
                        <option value="maqbul">Maqbul (Cukup)</option>
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
                            <th class="py-3" style="width: 25%;">Nama Santri</th>
                            <th class="py-3" style="width: 20%;">Capaian Hafalan</th>
                            <th class="py-3" style="width: 20%;">Ustadz Penguji</th>
                            <th class="py-3 text-center" style="width: 15%;">Predikat</th>
                            <th class="py-3 text-end pe-4" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Contoh Baris Data 1 -->
                        <tr>
                            <td class="ps-4 fw-medium text-muted">1</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.9rem;">
                                        AZ
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold text-dark" style="font-size: 0.9rem;">Ahmad Zaki Al-Faruq</h6>
                                        <small class="text-muted"><i class="fa-regular fa-calendar me-1"></i> 23 Juli 2026</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark d-block">Juz 30</span>
                                <small class="text-muted">Surah An-Nazi'at (Ayat 1-46)</small>
                            </td>
                            <td><span class="text-secondary small fw-medium">Ustadz Ahmad Hidayat, Lc.</span></td>
                            <td class="text-center">
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill small fw-semibold">Mumtaz</span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="#" class="btn btn-sm btn-light text-primary border-0 rounded-2" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-light text-warning border-0 rounded-2" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-light text-danger border-0 rounded-2" title="Hapus" onclick="return confirm('Yakin ingin menghapus data hafalan ini?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <!-- Contoh Baris Data 2 -->
                        <tr>
                            <td class="ps-4 fw-medium text-muted">2</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.9rem;">
                                        FN
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold text-dark" style="font-size: 0.9rem;">Fatimah Nurul Aini</h6>
                                        <small class="text-muted"><i class="fa-regular fa-calendar me-1"></i> 22 Juli 2026</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark d-block">Juz 1</span>
                                <small class="text-muted">Surah Al-Baqarah (Ayat 1-25)</small>
                            </td>
                            <td><span class="text-secondary small fw-medium">Ustadz M. Ridwan, M.Pd.</span></td>
                            <td class="text-center">
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill small fw-semibold">Jayyid</span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="#" class="btn btn-sm btn-light text-primary border-0 rounded-2" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-light text-warning border-0 rounded-2" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-light text-danger border-0 rounded-2" title="Hapus" onclick="return confirm('Yakin ingin menghapus data hafalan ini?')">
                                        <i class="fa-solid fa-trash"></i>
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
            <span class="text-muted small">Menampilkan 1 hingga 2 dari total 520 data setoran bulan ini</span>
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled"><span class="page-link rounded-start-3">Sebelumnya</span></li>
                    <li class="page-item active"><span class="page-link bg-success border-success">1</span></li>
                    <li class="page-item"><a class="page-link text-success" href="#">2</a></li>
                    <li class="page-item"><a class="page-link text-success rounded-end-3" href="#">Berikutnya</a></li>
                </ul>
            </nav>
        </div>
    </div>

</div>

<?= $this->endSection() ?>