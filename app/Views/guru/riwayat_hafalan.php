<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$santri = $santri ?? [];
?>

<div class="container-fluid px-0">

    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1" style="text-transform: none !important;">Riwayat Setoran Hafalan Santri</h3>
            <p class="text-muted mb-0 small" style="text-transform: none !important;">Pantau rekam jejak hafalan Al-Qur'an (ziyadah dan murojaah) santri binaan kelas Anda.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm" style="text-transform: none !important;">
                <i class="fa-solid fa-file-excel text-success me-1"></i> Ekspor Rekap
            </button>
            <a href="<?= base_url('ustadz/hafalan/tambah') ?>" class="btn btn-success btn-sm px-3 rounded-pill shadow-sm" style="text-transform: none !important;">
                <i class="fa-solid fa-plus me-1"></i> Input Setoran Baru
            </a>
        </div>
    </div>

    <!-- Ringkasan Statistik Hafalan -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-15 p-3 rounded-3 text-success">
                        <i class="fa-solid fa-book-quran fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">TOTAL SETORAN BULAN INI</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">142 <span class="fs-6 fw-normal text-muted">Sesi</span></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-15 p-3 rounded-3 text-primary">
                        <i class="fa-solid fa-award fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">RATA-RATA PREDIKAT</span>
                        <h3 class="fw-bold text-primary mb-0 mt-1">Mumtaz <span class="fs-6 fw-normal text-success">(Sangat Baik)</span></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-15 p-3 rounded-3 text-warning">
                        <i class="fa-solid fa-user-check fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">SANTRI AKTIF SETORAN</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">28 / 30 <span class="fs-6 fw-normal text-muted">Santri</span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-body p-3">
            <div class="row g-3 align-items-center">
                <div class="col-lg-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-0 ps-3 text-muted">
                            <i class="fa-solid fa-search"></i>
                        </span>
                        <input type="text" class="form-control bg-light border-0 py-2" placeholder="Cari nama santri atau surah...">
                    </div>
                </div>
                <div class="col-lg-3">
                    <select class="form-select form-select-sm bg-light border-0 py-2">
                        <option selected>Jenis: Semua Jenis</option>
                        <option value="ziyadah">Ziyadah (Baru)</option>
                        <option value="murojaah">Murojaah (Ulang)</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    <select class="form-select form-select-sm bg-light border-0 py-2">
                        <option selected>Predikat: Semua</option>
                        <option value="mumtaz">Mumtaz</option>
                        <option value="jayyid">Jayyid</option>
                        <option value="maqbul">Maqbul</option>
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
                            <th class="py-3" style="width: 25%;">NIS</th>
                            <th class="py-3" style="width: 20%;">Kelas</th>
                            <th class="py-3 text-end pe-4" style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($santri) && is_array($santri)): ?>
                            <?php $no = 1;
                            foreach ($santri as $s): ?>
                                <tr>
                                    <td class="ps-4 fw-medium text-muted"><?= $no++; ?></td>
                                    <td>
                                        <div class="fw-semibold text-dark"><?= esc($s['nama_santri']); ?></div>
                                    </td>
                                    <td><span class="text-muted"><?= esc($s['nis']); ?></span></td>
                                    <td><span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-1"><?= esc($s['nama_kelas'] ?? 'Belum Ada Kelas'); ?></span></td>
                                    <td class="text-end pe-4">
                                        <a href="<?= base_url('guru/detail-riwayat-hafalan/' . $s['id']); ?>" class="btn btn-sm btn-success rounded-3 px-3">
                                            <i class="fa-solid fa-eye me-1"></i> Lihat Riwayat
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted small">Belum ada data santri.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>