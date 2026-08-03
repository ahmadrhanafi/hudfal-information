<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$guru = $guru ?? [];
/**
 * @var string $total_santri_binaan
 * @var string $total_setoran_hari_ini
 */
?>

<div class="container-fluid px-0">

    <!-- Welcome Banner / Hero Section -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 position-relative overflow-hidden">
        <div class="card-body p-4 p-md-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill mb-2 fw-semibold small">
                        <i class="fa-solid fa-chalkboard-user me-1"></i> Portal Pengajar Pesantren
                    </span>
                    <h2 class="fw-bold text-dark-mode mb-2" style="text-transform: none !important;">Ahlan wa Sahlan, <?= session()->get('name') ?>!</h2>
                    <p class="text-secondary mb-3 small" style="text-transform: none !important;">
                        Ringkasan rekap setoran hafalan santri kelas <?= esc($guru['nama_kelas']) ?>, dan tugas pengarsipan nilai.
                    </p>
                    <!-- <div class="d-flex flex-wrap gap-2">
                        <a href="<?= base_url('ustadz/hafalan/tambah') ?>" class="btn btn-success btn-sm px-3 rounded-pill shadow-sm" style="text-transform: none !important;">
                            <i class="fa-solid fa-plus me-1"></i> Input Setoran Baru
                        </a>
                    </div> -->
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
        <!-- Card 1: Santri Binaan -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-15 p-3 rounded-3 text-success">
                        <i class="fa-solid fa-users fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-secondary small fw-medium" style="text-transform: none !important;">SANTRI BINAAN WALI KELAS</span>
                        <h3 class="fw-bold text-dark-mode mb-0 mt-1"><?= esc($total_santri_binaan ?? 0); ?> <span class="fs-6 fw-normal text-secondary small">Santri</span></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Setoran Hari Ini -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-15 p-3 rounded-3 text-primary">
                        <i class="fa-solid fa-book-quran fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-secondary small fw-medium" style="text-transform: none !important;">SETORAN HARI INI</span>
                        <h3 class="fw-bold text-dark-mode mb-0 mt-1"><?= esc($total_setoran_hari_ini ?? 0); ?> <span class="fs-6 fw-normal text-secondary small">Santri</span></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Status Kepegawaian -->
        <div class="col-xl-4 col-md-12">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-15 p-3 rounded-3 text-warning">
                        <i class="fa-solid fa-user-shield fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-secondary small fw-medium" style="text-transform: none !important;">STATUS KEPEGAWAIAN</span>
                        <h3 class="fw-bold text-dark-mode mb-0 mt-1">
                            <?= !empty($guru['status_aktif']) ? esc($guru['status_aktif']) : 'Aktif'; ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Bawah: Jadwal Mengajar & Setoran Terbaru -->
    <div class="row g-4">
        <!-- Kolom Kiri: Informasi Kelas Binaan & Tugas Pengajar -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="fw-bold text-dark-mode m-0" style="text-transform: none !important;">
                            <i class="fa-solid fa-school-flag text-success me-2"></i> Informasi Kelas
                        </h5>
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill fw-semibold small">
                            <?= date('d M Y'); ?>
                        </span>
                    </div>

                    <p class="text-secondary small mb-4">Informasi kelas dan mandat pengajaran yang diampu saat ini.</p>

                    <?php if (!empty($kelas_binaan)): ?>
                        <div class="d-flex flex-column gap-3">

                            <!-- Detail Kelas Utama -->
                            <div class="p-4 rounded-4 border border-success border-opacity-25 bg-success bg-opacity-10 position-relative overflow-hidden">
                                <div class="position-absolute start-0 top-0 bottom-0 bg-success" style="width: 5px;"></div>

                                <div class="d-flex align-items-center justify-content-between mb-2 ps-2">
                                    <span class="badge bg-success text-white px-2 py-1 rounded-pill small fw-semibold">
                                        <i class="fa-solid fa-chalkboard me-1"></i> Wali Kelas / Pengampu
                                    </span>
                                    <span class="badge bg-white text-success border border-success border-opacity-25 px-2 py-1 small fw-bold">
                                        <span class="spinner-grow spinner-grow-sm text-success me-1" role="status" style="width: 8px; height: 8px;"></span> <?= esc($guru['status_aktif']) ?>
                                    </span>
                                </div>

                                <div class="ps-2 mt-3">
                                    <h4 class="fw-bold text-dark-mode mb-1">Kelas <?= esc($kelas_binaan['nama_kelas']); ?></h4>
                                    <p class="text-secondary small mb-0">
                                        <i class="fa-solid fa-user-tie text-success me-1"></i> Pengampu: <?= esc($guru['nama_guru'] ?? session()->get('name')); ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Kotak Panduan Singkat -->
                            <div class="p-3 rounded-4 bg-light border">
                                <div class="d-flex gap-3 align-items-center">
                                    <div class="text-success fs-4 ps-1">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-dark-mode small mb-1">Catatan Pengawasan</h6>
                                        <p class="text-secondary small mb-0" style="font-size: 0.75rem;">
                                            Pastikan untuk selalu memeriksa dan memvalidasi setoran hafalan santri secara berkala pada panel sebelah kanan.
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php else: ?>
                        <!-- Kondisi Jika Belum Diatur Kelasnya -->
                        <div class="text-center py-5 text-muted border border-dashed rounded-4 p-4">
                            <i class="fa-solid fa-triangle-exclamation fa-2x mb-2 text-warning opacity-75"></i>
                            <h6 class="fw-bold text-dark mb-1">Belum Ada Kelas Binaan</h6>
                            <p class="small mb-0 text-muted">Anda belum terhubung dengan kelas manapun. Silakan hubungi Administrator untuk menetapkan kelas pengampu.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Tabel Aktivitas Setoran Hafalan Terbaru -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-bold text-dark-mode m-0" style="text-transform: none !important;">
                            <i class="fa-solid fa-list-check text-success me-2"></i> Setoran Hafalan Terbaru
                        </h5>
                        <a href="<?= base_url('guru/hafalan') ?>" class="text-success small fw-semibold text-decoration-none">Lihat Semua <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                    <p class="text-secondary small mb-3" style="text-transform: none !important;">Catatan setoran santri yang baru saja diuji hari ini.</p>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                <tr>
                                    <th class="py-2">Tanggal Setoran</th>
                                    <th class="py-2 ps-3">Nama Santri</th>
                                    <th class="py-2">Setor Hafalan</th>
                                    <th class="py-2 text-center">Predikat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($setoran)): ?>
                                    <?php foreach ($setoran as $h): ?>
                                        <?php
                                        $predikat = strtolower($h['predikat']);
                                        $badgeColor = 'success';
                                        if ($predikat == 'jayyid') $badgeColor = 'primary';
                                        elseif ($predikat == 'maqbul') $badgeColor = 'warning';
                                        elseif ($predikat == 'rasib') $badgeColor = 'danger';
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="text-dark-mode small fw-medium">
                                                    <i class="fa-regular fa-calendar-days text-secondary me-1 small"></i>
                                                    <?= date('d M Y', strtotime($h['created_at'])); ?>
                                                </div>
                                                <small class="text-secondary" style="font-size: 0.7rem;">
                                                    <i class="fa-regular fa-clock me-1"></i> <?= date('H:i', strtotime($h['created_at'])); ?> WIB
                                                </small>
                                            </td>
                                            <td class="ps-3">
                                                <div class="fw-semibold text-dark-mode small"><?= esc($h['nama_santri']); ?></div>
                                                <small class="text-secondary" style="font-size: 0.75rem;"><?= esc($h['nama_kelas']); ?></small>
                                            </td>
                                            <td>
                                                <span class="small text-dark-mode d-block">Surah <?= esc($h['surah']); ?></span>
                                                <small class="text-secondary" style="font-size: 0.75rem;">Ayat <?= esc($h['ayat_mulai']); ?>-<?= esc($h['ayat_selesai']); ?></small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-<?= $badgeColor; ?> bg-opacity-10 text-<?= $badgeColor; ?> px-2 py-1 rounded-pill" style="font-size: 0.75rem;">
                                                    <?= esc($h['predikat']); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted small">
                                            Belum ada data setoran hafalan dari santri di kelas Anda.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>