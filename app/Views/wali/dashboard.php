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

<style>
    .custom-dashed-link {
        display: inline-block;
        border-bottom: 1.5px dashed #adb5bd;
        padding-bottom: 1px;
        line-height: 1.2;
        transition: all 0.2s ease-in-out;
    }

    .custom-dashed-link:hover {
        border-bottom-color: #198754;
        color: #198754 !important;
    }
</style>

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
                    <h2 class="fw-bold text-dark-mode mb-2" style="text-transform: none !important;">Ahlan wa Sahlan, <?= session()->get('name') ?>!</h2>
                    <p class="text-secondary mb-3 small" style="text-transform: none !important;">
                        Pantau perkembangan hafalan Al-Qur'an dan informasi pembayaran sekolah ananda
                        <strong>
                            <?php if (!empty($anak)): ?>
                                <?php
                                $namaAnak = array_column($anak, 'nama_santri');
                                echo implode(' dan ', $namaAnak);
                                ?>
                            <?php else: ?>
                                (Belum ada data anak terhubung)
                            <?php endif; ?>
                        </strong> melalui sistem dashboard monitoring di sini.
                    </p>

                    <!-- Status Chip / Indikator Jumlah Anak Terhubung -->
                    <div class="d-flex flex-wrap align-items-center gap-3 pt-1">
                        <div class="d-inline-flex align-items-center gap-2 bg-light px-3 py-2 rounded-pill border">
                            <div class="text-warning d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-users-rectangle"></i>
                            </div>
                            <span class="text-dark fw-semibold small"><?= esc((string)$stat_jumlah_anak); ?> Santri Aktif Terhubung</span>
                        </div>

                        <!-- <div class="d-flex gap-2">
                            <a href="<?= base_url('wali/administrasi') ?>" class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm" style="text-transform: none !important;">
                                <i class="fa-solid fa-wallet text-success me-1"></i> Cek Tagihan SPP
                            </a>
                        </div> -->
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
                <h5 class="fw-bold text-dark-mode mb-0" style="margin-left: 20px !important;"><i class="fa-solid fa-layer-group text-success me-2"></i> Rekapitulasi Hafalan Ananda</h5>
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
                                            <div class="mb-1">
                                                <a href="<?= base_url('wali/santri-detail/' . $a['id']); ?>" title="Lihat Profil" class="fw-bold text-dark-mode text-decoration-none custom-dashed-link fs-5">
                                                    <?= esc($a['nama_santri']); ?>
                                                </a>
                                            </div>
                                            <div class="d-flex flex-wrap gap-2 align-items-center mt-1">
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
                                                    <span class="fw-bold text-dark-mode text-truncate d-block" style="font-size: 0.7rem;"><?= esc($a['stat_juz'] ?? 'Belum ada data'); ?></span>
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
                                                    <span class="fw-bold text-dark-mode d-block" style="font-size: 0.7rem;"><?= esc($a['stat_total_setoran'] ?? 0); ?> <span class="fw-normal text-secondary" style="font-size: 0.75rem;">Kali</span></span>
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
                        <h5 class="fw-bold text-dark-mode">Belum Ada Anak Terhubung</h5>
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
                        <h5 class="fw-bold text-dark-mode m-0" style="text-transform: none !important; font-size: 1rem;">
                            <i class="fa-solid fa-book-open-reader text-success me-2"></i> Setoran Hafalan Terbaru Ananda
                        </h5>
                        <a href="<?= base_url('wali/riwayat-hafalan') ?>" class="text-success small fw-semibold text-decoration-none" style="font-size: 0.7rem;">
                            Riwayat Lengkap <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                    <p class="text-secondary small mb-3" style="text-transform: none !important; font-size: 0.8rem;">Catatan setoran terakhir yang diuji oleh ustadz pengampu di pesantren.</p>

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
                                                <div class="fw-semibold text-dark-mode small">
                                                    <?= date('d M Y', strtotime($row['tanggal'] ?? 'now')); ?>
                                                </div>
                                                <small class="text-secondary" style="font-size: 0.75rem;">
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
                                                <div class="fw-semibold text-dark-mode small">
                                                    <?= esc($row['nama_santri']); ?>
                                                </div>
                                                <span class="badge bg-success bg-opacity-10 text-success px-2 py-0 rounded-pill" style="font-size: 0.65rem;">
                                                    NIS: <?= esc($row['nis'] ?? '-'); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="small text-dark-mode d-block fw-semibold"><?= esc($row['surah'] ?? $row['capaian'] ?? '-'); ?></span>
                                                <small class="text-secondary" style="font-size: 0.75rem;">
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

        <!-- Ringkasan Tagihan Pembayaran -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark-mode mb-0" style="text-transform: none !important; font-size: 1rem;">
                            <i class="fa-solid fa-file-invoice-dollar text-warning me-2"></i> Tagihan & Pembayaran
                        </h5>
                        <a href="<?= base_url('wali/pembayaran'); ?>" class="small text-warning text-decoration-none fw-semibold" style="font-size: 0.7rem;">
                            Lihat Semua <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                    <p class="text-secondary small mb-4" style="text-transform: none !important; font-size: 0.8rem;">Status tagihan dan riwayat administrasi anak.</p>

                    <?php if (!empty($tagihan_terbaru)): ?>
                        <?php foreach ($tagihan_terbaru as $row): ?>
                            <?php
                            // Menyiapkan variabel status dan warna badge untuk modal
                            $status = $row['status']; // contoh: 'Pending', 'Lunas', 'Menunggu Verifikasi'
                            $badgeColor = match (strtolower($status)) {
                                'lunas' => 'success',
                                'pending', 'menunggu verifikasi', 'tertunda' => 'warning',
                                default => 'danger'
                            };
                            ?>
                            <div class="card p-3 bg-light rounded-4 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="badge bg-<?= $badgeColor; ?> bg-opacity-10 text-<?= $badgeColor; ?> px-2 py-1" style="font-size: 0.7rem;"><?= esc($status); ?></span>
                                    <small class="text-secondary" style="font-size: 0.75rem;"><?= date('d M Y', strtotime($row['tanggal'])); ?></small>
                                </div>
                                <h6 class="fw-semibold text-dark-mode mb-1" style="font-size: 0.9rem;"><?= esc($row['jenis_pembayaran']); ?> - <span class="text-primary"><?= esc($row['nama_santri']); ?></span></h6>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="font-monospace fw-bold text-dark-mode" style="font-size: 0.85rem;">Rp <?= number_format($row['jumlah'], 0, ',', '.'); ?></span>

                                    <!-- Tombol untuk memicu modal berdasarkan ID tagihan -->
                                    <button type="button" class="btn btn-sm btn-primary py-0 px-2" style="font-size: 0.75rem;" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $row['id']; ?>">
                                        <?= (strtolower($status) == 'pending') ? 'Konfirmasi' : 'Lihat Rincian'; ?>
                                    </button>
                                </div>
                            </div>

                            <!-- Modal Detail / Form Konfirmasi untuk Setiap Baris -->
                            <div class="modal fade" id="modalDetail<?= $row['id']; ?>" tabindex="-1" aria-labelledby="modalDetailLabel<?= $row['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                                        <!-- Modal Header -->
                                        <div class="modal-header bg-light px-4 py-3 border-bottom">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="rounded-circle bg-<?= $badgeColor; ?> bg-opacity-10 text-<?= $badgeColor; ?> d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                                                    <i class="fa-solid <?= (strtolower($status) == 'pending') ? 'fa-wallet' : 'fa-file-invoice-dollar'; ?>"></i>
                                                </div>
                                                <div>
                                                    <h6 class="modal-title fw-bold text-dark mb-0" id="modalDetailLabel<?= $row['id']; ?>">
                                                        <?= (strtolower($status) == 'pending') ? 'Konfirmasi Pembayaran' : 'Rincian Tagihan & Bukti Transfer'; ?>
                                                    </h6>
                                                    <small class="text-muted font-monospace" style="font-size: 0.75rem;">TRX-<?= date('Ym', strtotime($row['tanggal'])); ?>-0<?= $row['id']; ?></small>
                                                </div>
                                            </div>
                                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body p-4 text-start">

                                            <!-- Ringkasan Info Utama -->
                                            <div class="p-3 bg-light rounded-4 mb-4 border border-1 border-light-subtle">
                                                <div class="row g-2 small">
                                                    <div class="col-6">
                                                        <span class="text-muted d-block" style="font-size: 0.75rem;">Nama Santri</span>
                                                        <span class="fw-semibold text-dark"><?= esc($row['nama_santri'] ?? '-'); ?></span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span class="text-muted d-block" style="font-size: 0.75rem;">Kelas</span>
                                                        <span class="fw-semibold text-dark"><?= esc($row['nama_kelas'] ?? '-'); ?></span>
                                                    </div>
                                                    <div class="col-6 mt-2">
                                                        <span class="text-muted d-block" style="font-size: 0.75rem;">Jenis Pembayaran</span>
                                                        <span class="fw-semibold text-dark"><?= esc($row['jenis_pembayaran']); ?></span>
                                                    </div>
                                                    <div class="col-6 mt-2">
                                                        <span class="text-muted d-block" style="font-size: 0.75rem;">Status</span>
                                                        <span class="badge bg-<?= $badgeColor; ?> bg-opacity-10 text-<?= $badgeColor; ?> px-2 py-1 rounded-pill mt-1" style="font-size: 0.7rem;">
                                                            <?= esc($status); ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <hr class="text-muted opacity-25 my-2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="text-muted small">Total Tagihan:</span>
                                                    <span class="fs-5 fw-bold font-monospace text-primary">Rp <?= number_format($row['jumlah'], 0, ',', '.'); ?></span>
                                                </div>
                                            </div>

                                            <!-- KONDISI 1: JIKA STATUS PENDNG (Tampilkan Info Rekening & Form Upload) -->
                                            <?php if (strtolower($status) == 'pending'): ?>
                                                <div class="mb-4">
                                                    <div class="small fw-bold text-dark mb-2"><i class="fa-solid fa-wallet text-primary me-1"></i> Silakan Transfer ke Rekening Resmi:</div>
                                                    <div class="row g-2">
                                                        <div class="col-12">
                                                            <div class="p-3 border rounded-3 bg-white d-flex align-items-center justify-content-between">
                                                                <div>
                                                                    <span class="badge bg-success bg-opacity-10 text-success px-2 py-0.5 rounded-2 fw-semibold mb-1" style="font-size: 0.65rem;">BSI</span>
                                                                    <div class="font-monospace fw-bold text-dark fs-6">7123 4567 89</div>
                                                                    <div class="text-muted" style="font-size: 0.7rem;">a.n. Yayasan Hudfal</div>
                                                                </div>
                                                                <button type="button" class="btn btn-light btn-sm rounded-2 text-muted px-2 py-1" onclick="navigator.clipboard.writeText('7123456789'); alert('No Rekening BSI disalin!');">
                                                                    <i class="fa-regular fa-copy"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="p-3 border rounded-3 bg-white d-flex align-items-center justify-content-between">
                                                                <div>
                                                                    <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-0.5 rounded-2 fw-semibold mb-1" style="font-size: 0.65rem;">BCA</span>
                                                                    <div class="font-monospace fw-bold text-dark fs-6">1234 5678 90</div>
                                                                    <div class="text-muted" style="font-size: 0.7rem;">a.n. Yayasan Hudfal</div>
                                                                </div>
                                                                <button type="button" class="btn btn-light btn-sm rounded-2 text-muted px-2 py-1" onclick="navigator.clipboard.writeText('1234567890'); alert('No Rekening BCA disalin!');">
                                                                    <i class="fa-regular fa-copy"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <form action="<?= base_url('wali/riwayat-tagihan/konfirmasi/' . $row['id']); ?>" method="POST" enctype="multipart/form-data">
                                                    <?= csrf_field(); ?>
                                                    <div class="fw-semibold text-dark small mb-3">
                                                        <i class="fa-solid fa-cloud-arrow-up text-primary me-1"></i> Form Konfirmasi Pembayaran:
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label small fw-medium text-muted">Tanggal & Waktu Transfer</label>
                                                        <input type="datetime-local" name="tanggal_konfirmasi" class="form-control bg-light form-control-sm" required value="<?= date('Y-m-d\TH:i'); ?>">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label small fw-medium text-muted">Ditransfer ke Rekening Mana?</label>
                                                        <select name="bank_tujuan" class="form-select bg-light form-select-sm" required>
                                                            <option value="">-- Pilih Rekening Tujuan --</option>
                                                            <option value="BSI - 7123456789 (Yayasan Hudfal)">BSI - 7123456789 (Yayasan Hudfal)</option>
                                                            <option value="BCA - 1234567890 (Yayasan Hudfal)">BCA - 1234567890 (Yayasan Hudfal)</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-4">
                                                        <label class="form-label small fw-medium text-muted">Upload Bukti Transfer</label>
                                                        <input type="file" name="bukti_pembayaran" class="form-control bg-light form-control-sm" accept="image/*,application/pdf" required>
                                                        <div class="form-text text-muted" style="font-size: 0.7rem;">Format: JPG, PNG, atau PDF. Maks 2MB.</div>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold shadow-sm">
                                                        <i class="fa-solid fa-paper-plane me-1"></i> Kirim Konfirmasi Pembayaran
                                                    </button>
                                                </form>

                                                <!-- KONDISI 2: JIKA SUDAH DIKIRIM (Menunggu Verifikasi / Lunas) -> Tampilkan Bukti & Detail Konfirmasi -->
                                            <?php else: ?>
                                                <div class="small mb-3">
                                                    <div class="d-flex justify-content-between py-2 border-bottom">
                                                        <span class="text-muted">Tanggal Konfirmasi</span>
                                                        <span class="fw-semibold text-dark"><?= !empty($row['tanggal_konfirmasi']) ? date('d M Y, H:i', strtotime($row['tanggal_konfirmasi'])) . ' WIB' : '-'; ?></span>
                                                    </div>
                                                    <div class="d-flex justify-content-between py-2 border-bottom">
                                                        <span class="text-muted">Tujuan Transfer</span>
                                                        <span class="fw-semibold text-dark"><?= esc($row['bank_tujuan'] ?? '-'); ?></span>
                                                    </div>
                                                    <div class="d-flex justify-content-between py-2 border-bottom">
                                                        <span class="text-muted">Catatan Admin</span>
                                                        <span class="fw-semibold text-dark text-end"><?= esc($row['keterangan'] ?? '-'); ?></span>
                                                    </div>
                                                </div>

                                                <!-- Bagian Tempat Menampilkan Bukti Pembayaran yang Telah Diupload -->
                                                <?php if (!empty($row['bukti_pembayaran'])): ?>
                                                    <div class="mt-3">
                                                        <span class="text-muted small d-block mb-2 fw-semibold">Bukti Transfer yang Dikirim:</span>
                                                        <?php
                                                        $ext = pathinfo($row['bukti_pembayaran'], PATHINFO_EXTENSION);
                                                        $fileUrl = base_url('uploads/bukti/' . $row['bukti_pembayaran']);
                                                        ?>
                                                        <?php if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])): ?>
                                                            <div class="border rounded-3 p-2 bg-light text-center">
                                                                <img src="<?= $fileUrl; ?>" alt="Bukti Pembayaran" class="img-fluid rounded shadow-sm mb-2" style="max-height: 250px; object-fit: contain;">
                                                                <div>
                                                                    <a href="<?= $fileUrl; ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                                        <i class="fa-solid fa-magnifying-glass-plus me-1"></i> Perbesar Gambar
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        <?php else: ?>
                                                            <a href="<?= $fileUrl; ?>" target="_blank" class="btn btn-outline-secondary btn-sm w-100 rounded-pill py-2">
                                                                <i class="fa-solid fa-file-pdf me-1 text-danger"></i> Lihat Dokumen PDF Bukti Transfer
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="alert alert-warning small text-center mb-0">Belum ada file bukti pembayaran yang diunggah.</div>
                                                <?php endif; ?>

                                            <?php endif; ?>

                                        </div>

                                        <div class="modal-footer bg-light border-top-0 px-4 py-3">
                                            <button type="button" class="btn btn-light rounded-pill px-4 text-muted btn-sm border" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Tampilan Jika Belum Ada Tagihan -->
                        <div class="text-center py-4 text-muted">
                            <i class="fa-solid fa-circle-check text-success fa-2x mb-2"></i>
                            <p class="small mb-0">Belum ada data tagihan atau pembayaran saat ini.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>