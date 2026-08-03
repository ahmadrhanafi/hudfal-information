<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
/** 
 * @var \CodeIgniter\Pager\Pager $pager 
 * @var int $countLunasBulanIni
 * @var int $countPending
 * @var float|int $totalBulanIni
 * @var array $administrasi
 * @var array $listSantri
 * @var string|null $selectedMonth
 * @var string|null $selectedYear
 * @var string|null $selectedStatus
 * @var string|null $keyword
 **/
?>

<div class="container-fluid px-0">

    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark-mode mb-1" style="text-transform: none !important;">Manajemen Administrasi Keuangan</h3>
            <p class="text-secondary mb-0 small" style="text-transform: none !important;">Kelola catatan tagihan pembayaran serta administrasi keuangan santri.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="<?= site_url('admin/administrasi/export?month=' . ($selectedMonth ?? date('m')) . '&status=' . ($selectedStatus ?? '')); ?>" class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm text-decoration-none" style="text-transform: none !important;">
                <i class="fa-solid fa-file-excel text-success me-1"></i> Rekap Pembayaran
            </a>
            <a href="#" class="btn btn-success btn-sm px-3 rounded-pill shadow-sm" style="text-transform: none !important;" data-bs-toggle="modal" data-bs-target="#tambahModal">
                <i class="fa-solid fa-plus me-1"></i> Catat Pembayaran Baru
            </a>
        </div>
    </div>

    <!-- Ringkasan Kartu Keuangan -->
    <div class="row g-4 mb-4">
        <!-- Kartu 1: Pembayaran Masuk Bulan Ini -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-15 p-3 rounded-3 text-success">
                        <i class="fa-solid fa-wallet fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-secondary small fw-medium" style="text-transform: none !important;">PEMBAYARAN MASUK</span>
                        <h3 class="fw-bold text-dark-mode mb-0 mt-1">Rp <?= number_format($totalBulanIni ?? 0, 0, ',', '.'); ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu 2: Total Transaksi Lunas Bulan Ini -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-15 p-3 rounded-3 text-primary">
                        <i class="fa-solid fa-circle-check fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-secondary small fw-medium" style="text-transform: none !important;">PEMBAYARAN LUNAS</span>
                        <h3 class="fw-bold text-dark-mode mb-0 mt-1"><?= $countLunasBulanIni ?? 0; ?> <span class="fs-6 fw-normal text-secondary">Transaksi</span></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu 3: Belum Lunas / Tertunda -->
        <div class="col-xl-4 col-md-12">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-15 p-3 rounded-3 text-warning">
                        <i class="fa-solid fa-clock-rotate-left fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-secondary small fw-medium" style="text-transform: none !important;">BELUM LUNAS / TERTUNDA</span>
                        <h3 class="fw-bold text-dark-mode mb-0 mt-1"><?= $countPending ?? 0; ?> <span class="fs-6 fw-normal text-danger">Pembayaran Pending</span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-body p-3">
            <form action="" method="get" id="filterForm">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-5">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-0 ps-3 text-muted">
                                <i class="fa-solid fa-search"></i>
                            </span>
                            <input type="text" name="keyword" value="<?= esc($keyword ?? ''); ?>" class="form-control bg-light border-0 py-2" placeholder="Cari nama santri..." onchange="this.form.submit()">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <select name="month" class="form-select form-select-sm bg-light border-0 py-2" onchange="this.form.submit()">
                            <option value="09" <?= ($selectedMonth == '09') ? 'selected' : ''; ?>>September 2026</option>
                            <option value="08" <?= ($selectedMonth == '08') ? 'selected' : ''; ?>>Agustus 2026</option>
                            <option value="07" <?= ($selectedMonth == '07') ? 'selected' : ''; ?>>Juli 2026</option>
                            <option value="06" <?= ($selectedMonth == '06') ? 'selected' : ''; ?>>Juni 2026</option>
                            <option value="05" <?= ($selectedMonth == '05') ? 'selected' : ''; ?>>Mei 2026</option>
                            <option value="04" <?= ($selectedMonth == '04') ? 'selected' : ''; ?>>April 2026</option>
                            <option value="03" <?= ($selectedMonth == '03') ? 'selected' : ''; ?>>Maret 2026</option>
                            <option value="02" <?= ($selectedMonth == '02') ? 'selected' : ''; ?>>Februari 2026</option>
                            <option value="01" <?= ($selectedMonth == '01') ? 'selected' : ''; ?>>Januari 2026</option>
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <select name="status" class="form-select form-select-sm bg-light border-0 py-2" onchange="this.form.submit()">
                            <option value="">Status: Semua Status Pembayaran</option>
                            <option value="Lunas" <?= ($selectedStatus == 'Lunas') ? 'selected' : ''; ?>>Lunas</option>
                            <option value="Pending" <?= ($selectedStatus == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="Gagal" <?= ($selectedStatus == 'Gagal') ? 'selected' : ''; ?>>Gagal</option>
                            <option value="Menunggu Verifikasi" <?= ($selectedStatus == 'Menunggu Verifikasi') ? 'selected' : ''; ?>>Menunggu Verifikasi</option>
                        </select>
                    </div>
                </div>
            </form>
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
                    <tbody id="tableData">
                        <?php if (!empty($administrasi)): ?>
                            <?php
                            // Hitung nomor urut untuk pagination
                            $currentPage = $pager->getCurrentPage('administrasi');
                            $perPage = $pager->getPerPage('administrasi');
                            $no = ($currentPage - 1) * $perPage + 1;
                            ?>
                            <?php foreach ($administrasi as $row): ?>
                                <?php
                                // Buat inisial nama untuk avatar
                                $namaSantri = $row['nama_santri'] ?? 'Santri';
                                $words = explode(' ', $namaSantri);
                                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));

                                // Warna badge & avatar berdasarkan status
                                $statusClass = 'success';
                                if ($row['status'] == 'Pending') {
                                    $statusClass = 'warning';
                                } elseif ($row['status'] == 'Gagal') {
                                    $statusClass = 'danger';
                                }
                                ?>
                                <tr class="searchable-row" data-status="<?= strtolower($row['status']); ?>" data-month="<?= date('F Y', strtotime($row['tanggal'])); ?>">
                                    <td class="ps-4 fw-medium text-muted"><?= $no++; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-<?= $statusClass; ?> bg-opacity-10 text-<?= $statusClass; ?> rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.9rem;">
                                                <?= $initials; ?>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold text-dark-mode" style="font-size: 0.9rem;"><?= esc($row['nama_santri']); ?></h6>
                                                <small class="text-secondary"><?= esc($row['nama_kelas'] ?? 'Belum ada kelas'); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark-mode d-block"><?= esc($row['jenis_pembayaran']); ?></span>
                                        <small class="text-secondary"><i class="fa-regular fa-calendar me-1"></i> <?= date('d M Y, H:i', strtotime($row['tanggal'])); ?></small>
                                    </td>
                                    <td><span class="font-monospace fw-semibold text-dark-mode">Rp <?= number_format($row['jumlah'], 0, ',', '.'); ?></span></td>
                                    <td class="text-center">
                                        <span class="badge bg-<?= $statusClass; ?> bg-opacity-10 text-<?= $statusClass; ?> px-3 py-1 rounded-pill small fw-semibold"><?= esc($row['status']); ?></span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-1">
                                            <?php if ($row['status'] == 'Pending' || $row['status'] == 'Menunggu Verifikasi'): ?>
                                                <a href="<?= base_url('admin/administrasi/verifikasi/' . $row['id']); ?>" class="btn btn-sm btn-light text-success border-0 rounded-2" title="Verifikasi Pembayaran" onclick="return confirm('Setujui dan verifikasi pembayaran ini menjadi Lunas?')">
                                                    <i class="fa-solid fa-circle-check"></i>
                                                </a>
                                            <?php endif; ?>

                                            <a href="#" class="btn btn-sm btn-light text-primary border-0 rounded-2" title="Detail" data-bs-toggle="modal" data-bs-target="#detailModal<?= $row['id']; ?>">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-light text-warning border-0 rounded-2" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id']; ?>">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="<?= base_url('admin/administrasi/delete/' . $row['id']); ?>" class="btn btn-sm btn-light text-danger border-0 rounded-2" title="Hapus" onclick="return confirm('Yakin ingin menghapus data administrasi ini?')">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <!-- =========================================== -->
                                <!---          MODAL DETAIL PEMBAYARAN          --->
                                <!-- =========================================== -->
                                <div class="modal fade" id="detailModal<?= $row['id']; ?>" tabindex="-1" aria-labelledby="detailModalLabel<?= $row['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content border-0 shadow rounded-4">
                                            <div class="modal-header bg-light px-4 py-3">
                                                <h5 class="modal-title fw-bold text-dark" id="detailModalLabel<?= $row['id']; ?>">
                                                    <i class="fa-solid fa-file-invoice text-primary me-2"></i> Detail Transaksi Pembayaran
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block fw-semibold">Nama Santri</small>
                                                        <h6 class="text-dark fw-bold mb-0"><?= esc($row['nama_santri']); ?></h6>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block fw-semibold">Kelas</small>
                                                        <span class="text-dark fw-semibold"><?= esc($row['nama_kelas'] ?? 'Belum ada kelas'); ?></span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block fw-semibold">Jenis Pembayaran</small>
                                                        <span class="text-dark fw-semibold"><?= esc($row['jenis_pembayaran']); ?></span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block fw-semibold">Nominal</small>
                                                        <span class="font-monospace fw-bold text-success">Rp <?= number_format($row['jumlah'], 0, ',', '.'); ?></span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block fw-semibold">Tanggal & Waktu Transaksi</small>
                                                        <span class="text-dark"><?= date('d M Y, H:i', strtotime($row['tanggal'])); ?></span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block fw-semibold">Status Pembayaran</small>
                                                        <?php
                                                        $badgeColor = 'success';
                                                        if ($row['status'] == 'Pending' || $row['status'] == 'Menunggu Verifikasi') {
                                                            $badgeColor = 'warning';
                                                        } elseif ($row['status'] == 'Gagal') {
                                                            $badgeColor = 'danger';
                                                        }
                                                        ?>
                                                        <span class="badge bg-<?= $badgeColor; ?> bg-opacity-10 text-<?= $badgeColor; ?> px-3 py-1 rounded-pill small fw-semibold">
                                                            <?= esc($row['status']); ?>
                                                        </span>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <small class="text-muted d-block fw-semibold">Keterangan</small>
                                                        <p class="text-dark bg-light p-3 rounded-3 mb-0"><?= !empty($row['keterangan']) ? esc($row['keterangan']) : '-'; ?></p>
                                                    </div>

                                                    <?php if (!empty($row['bank_tujuan'])): ?>
                                                        <div class="col-md-6">
                                                            <small class="text-muted d-block fw-semibold">Bank Tujuan</small>
                                                            <span class="text-dark fw-semibold"><?= esc($row['bank_tujuan']); ?></span>
                                                        </div>
                                                    <?php endif; ?>

                                                    <?php if (!empty($row['bukti_pembayaran'])): ?>
                                                        <div class="col-md-12 mt-2">
                                                            <small class="text-muted d-block fw-semibold mb-1">Bukti Pembayaran</small>
                                                            <div class="d-flex align-items-center justify-content-between p-2 px-3 border rounded-3 bg-light">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <i class="fa-solid fa-file-image text-success fs-5"></i>
                                                                    <span class="text-dark small fw-medium"><?= esc($row['bukti_pembayaran']); ?></span>
                                                                </div>
                                                                <div class="d-flex gap-1">
                                                                    <a href="<?= base_url('uploads/bukti/' . $row['bukti_pembayaran']); ?>" target="_blank" class="btn btn-sm btn-light border text-primary px-2 py-1" title="Lihat Gambar">
                                                                        <i class="fa-solid fa-eye"></i>
                                                                    </a>
                                                                    <a href="<?= base_url('uploads/bukti/' . $row['bukti_pembayaran']); ?>" download class="btn btn-sm btn-light border text-secondary px-2 py-1" title="Download">
                                                                        <i class="fa-solid fa-download"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light px-4 py-3">
                                                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- =========================================== -->
                                <!---           MODAL EDIT PEMBAYARAN           --->
                                <!-- =========================================== -->
                                <div class="modal fade" id="editModal<?= $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content border-0 shadow rounded-4">
                                            <div class="modal-header bg-light px-4 py-3">
                                                <h5 class="modal-title fw-bold text-dark" id="editModalLabel<?= $row['id']; ?>"><i class="fa-solid fa-pen-to-square text-warning me-2"></i> Edit Data Pembayaran</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="<?= base_url('admin/administrasi/update/' . $row['id']); ?>" method="post">
                                                <?= csrf_field(); ?>
                                                <div class="modal-body p-4">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-semibold text-muted">Pilih Santri</label>
                                                            <select name="id_santri" class="form-select rounded-3" required>
                                                                <option value="" disabled>-- Pilih Santri --</option>
                                                                <?php if (isset($listSantri)): ?>
                                                                    <?php foreach ($listSantri as $s): ?>
                                                                        <option value="<?= $s['id']; ?>" <?= ($s['id'] == $row['id_santri']) ? 'selected' : ''; ?>>
                                                                            <?= $s['nama_santri']; ?> (<?= $s['nama_kelas'] ?? 'Tanpa Kelas'; ?>)
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-semibold text-muted">Tanggal & Waktu</label>
                                                            <input type="datetime-local" name="tanggal" class="form-control rounded-3" value="<?= date('Y-m-d\TH:i', strtotime($row['tanggal'])); ?>" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-semibold text-muted">Jenis Pembayaran</label>
                                                            <input type="text" name="jenis_pembayaran" class="form-control rounded-3" value="<?= esc($row['jenis_pembayaran']); ?>" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-semibold text-muted">Nominal (Rp)</label>
                                                            <input type="number" name="jumlah" class="form-control rounded-3" value="<?= $row['jumlah']; ?>" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-semibold text-muted">Status Pembayaran</label>
                                                            <select name="status" class="form-select rounded-3" required>
                                                                <option value="Lunas" <?= ($row['status'] == 'Lunas') ? 'selected' : ''; ?>>Lunas</option>
                                                                <option value="Pending" <?= ($row['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                                                <option value="Menunggu Verifikasi" <?= ($row['status'] == 'Menunggu Verifikasi') ? 'selected' : ''; ?>>Menunggu Verifikasi</option>
                                                                <option value="Gagal" <?= ($row['status'] == 'Gagal') ? 'selected' : ''; ?>>Gagal</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-label small fw-semibold text-muted">Keterangan (Opsional)</label>
                                                            <textarea name="keterangan" class="form-control rounded-3" rows="3"><?= esc($row['keterangan']); ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-light px-4 py-3">
                                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-warning rounded-pill px-4 text-white">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada data riwayat transaksi pembayaran.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <!-- Elemen jika data tidak ditemukan -->
                <div id="noDataMessage" class="text-center py-4 text-muted d-none">
                    <i class="fa-solid fa-face-frown fa-2x mb-2"></i>
                    <p class="mb-0">Tidak ada data yang cocok dengan pencarian.</p>
                </div>
            </div>
        </div>
        <!-- Card Footer / Pagination -->
        <div class="card-footer bg-white border-0 py-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <span class="text-muted small">
                <?php
                $currentPage = $pager->getCurrentPage('administrasi');
                $perPage = $pager->getPerPage('administrasi');
                $total = $pager->getTotal('administrasi');

                $start = $total > 0 ? (($currentPage - 1) * $perPage) + 1 : 0;
                $end = min($currentPage * $perPage, $total);
                ?>
                Menampilkan <?= $start; ?> hingga <?= $end; ?> dari total <?= $total; ?> riwayat transaksi
            </span>
            <!-- Panggil Pager Kustom -->
            <?php if (!empty($pager) && $total > $perPage): ?>
                <?= $pager->links('administrasi', 'hafalan_pagination'); ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- =========================================== -->
<!---          MODAL TAMBAH PEMBAYARAN          --->
<!-- =========================================== -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header bg-light px-4 py-3">
                <h5 class="modal-title fw-bold text-dark" id="tambahModalLabel"><i class="fa-solid fa-wallet text-success me-2"></i> Catat Pembayaran Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/administrasi/store'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Pilih Santri</label>
                            <select name="id_santri" class="form-select rounded-3" required>
                                <option value="" disabled selected>-- Pilih Santri --</option>
                                <!-- Nanti data santri di-loop dari database -->
                                <?php if (isset($listSantri)): ?>
                                    <?php foreach ($listSantri as $s): ?>
                                        <option value="<?= $s['id']; ?>"><?= $s['nama_santri']; ?> (<?= $s['nama_kelas'] ?? 'Tanpa Kelas'; ?>)</option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Tanggal & Waktu</label>
                            <input type="datetime-local" name="tanggal" class="form-control rounded-3" value="<?= date('Y-m-d\TH:i'); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Jenis Pembayaran</label>
                            <input type="text" name="jenis_pembayaran" class="form-control rounded-3" placeholder="Contoh: SPP Bulanan, Ujian, Infaq" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Nominal (Rp)</label>
                            <input type="number" name="jumlah" class="form-control rounded-3" placeholder="Contoh: 350000" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Status Pembayaran</label>
                            <select name="status" class="form-select rounded-3" required>
                                <option value="Lunas" selected>Lunas</option>
                                <option value="Pending">Pending</option>
                                <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                                <option value="Gagal">Gagal</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-semibold text-muted">Keterangan (Opsional)</label>
                            <textarea name="keterangan" class="form-control rounded-3" rows="3" placeholder="Catatan tambahan, misal: Periode Juli 2026 atau Angsuran ke-1"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4">Simpan Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("searchInput");
        const filterMonth = document.getElementById("filterMonth");
        const filterStatus = document.getElementById("filterStatus");
        const rows = document.querySelectorAll(".searchable-row");
        const noDataMessage = document.getElementById("noDataMessage");

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const selectedMonth = filterMonth.value.toLowerCase();
            const selectedStatus = filterStatus.value.toLowerCase();

            let visibleCount = 0;

            rows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                const rowStatus = row.getAttribute("data-status") || "";
                const rowMonth = row.getAttribute("data-month") || "";

                // Cek kondisi pencarian teks (nama santri / nomor transaksi, dll)
                const matchesSearch = rowText.includes(searchTerm);

                // Cek kondisi filter bulan
                const matchesMonth = selectedMonth === "" || rowMonth.toLowerCase().includes(selectedMonth);

                // Cek kondisi filter status
                const matchesStatus = selectedStatus === "" || rowStatus.includes(selectedStatus);

                // Jika semua kondisi terpenuhi, tampilkan baris, jika tidak sembunyikan
                if (matchesSearch && matchesMonth && matchesStatus) {
                    row.style.display = "";
                    visibleCount++;
                } else {
                    row.style.display = "none";
                }
            });

            // Tampilkan pesan jika data kosong
            if (visibleCount === 0) {
                noDataMessage.classList.remove("d-none");
            } else {
                noDataMessage.classList.add("d-none");
            }
        }

        // Event listener untuk input pencarian (ketik real-time)
        searchInput.addEventListener("keyup", filterTable);

        // Event listener untuk dropdown filter
        filterMonth.addEventListener("change", filterTable);
        filterStatus.addEventListener("change", filterTable);
    });
</script>

<?= $this->endSection() ?>