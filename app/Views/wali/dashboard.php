<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
/**
 * @var string $stat_total_juz
 * @var int|string $stat_persen_juz
 * @var int $stat_total_setoran
 * @var int $stat_jumlah_anak
 * @var array $anak
 */
?>

<div class="container-fluid px-0">

    <!-- Welcome Banner & Integrated Summary Section -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 position-relative overflow-hidden">
        <div class="card-body p-4 p-md-5">
            <div class="row align-items-center g-4">
                <!-- Kolom Teks Sapaan -->
                <div class="col-lg-8">
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill mb-2 fw-semibold small">
                        <i class="fa-solid fa-house-chimney-user me-1"></i> Portal Wali Santri
                    </span>
                    <h2 class="fw-bold text-dark mb-2" style="text-transform: none !important;">Ahlan wa Sahlan, <?= session()->get('name') ?>!</h2>
                    <p class="text-secondary mb-3 small" style="text-transform: none !important;">
                        Pantau perkembangan hafalan Al-Qur'an, status kehadiran, serta informasi pembayaran sekolah ananda
                        <strong>
                            <?php if (!empty($anak)): ?>
                                <?php
                                $namaAnak = array_column($anak, 'nama_santri');
                                echo implode(' dan ', $namaAnak);
                                ?>
                            <?php else: ?>
                                (Belum ada data anak terhubung)
                            <?php endif; ?>
                        </strong> di sini.
                    </p>

                    <!-- Status Chip / Indikator Jumlah Anak Terhubung -->
                    <div class="d-flex flex-wrap align-items-center gap-3 pt-1">
                        <div class="d-inline-flex align-items-center gap-2 bg-light px-3 py-2 rounded-pill border">
                            <div class="text-warning d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-users-rectangle"></i>
                            </div>
                            <span class="text-dark fw-semibold small"><?= esc((string)$stat_jumlah_anak); ?> Santri Aktif dalam Pantauan</span>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="<?= base_url('wali/administrasi') ?>" class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm" style="text-transform: none !important;">
                                <i class="fa-solid fa-wallet text-success me-1"></i> Cek Tagihan SPP
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Kolom Ilustrasi / Ikon Banner -->
                <div class="col-lg-4 text-center d-none d-lg-block">
                    <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto text-success shadow-sm" style="width: 110px; height: 110px;">
                        <i class="fa-solid fa-child-reaching fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Daftar Kartu Progres Anak (Professional Horizontal Row-Card) -->
    <div class="row g-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="fw-bold text-dark mb-0" style="margin-left: 20px !important;"><i class="fa-solid fa-layer-group text-success me-2"></i> Rekapitulasi Hafalan Ananda</h5>
            </div>
        </div>

        <?php if (!empty($anak)): ?>
            <?php foreach ($anak as $a): ?>
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden transition-base hover-elevate">
                        <div class="card-body p-4">
                            <div class="row align-items-center g-4">

                                <!-- Kolom 1: Profil & Identitas Santri -->
                                <div class="col-lg-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold fs-4 flex-shrink-0 shadow-sm" style="width: 55px; height: 55px;">
                                            <?= strtoupper(substr($a['nama_santri'], 0, 1)); ?>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold text-dark mb-1"><?= esc($a['nama_santri']); ?></h5>
                                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                                <span class="badge bg-light text-secondary border px-2.5 py-1 rounded-pill" style="font-size: 10px;">
                                                    NIS: <?= esc($a['nis']); ?>
                                                </span>
                                                <span class="badge bg-success bg-opacity-10 text-success border px-2.5 py-1 rounded-pill" style="font-size: 10px;">
                                                    Kelas: <?= esc($a['nama_kelas'] ?? 'Belum ditentukan'); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kolom 2: Metrik Statistik Hafalan (Capaian & Setoran) -->
                                <div class="col-lg-5">
                                    <div class="row g-2">
                                        <!-- Capaian Terakhir -->
                                        <div class="col-sm-6">
                                            <div class="p-2.5 px-3 rounded-3 border-0 h-100 d-flex align-items-center gap-2">
                                                <div class="text-success bg-success bg-opacity-10 p-2 rounded-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                    <i class="fa-solid fa-award"></i>
                                                </div>
                                                <div class="overflow-hidden">
                                                    <span class="text-secondary d-block fw-semibold text-uppercase" style="font-size: 0.6rem;">Capaian Terakhir</span>
                                                    <span class="fw-bold text-dark text-truncate d-block" style="font-size: 0.7rem;"><?= esc($a['stat_juz'] ?? 'Belum ada data'); ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Total Setoran -->
                                        <div class="col-sm-6">
                                            <div class="p-2.5 px-3 rounded-3 border-0 h-100 d-flex align-items-center gap-2">
                                                <div class="text-primary bg-primary bg-opacity-10 p-2 rounded-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                    <i class="fa-solid fa-clipboard-check"></i>
                                                </div>
                                                <div class="overflow-hidden">
                                                    <span class="text-secondary d-block fw-semibold text-uppercase" style="font-size: 0.6rem;">Total Setoran</span>
                                                    <span class="fw-bold text-dark d-block" style="font-size: 0.7rem;"><?= esc($a['stat_total_setoran'] ?? 0); ?> <span class="fw-normal text-secondary" style="font-size: 0.75rem;">Kali</span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kolom 3: Tombol Aksi Detail -->
                                <div class="col-lg-3 text-lg-end">
                                    <a href="<?= base_url('wali/riwayat-hafalan?id_santri=' . $a['id']); ?>" class="btn btn-success btn-sm px-4 py-2 rounded-3 fw-semibold shadow-sm w-100 d-inline-flex align-items-center justify-content-center gap-2">
                                        <span>Detail Hafalan</span>
                                        <i class="fa-solid fa-arrow-right-long"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 bg-white text-center p-5">
                    <div class="card-body">
                        <div class="text-warning mb-3">
                            <i class="fa-solid fa-triangle-exclamation fa-3x"></i>
                        </div>
                        <h5 class="fw-bold text-dark">Belum Ada Anak Terhubung</h5>
                        <p class="text-secondary small mb-0">Belum ada data santri/anak yang dihubungkan dengan akun wali ini. Silakan hubungi admin pesantren.</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bagian Bawah: Setoran Hafalan Terbaru & Informasi Tagihan -->
    <div class="row g-4 mt-2">
        <!-- Setoran Hafalan Terbaru Ananda -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-bold text-dark m-0" style="text-transform: none !important;">
                            <i class="fa-solid fa-book-open-reader text-success me-2"></i> Setoran Hafalan Terbaru Ananda
                        </h5>
                        <a href="<?= base_url('wali/riwayat-hafalan') ?>" class="text-success small fw-semibold text-decoration-none">Riwayat Lengkap <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                    <p class="text-secondary small mb-3" style="text-transform: none !important;">Catatan setoran terakhir yang diuji oleh ustadz pengampu di pesantren.</p>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                <tr>
                                    <th class="py-2 ps-3">Tanggal / Sesi</th>
                                    <th class="py-2">Identitas Santri</th>
                                    <th class="py-2">Capaian Surah</th>
                                    <th class="py-2 text-center">Predikat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($setoran_terbaru)): ?>
                                    <?php foreach ($setoran_terbaru as $row): ?>
                                        <tr>
                                            <td class="ps-3">
                                                <div class="fw-semibold text-dark small">
                                                    <?= date('d M Y', strtotime($row['tanggal'] ?? 'now')); ?>
                                                </div>
                                                <small class="text-muted" style="font-size: 0.75rem;">
                                                    <i class="fa-regular fa-clock me-1"></i>
                                                    <?php
                                                    $waktuInput = $row['jam'] ?? $row['created_at'] ?? $row['waktu'] ?? null;
                                                    if (!empty($waktuInput)) {
                                                        echo date('H:i', strtotime($waktuInput)) . ' WIB';
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="fw-semibold text-dark small">
                                                    <?= esc($row['nama_santri']); ?>
                                                </div>
                                                <span class="badge bg-success bg-opacity-10 text-success px-2 py-0 rounded-pill" style="font-size: 0.65rem;">
                                                    NIS: <?= esc($row['nis'] ?? '-'); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="small text-dark d-block fw-semibold"><?= esc($row['surah'] ?? $row['capaian'] ?? '-'); ?></span>
                                                <small class="text-muted" style="font-size: 0.75rem;">
                                                    <?php
                                                    if (!empty($row['ayat_mulai']) && !empty($row['ayat_selesai'])) {
                                                        echo 'Ayat ' . esc($row['ayat_mulai']) . ' - ' . esc($row['ayat_selesai']);
                                                    } elseif (!empty($row['surah_sampai']) || !empty($row['ayat'])) {
                                                        echo 'Ayat ' . esc($row['ayat'] ?? $row['surah_sampai']);
                                                    } else {
                                                        echo 'Ayat -';
                                                    }
                                                    ?>
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                $predikat = strtolower($row['predikat'] ?? '');
                                                $badgeClass = 'bg-secondary bg-opacity-10 text-secondary';
                                                if ($predikat == 'mumtaz') {
                                                    $badgeClass = 'bg-success bg-opacity-10 text-success';
                                                } elseif ($predikat == 'jayyid jiddan' || $predikat == 'jayyid' || $predikat == 'jayas') {
                                                    $badgeClass = 'bg-primary bg-opacity-10 text-primary';
                                                } elseif ($predikat == 'maqbul') {
                                                    $badgeClass = 'bg-warning bg-opacity-10 text-warning';
                                                }
                                                ?>
                                                <span class="badge <?= $badgeClass; ?> px-2 py-1 rounded-pill" style="font-size: 0.75rem;">
                                                    <?= esc($row['predikat'] ?? 'Dinilai'); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            <i class="fa-solid fa-folder-open fa-2x mb-2 text-warning opacity-75 d-block"></i>
                                            <span class="small">Belum ada catatan setoran hafalan terbaru dari anak asuh Anda.</span>
                                        </td>
                                    </tr>
                                <?php endif; ?>
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
                    <h5 class="fw-bold text-dark-mode mb-3" style="text-transform: none !important;">
                        <i class="fa-solid fa-bullhorn text-success me-2"></i> Pengumuman Pesantren
                    </h5>
                    <p class="text-secondary small mb-4" style="text-transform: none !important;">Informasi penting langsung dari pengurus asrama dan akademik.</p>

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