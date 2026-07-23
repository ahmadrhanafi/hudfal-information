<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1" style="text-transform: none !important;">Manajemen Administrasi & Keuangan</h3>
            <p class="text-muted mb-0 small" style="text-transform: none !important;">Kelola catatan pembayaran SPP, iuran bulanan, serta administrasi keuangan santri.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm" style="text-transform: none !important;">
                <i class="fa-solid fa-file-excel text-success me-1"></i> Rekap Keuangan
            </button>
            <a href="<?= base_url('admin/administrasi/tambah') ?>" class="btn btn-success btn-sm px-3 rounded-pill shadow-sm" style="text-transform: none !important;">
                <i class="fa-solid fa-plus me-1"></i> Catat Pembayaran Baru
            </a>
        </div>
    </div>

    <!-- Ringkasan Kartu Keuangan -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-15 p-3 rounded-3 text-success">
                        <i class="fa-solid fa-wallet fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">PEMBAYARAN BULAN INI</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">Rp 12.5 Juta</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-15 p-3 rounded-3 text-primary">
                        <i class="fa-solid fa-circle-check fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">SANTRI LUNAS (BULAN INI)</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">132 <span class="fs-6 fw-normal text-muted">Santri</span></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-15 p-3 rounded-3 text-warning">
                        <i class="fa-solid fa-clock-rotate-left fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">BELUM LUNAS / TERTUNDA</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">16 <span class="fs-6 fw-normal text-danger">Santri</span></h3>
                    </div>
                </div>
            </div>
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
                        <input type="text" class="form-control bg-light border-0 py-2" placeholder="Cari nama santri atau nomor transaksi...">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <select class="form-select form-select-sm bg-light border-0 py-2">
                        <option selected>Bulan: Juli 2026</option>
                        <option value="6">Juni 2026</option>
                        <option value="5">Mei 2026</option>
                        <option value="4">April 2026</option>
                    </select>
                </div>
                <div class="col-lg-4 col-md-6">
                    <select class="form-select form-select-sm bg-light border-0 py-2">
                        <option selected>Status: Semua Status Pembayaran</option>
                        <option value="lunas">Lunas</option>
                        <option value="tertunda">Belum Lunas (Tertunda)</option>
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
                            <th class="py-3" style="width: 25%;">Nama Santri & Kelas</th>
                            <th class="py-3" style="width: 20%;">Jenis Pembayaran</th>
                            <th class="py-3" style="width: 15%;">Nominal</th>
                            <th class="py-3 text-center" style="width: 15%;">Status</th>
                            <th class="py-3 text-end pe-4" style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Contoh Baris Data 1 -->
                        <tr>
                            <td class="ps-4 fw-medium text-muted">1</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.9rem;">
                                        AZ
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold text-dark" style="font-size: 0.9rem;">Ahmad Zaki Al-Faruq</h6>
                                        <small class="text-muted">Kelas 8 Tsanawiyah</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark d-block">SPP Bulanan</span>
                                <small class="text-muted"><i class="fa-regular fa-calendar me-1"></i> Periode Juli 2026</small>
                            </td>
                            <td><span class="font-monospace fw-semibold text-dark">Rp 350.000</span></td>
                            <td class="text-center">
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill small fw-semibold">Lunas</span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="#" class="btn btn-sm btn-light text-success border-0 rounded-2" title="Cetak Kwitansi">
                                        <i class="fa-solid fa-print"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-light text-primary border-0 rounded-2" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-light text-warning border-0 rounded-2" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-light text-danger border-0 rounded-2" title="Hapus" onclick="return confirm('Yakin ingin menghapus data administrasi ini?')">
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
                                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.9rem;">
                                        FN
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold text-dark" style="font-size: 0.9rem;">Fatimah Nurul Aini</h6>
                                        <small class="text-muted">Kelas 10 Aliyah</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark d-block">Iuran Gedung / Masuk</span>
                                <small class="text-muted"><i class="fa-regular fa-calendar me-1"></i> Angsuran ke-2</small>
                            </td>
                            <td><span class="font-monospace fw-semibold text-dark">Rp 750.000</span></td>
                            <td class="text-center">
                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-1 rounded-pill small fw-semibold">Tertunda</span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="#" class="btn btn-sm btn-light text-success border-0 rounded-2" title="Cetak Kwitansi">
                                        <i class="fa-solid fa-print"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-light text-primary border-0 rounded-2" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-light text-warning border-0 rounded-2" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-light text-danger border-0 rounded-2" title="Hapus" onclick="return confirm('Yakin ingin menghapus data administrasi ini?')">
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
            <span class="text-muted small">Menampilkan 1 hingga 2 dari total 148 riwayat transaksi</span>
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled"><span class="page-link rounded-start-3">Sebelumnya</span></li>
                    <li class="page-item active"><span class="page-link bg-success border-success">1</span></li>
                    <li class="page-item"><a class="page-link text-success" href="#">2</a></li>
                    <li class="page-item"><a class="page-link text-success" href="#">3</a></li>
                    <li class="page-item"><a class="page-link text-success rounded-end-3" href="#">Berikutnya</a></li>
                </ul>
            </nav>
        </div>
    </div>

</div>

<?= $this->endSection() ?>