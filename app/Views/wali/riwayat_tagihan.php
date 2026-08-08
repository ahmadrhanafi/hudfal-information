<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$santri_list = $santri_list ?? [];
/** @var \CodeIgniter\Pager\Pager $pager
 * @var string $nama_kelas
 * @var string $jumlahPending
 **/
?>

<div class="container-fluid px-0">

    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark-mode mb-1" style="text-transform: none !important;">Riwayat Tagihan &
                Pembayaran</h3>
            <p class="text-secondary mb-0 small" style="text-transform: none !important;">Kelola tagihan dan pantau
                status pembayaran administrasi bulanan ananda.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="<?= site_url('wali/riwayat-tagihan/export?id_santri=' . ($santri_aktif['id'] ?? '') . '&status=' . ($selectedStatus ?? '')); ?>"
                class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm text-decoration-none"
                style="text-transform: none !important;">
                <i class="fa-solid fa-download text-success me-1"></i> Export Tagihan
            </a>
            <div class="d-flex align-items-center gap-2">
                <a href="https://wa.me/088276520357"
                    class="btn btn-outline-light btn-sm px-3 rounded-pill bg-success shadow-sm text-decoration-none"
                    style="text-transform: none !important;">
                    <i class="fab fa-whatsapp text-white me-1 fs-6"></i> <span class="text-white"> Chat Admin</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Ringkasan Statistik Keuangan -->
    <div class="row g-4 mb-4">
        <!-- Card 1: Total Pembayaran Lunas -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-25 p-3 rounded-3 text-success">
                        <i class="fa-solid fa-wallet fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-secondary small fw-medium" style="text-transform: none !important;">TOTAL
                            PEMBAYARAN LUNAS</span>
                        <h3 class="fw-bold text-success mb-0 mt-1">Rp
                            <?= number_format($totalLunas ?? 0, 0, ',', '.'); ?>
                        </h3>
                        <span class="text-success" style="font-size: 0.75rem;">Total Terbayar</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Tagihan Aktif / Pending -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-25 p-3 rounded-3 text-warning">
                        <i class="fa-solid fa-file-invoice-dollar fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-secondary small fw-medium" style="text-transform: none !important;">TAGIHAN
                            AKTIF / TERTUNDA</span>
                        <h3 class="fw-bold text-dark-mode mb-0 mt-1">Rp
                            <?= number_format($totalTagihanAktif ?? 0, 0, ',', '.'); ?>
                        </h3>
                        <span class="text-warning" style="font-size: 0.75rem;"><?= $jumlahPending; ?> Tagihan</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Jumlah Anak Terdaftar -->
        <div class="col-xl-4 col-md-12">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-25 p-3 rounded-3 text-primary">
                        <i class="fa-solid fa-users-rectangle fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-secondary small fw-medium" style="text-transform: none !important;">ANAK
                            TERDAFTAR</span>
                        <h3 class="fw-bold text-dark-mode mb-0 mt-1"><?= count($santri_list); ?></h3>
                        <span class="text-primary" style="font-size: 0.75rem;">Santri Terhubung</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-body p-3">
            <form method="get" action="" id="formFilterRiwayat" class="row g-3 align-items-center">

                <?php
                // Cek apakah dropdown anak aktif (jumlah anak > 1)
                $hasMultiAnak = (!empty($santri_list) && count($santri_list) > 1);
                ?>

                <!-- Search Bar (Lebar menyesuaikan kondisi ada/tidaknya dropdown anak) -->
                <div class="col-lg-<?= $hasMultiAnak ? '4' : '6'; ?>">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-0 ps-3 text-muted">
                            <i class="fa-solid fa-search"></i>
                        </span>
                        <input type="text" name="keyword" id="searchRiwayat" value="<?= esc($keyword ?? ''); ?>"
                            class="form-control bg-light border-0 py-1.5"
                            style="padding-top: 0.45rem; padding-bottom: 0.45rem;"
                            placeholder="Cari nomor referensi atau jenis..." autocomplete="off">
                    </div>
                </div>

                <!-- Dropdown Pilih Anak (Hanya muncul jika anak lebih dari 1) -->
                <?php if ($hasMultiAnak): ?>
                    <div class="col-lg-4">
                        <select name="id_santri" class="form-select form-select-sm bg-light border-0"
                            style="padding-top: 0.45rem; padding-bottom: 0.45rem;" onchange="this.form.submit()">
                            <?php foreach ($santri_list as $s): ?>
                                <option value="<?= esc($s['id']); ?>" <?= (isset($_GET['id_santri']) && $_GET['id_santri'] == $s['id']) ? 'selected' : ''; ?>>
                                    Anak: <?= esc($s['nama_santri']); ?> (<?= esc($s['nama_kelas'] ?? '-'); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <!-- Filter Status Pembayaran -->
                <div class="col-lg-<?= $hasMultiAnak ? '4' : '6'; ?>">
                    <select name="status" class="form-select form-select-sm bg-light border-0"
                        style="padding-top: 0.45rem; padding-bottom: 0.45rem;" onchange="this.form.submit()">
                        <option value="">Filter Status: Semua</option>
                        <option value="Lunas" <?= (($selectedStatus ?? '') == 'Lunas') ? 'selected' : ''; ?>>Lunas
                            (Terverifikasi)</option>
                        <option value="Gagal" <?= (($selectedStatus ?? '') == 'Gagal') ? 'selected' : ''; ?>>Gagal /
                            Dibatalkan</option>
                        <option value="Pending" <?= (($selectedStatus ?? '') == 'Pending') ? 'selected' : ''; ?>>Pending
                            (Tertunda)</option>
                        <option value="Menunggu Verifikasi" <?= (($selectedStatus ?? '') == 'Menunggu Verifikasi') ? 'selected' : ''; ?>>Menunggu Verifikasi</option>
                    </select>
                </div>

            </form>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="tabelRiwayatTagihan">
                    <thead class="bg-light text-muted small text-uppercase"
                        style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="py-3 ps-4" style="width: 5%;">No</th>
                            <th class="py-3" style="width: 22%;">Tagihan & Tanggal</th>
                            <th class="py-3" style="width: 20%;">Nama Santri</th>
                            <th class="py-3" style="width: 20%;">Jenis Pembayaran</th>
                            <th class="py-3" style="width: 15%;">Nominal</th>
                            <th class="py-3 text-center" style="width: 13%;">Status</th>
                            <th class="py-3 text-end pe-4" style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tagihan) && is_array($tagihan)): ?>
                            <?php $no = 1;
                            foreach ($tagihan as $row): ?>
                                <tr>
                                    <td class="ps-4 fw-medium text-muted"><?= $no++; ?></td>
                                    <td>
                                        <div class="fw-semibold text-dark-mode small">
                                            THF-<?= date('Ym', strtotime($row['tanggal'])); ?>-0<?= $row['id']; ?></div>
                                        <small class="text-secondary" style="font-size: 0.75rem;"><i
                                                class="fa-regular fa-calendar me-1"></i>
                                            <?= date('d M Y, H:i', strtotime($row['tanggal'])); ?> WIB</small>
                                    </td>
                                    <td>
                                        <span
                                            class="fw-semibold text-dark-mode d-block"><?= esc($row['nama_santri'] ?? '-'); ?></span>
                                        <small class="text-secondary"><?= esc($row['nama_kelas'] ?? '-'); ?></small>
                                    </td>
                                    <td>
                                        <span
                                            class="fw-semibold text-dark-mode d-block"><?= esc($row['jenis_pembayaran']); ?></span>
                                        <small class="text-secondary"><?= esc($row['keterangan'] ?? '-'); ?></small>
                                    </td>
                                    <td>
                                        <span class="font-monospace fw-semibold text-dark-mode">Rp
                                            <?= number_format($row['jumlah'], 0, ',', '.'); ?></span>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        // Perbaikan logika warna badge status biar aman dan fleksibel
                                        $status = trim($row['status'] ?? 'Pending');
                                        $badgeColor = 'secondary';

                                        if ($status == 'Lunas') {
                                            $badgeColor = 'success';
                                        } elseif ($status == 'Menunggu Verifikasi' || $status == 'Pending') {
                                            $badgeColor = 'warning';
                                        } elseif ($status == 'Gagal') {
                                            $badgeColor = 'danger';
                                        }
                                        ?>
                                        <span
                                            class="badge bg-<?= $badgeColor; ?> bg-opacity-10 text-<?= $badgeColor; ?> px-3 py-1 rounded-pill small fw-semibold">
                                            <?= esc($status); ?>
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-1">
                                            <!-- Tombol Pemicu Modal Detail -->
                                            <button type="button" class="btn btn-sm btn-light text-primary border-0 rounded-2"
                                                data-bs-toggle="modal" data-bs-target="#modalDetail<?= $row['id']; ?>"
                                                title="Lihat Detail">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>

                                            <?php if ($status == 'Lunas'): ?>
                                                <a href="<?= base_url('wali/riwayat-tagihan/unduh-kuitansi/' . $row['id']); ?>"
                                                    class="btn btn-sm btn-light text-success border-0 rounded-2"
                                                    title="Unduh Kuitansi" target="_blank">
                                                    <i class="fa-solid fa-file-arrow-down"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Detail / Form Konfirmasi untuk Setiap Baris -->
                                <div class="modal fade" id="modalDetail<?= $row['id']; ?>" tabindex="-1"
                                    aria-labelledby="modalDetailLabel<?= $row['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                                            <!-- Modal Header -->
                                            <div class="modal-header bg-light px-4 py-3 border-bottom">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="rounded-circle bg-<?= $badgeColor; ?> bg-opacity-10 text-<?= $badgeColor; ?> d-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 40px; min-width: 40px;">
                                                        <i
                                                            class="fa-solid <?= ($status == 'Pending') ? 'fa-wallet' : 'fa-file-invoice-dollar'; ?>"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="modal-title fw-bold text-dark mb-0"
                                                            id="modalDetailLabel<?= $row['id']; ?>">
                                                            <?= ($status == 'Pending') ? 'Konfirmasi Pembayaran' : 'Rincian Tagihan & Bukti Transfer'; ?>
                                                        </h6>
                                                        <small class="text-muted font-monospace"
                                                            style="font-size: 0.75rem;">TRX-<?= date('Ym', strtotime($row['tanggal'])); ?>-0<?= $row['id']; ?></small>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body p-4 text-start">

                                                <!-- Ringkasan Info Utama -->
                                                <div class="p-3 bg-light rounded-4 mb-4 border border-1 border-light-subtle">
                                                    <div class="row g-2 small">
                                                        <div class="col-6">
                                                            <span class="text-muted d-block" style="font-size: 0.75rem;">Nama
                                                                Santri</span>
                                                            <span
                                                                class="fw-semibold text-dark"><?= esc($row['nama_santri'] ?? '-'); ?></span>
                                                        </div>
                                                        <div class="col-6">
                                                            <span class="text-muted d-block"
                                                                style="font-size: 0.75rem;">Kelas</span>
                                                            <span
                                                                class="fw-semibold text-dark"><?= esc($row['nama_kelas'] ?? '-'); ?></span>
                                                        </div>
                                                        <div class="col-6 mt-2">
                                                            <span class="text-muted d-block" style="font-size: 0.75rem;">Jenis
                                                                Pembayaran</span>
                                                            <span
                                                                class="fw-semibold text-dark"><?= esc($row['jenis_pembayaran']); ?></span>
                                                        </div>
                                                        <div class="col-6 mt-2">
                                                            <span class="text-muted d-block"
                                                                style="font-size: 0.75rem;">Status</span>
                                                            <span
                                                                class="badge bg-<?= $badgeColor; ?> bg-opacity-10 text-<?= $badgeColor; ?> px-2 py-1 rounded-pill mt-1"
                                                                style="font-size: 0.7rem;">
                                                                <?= esc($status); ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <hr class="text-muted opacity-25 my-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="text-muted small">Total Tagihan:</span>
                                                        <span class="fs-5 fw-bold font-monospace text-primary">Rp
                                                            <?= number_format($row['jumlah'], 0, ',', '.'); ?></span>
                                                    </div>
                                                </div>

                                                <!-- KONDISI 1: JIKA STATUS PENDNG (Tampilkan Info Rekening & Form Upload) -->
                                                <?php if ($status == 'Pending'): ?>
                                                    <div class="mb-4">
                                                        <div class="small fw-bold text-dark mb-2"><i
                                                                class="fa-solid fa-wallet text-primary me-1"></i> Silakan Transfer
                                                            ke Rekening Resmi:</div>
                                                        <div class="row g-2">
                                                            <div class="col-12">
                                                                <div
                                                                    class="p-3 border rounded-3 bg-white d-flex align-items-center justify-content-between">
                                                                    <div>
                                                                        <span
                                                                            class="badge bg-success bg-opacity-10 text-success px-2 py-0.5 rounded-2 fw-semibold mb-1"
                                                                            style="font-size: 0.65rem;">BSI</span>
                                                                        <div class="font-monospace fw-bold text-dark fs-6">7123 4567
                                                                            89</div>
                                                                        <div class="text-muted" style="font-size: 0.7rem;">a.n.
                                                                            Yayasan Hudfal</div>
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-light btn-sm rounded-2 text-muted px-2 py-1"
                                                                        onclick="navigator.clipboard.writeText('7123456789'); alert('No Rekening BSI disalin!');">
                                                                        <i class="fa-regular fa-copy"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div
                                                                    class="p-3 border rounded-3 bg-white d-flex align-items-center justify-content-between">
                                                                    <div>
                                                                        <span
                                                                            class="badge bg-primary bg-opacity-10 text-primary px-2 py-0.5 rounded-2 fw-semibold mb-1"
                                                                            style="font-size: 0.65rem;">BCA</span>
                                                                        <div class="font-monospace fw-bold text-dark fs-6">1234 5678
                                                                            90</div>
                                                                        <div class="text-muted" style="font-size: 0.7rem;">a.n.
                                                                            Yayasan Hudfal</div>
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-light btn-sm rounded-2 text-muted px-2 py-1"
                                                                        onclick="navigator.clipboard.writeText('1234567890'); alert('No Rekening BCA disalin!');">
                                                                        <i class="fa-regular fa-copy"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <form action="<?= base_url('wali/riwayat-tagihan/konfirmasi/' . $row['id']); ?>"
                                                        method="POST" enctype="multipart/form-data">
                                                        <?= csrf_field(); ?>
                                                        <div class="fw-semibold text-dark small mb-3">
                                                            <i class="fa-solid fa-cloud-arrow-up text-primary me-1"></i> Form
                                                            Konfirmasi Pembayaran:
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label small fw-medium text-muted">Tanggal & Waktu
                                                                Transfer</label>
                                                            <input type="datetime-local" name="tanggal_konfirmasi"
                                                                class="form-control bg-light form-control-sm" required
                                                                value="<?= date('Y-m-d\TH:i'); ?>">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label small fw-medium text-muted">Ditransfer ke
                                                                Rekening Mana?</label>
                                                            <select name="bank_tujuan" class="form-select bg-light form-select-sm"
                                                                required>
                                                                <option value="">-- Pilih Rekening Tujuan --</option>
                                                                <option value="BSI - 7123456789 (Yayasan Hudfal)">BSI - 7123456789
                                                                    (Yayasan Hudfal)</option>
                                                                <option value="BCA - 1234567890 (Yayasan Hudfal)">BCA - 1234567890
                                                                    (Yayasan Hudfal)</option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-4">
                                                            <label class="form-label small fw-medium text-muted">Upload Bukti
                                                                Transfer</label>
                                                            <input type="file" name="bukti_pembayaran"
                                                                class="form-control bg-light form-control-sm"
                                                                accept="image/*,application/pdf" required>
                                                            <div class="form-text text-muted" style="font-size: 0.7rem;">Format:
                                                                JPG, PNG, atau PDF. Maks 2MB.</div>
                                                        </div>

                                                        <button type="submit"
                                                            class="btn btn-primary w-100 rounded-pill py-2 fw-semibold shadow-sm">
                                                            <i class="fa-solid fa-paper-plane me-1"></i> Kirim Konfirmasi Pembayaran
                                                        </button>
                                                    </form>

                                                    <!-- KONDISI 2: JIKA SUDAH DIKIRIM (Menunggu Verifikasi / Lunas) -> Tampilkan Bukti & Detail Konfirmasi -->
                                                <?php else: ?>
                                                    <div class="small mb-3">
                                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                                            <span class="text-muted">Tanggal Konfirmasi</span>
                                                            <span
                                                                class="fw-semibold text-dark"><?= !empty($row['tanggal_konfirmasi']) ? date('d M Y, H:i', strtotime($row['tanggal_konfirmasi'])) . ' WIB' : '-'; ?></span>
                                                        </div>
                                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                                            <span class="text-muted">Tujuan Transfer</span>
                                                            <span
                                                                class="fw-semibold text-dark"><?= esc($row['bank_tujuan'] ?? '-'); ?></span>
                                                        </div>
                                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                                            <span class="text-muted">Catatan Admin</span>
                                                            <span
                                                                class="fw-semibold text-dark text-end"><?= esc($row['keterangan'] ?? '-'); ?></span>
                                                        </div>
                                                    </div>

                                                    <!-- Bagian Tempat Menampilkan Bukti Pembayaran yang Telah Diupload -->
                                                    <?php if (!empty($row['bukti_pembayaran'])): ?>
                                                        <div class="mt-3">
                                                            <span class="text-muted small d-block mb-2 fw-semibold">Bukti Transfer yang
                                                                Dikirim:</span>

                                                            <!-- Cek apakah file berupa gambar atau PDF, lalu tampilkan preview-nya -->
                                                            <?php
                                                            $ext = pathinfo($row['bukti_pembayaran'], PATHINFO_EXTENSION);
                                                            $fileUrl = base_url('uploads/bukti/' . $row['bukti_pembayaran']);
                                                            ?>

                                                            <?php if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])): ?>
                                                                <div class="border rounded-3 p-2 bg-light text-center">
                                                                    <img src="<?= $fileUrl; ?>" alt="Bukti Pembayaran"
                                                                        class="img-fluid rounded shadow-sm mb-2"
                                                                        style="max-height: 250px; object-fit: contain;">
                                                                    <div>
                                                                        <a href="<?= $fileUrl; ?>" target="_blank"
                                                                            class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                                            <i class="fa-solid fa-magnifying-glass-plus me-1"></i> Perbesar
                                                                            Gambar
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            <?php else: ?>
                                                                <a href="<?= $fileUrl; ?>" target="_blank"
                                                                    class="btn btn-outline-secondary btn-sm w-100 rounded-pill py-2">
                                                                    <i class="fa-solid fa-file-pdf me-1 text-danger"></i> Lihat Dokumen PDF
                                                                    Bukti Transfer
                                                                </a>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="alert alert-warning small text-center mb-0">Belum ada file bukti
                                                            pembayaran yang diunggah.</div>
                                                    <?php endif; ?>

                                                <?php endif; ?>

                                            </div>

                                            <div class="modal-footer bg-light border-top-0 px-4 py-3">
                                                <button type="button"
                                                    class="btn btn-light rounded-pill px-4 text-muted btn-sm border"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr id="emptyRow">
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada riwayat tagihan atau
                                    pembayaran untuk anak Anda.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Card Footer / Informasi Data -->
        <div
            class="card card-footer bg-white border-0 py-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <p class="text-secondary small">Total riwayat ditemukan <span id="jumlahBaris">:
                    <?= !empty($tagihan) ? count($tagihan) : 0; ?></span> riwayat tagihan</p>
        </div>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById('searchRiwayat');
        const table = document.getElementById('tabelRiwayatTagihan');
        if (!table) return;

        const trs = table.getElementsByTagName('tr');
        const jumlahBarisSpan = document.getElementById('jumlahBaris');

        if (searchInput) {
            searchInput.addEventListener('keyup', function () {
                const filter = searchInput.value.toLowerCase();
                let visibleCount = 0;

                for (let i = 1; i < trs.length; i++) {
                    const tr = trs[i];
                    // Skip jika ini row pesan kosong
                    if (tr.id === 'emptyRow') continue;

                    const textValue = tr.textContent || tr.innerText;
                    if (textValue.toLowerCase().indexOf(filter) > -1) {
                        tr.style.display = "";
                        visibleCount++;
                    } else {
                        tr.style.display = "none";
                    }
                }
                if (jumlahBarisSpan) {
                    jumlahBarisSpan.textContent = visibleCount;
                }
            });
        }
    });
</script>

<?= $this->endSection() ?>