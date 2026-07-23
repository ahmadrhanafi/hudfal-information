<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1" style="text-transform: none !important;">Riwayat Pembayaran & Tagihan</h3>
            <p class="text-muted mb-0 small" style="text-transform: none !important;">Kelola dan pantau status pembayaran SPP, asrama, serta administrasi bulanan ananda.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm" style="text-transform: none !important;">
                <i class="fa-solid fa-download text-success me-1"></i> Unduh Bukti Lunas
            </button>
            <a href="<?= base_url('wali/administrasi/bayar') ?>" class="btn btn-success btn-sm px-3 rounded-pill shadow-sm" style="text-transform: none !important;">
                <i class="fa-solid fa-credit-card me-1"></i> Bayar Tagihan Baru
            </a>
        </div>
    </div>

    <!-- Ringkasan Statistik Keuangan -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-15 p-3 rounded-3 text-success">
                        <i class="fa-solid fa-wallet fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">STATUS SPP BULAN INI</span>
                        <h3 class="fw-bold text-success mb-0 mt-1">Lunas <span class="fs-6 fw-normal text-muted">(Juli 2026)</span></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-15 p-3 rounded-3 text-warning">
                        <i class="fa-solid fa-file-invoice-dollar fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">TAGIHAN AKTIF</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">Rp 0 <span class="fs-6 fw-normal text-success">Tidak Ada Tunggakan</span></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-15 p-3 rounded-3 text-primary">
                        <i class="fa-solid fa-clock-rotate-left fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">TOTAL KASKUS / KANTIN E-KARTU</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">Rp 125.000 <span class="fs-6 fw-normal text-muted">Saldo Sisa</span></h3>
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
                        <input type="text" class="form-control bg-light border-0 py-2" placeholder="Cari berdasarkan nomor referensi atau jenis pembayaran...">
                    </div>
                </div>
                <div class="col-lg-5">
                    <select class="form-select form-select-sm bg-light border-0 py-2">
                        <option selected>Filter Status: Semua Transaksi</option>
                        <option value="lunas">Lunas (Berhasil)</option>
                        <option value="pending">Menunggu Konfirmasi</option>
                        <option value="gagal">Gagal / Dibatalkan</option>
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
                            <th class="py-3" style="width: 25%;">ID Transaksi & Tanggal</th>
                            <th class="py-3" style="width: 25%;">Jenis Pembayaran</th>
                            <th class="py-3" style="width: 20%;">Nominal</th>
                            <th class="py-3 text-center" style="width: 15%;">Status</th>
                            <th class="py-3 text-end pe-4" style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Contoh Baris Data 1 -->
                        <tr>
                            <td class="ps-4 fw-medium text-muted">1</td>
                            <td>
                                <div class="fw-semibold text-dark small">TRX-202607-001</div>
                                <small class="text-muted" style="font-size: 0.75rem;"><i class="fa-regular fa-calendar me-1"></i> 5 Juli 2026, 10:20 WIB</small>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark d-block">SPP Bulanan Pesantren</span>
                                <small class="text-muted">Periode: Juli 2026</small>
                            </td>
                            <td>
                                <span class="font-monospace fw-semibold text-dark">Rp 650.000</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill small fw-semibold">Lunas</span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="#" class="btn btn-sm btn-light text-success border-0 rounded-2" title="Unduh Kuitansi">
                                        <i class="fa-solid fa-file-arrow-down"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <!-- Contoh Baris Data 2 -->
                        <tr>
                            <td class="ps-4 fw-medium text-muted">2</td>
                            <td>
                                <div class="fw-semibold text-dark small">TRX-202606-089</div>
                                <small class="text-muted" style="font-size: 0.75rem;"><i class="fa-regular fa-calendar me-1"></i> 4 Juni 2026, 14:10 WIB</small>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark d-block">SPP Bulanan Pesantren</span>
                                <small class="text-muted">Periode: Juni 2026</small>
                            </td>
                            <td>
                                <span class="font-monospace fw-semibold text-dark">Rp 650.000</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill small fw-semibold">Lunas</span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="#" class="btn btn-sm btn-light text-success border-0 rounded-2" title="Unduh Kuitansi">
                                        <i class="fa-solid fa-file-arrow-down"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <!-- Contoh Baris Data 3 -->
                        <tr>
                            <td class="ps-4 fw-medium text-muted">3</td>
                            <td>
                                <div class="fw-semibold text-dark small">TRX-202601-012</div>
                                <small class="text-muted" style="font-size: 0.75rem;"><i class="fa-regular fa-calendar me-1"></i> 15 Januari 2026, 09:00 WIB</small>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark d-block">Uang Gedung & Fasilitas Awal</span>
                                <small class="text-muted">Tahun Ajaran 2026/2027</small>
                            </td>
                            <td>
                                <span class="font-monospace fw-semibold text-dark">Rp 2.500.000</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill small fw-semibold">Lunas</span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="#" class="btn btn-sm btn-light text-success border-0 rounded-2" title="Unduh Kuitansi">
                                        <i class="fa-solid fa-file-arrow-down"></i>
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
            <span class="text-muted small">Menampilkan 1 hingga 3 dari total 15 riwayat transaksi pembayaran</span>
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