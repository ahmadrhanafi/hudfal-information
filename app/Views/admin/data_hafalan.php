<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
/** @var \CodeIgniter\Pager\Pager $pager */
$hafalan = $hafalan ?? [];
?>

<div class="container-fluid px-0">

    <!-- Flash Message Floating -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080; max-width: 400px;">
        <!-- Alert Success -->
        <?php if (session()->getFlashdata('success')): ?>
            <div id="flash-alert-success"
                class="alert alert-success fade show rounded-4 shadow-lg border-0 d-flex align-items-center p-3 mb-2 position-relative"
                role="alert">
                <div class="d-flex align-items-center flex-grow-1 pe-4">
                    <div class="text-success fs-5 me-3 flex-shrink-0">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <span class="fw-bold d-block text-success mb-0">Berhasil!</span>
                        <span class="text-secondary small" style="font-size: 12px;">
                            <?= session()->getFlashdata('success'); ?>
                        </span>
                    </div>
                </div>
                <button type="button" class="btn-close position-absolute top-0 end-0 mt-3 me-3 shadow-none"
                    style="font-size: 10px; width: 20px; height: 20px;" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Alert Error -->
        <?php if (session()->getFlashdata('error')): ?>
            <div id="flash-alert-error"
                class="alert alert-danger fade show rounded-4 shadow-lg border-0 d-flex align-items-center p-3 mb-2 position-relative"
                role="alert">
                <div class="d-flex align-items-center flex-grow-1 pe-4">
                    <div class="text-danger fs-5 me-3 flex-shrink-0">
                        <i class="fa fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <span class="fw-bold d-block text-danger mb-0">Gagal!</span>
                        <span class="text-secondary small" style="font-size: 12px;">
                            <?= session()->getFlashdata('error'); ?>
                        </span>
                    </div>
                </div>
                <button type="button" class="btn-close position-absolute top-0 end-0 mt-2 me-2 shadow-none"
                    style="font-size: 8px; width: 16px; height: 16px;" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark-mode mb-1" style="text-transform: none !important;">Manajemen Data Hafalan</h3>
            <p class="text-secondary mb-0 small" style="text-transform: none !important;">Pantau perkembangan setoran
                hafalan Al-Qur'an, juz, surah, serta predikat nilai santri.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm"
                style="text-transform: none !important;">
                <i class="fa-solid fa-file-excel text-success me-1"></i> Rekap Laporan
            </button>

            <button type="button" class="btn btn-success btn-sm px-3 rounded-pill shadow-sm" data-bs-toggle="modal"
                data-bs-target="#modalInputHafalan" style="text-transform: none !important;">
                <i class="fa-solid fa-plus me-1"></i> Input Setoran Baru
            </button>
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
                        <!-- Tambahkan id="searchInput" -->
                        <input type="text" id="searchInput" class="form-control bg-light border-0 py-2"
                            placeholder="Cari nama santri atau ustadz penguji...">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <!-- Tambahkan id="juzFilter" -->
                    <select id="juzFilter" class="form-select form-select-sm bg-light border-0 py-2">
                        <option value="semua" selected>Semua Juz</option>
                        <?php for ($i = 1; $i <= 30; $i++): ?>
                            <option value="<?= $i; ?>">Juz <?= $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-lg-4 col-md-6">
                    <!-- Tambahkan id="predikatFilter" -->
                    <select id="predikatFilter" class="form-select form-select-sm bg-light border-0 py-2">
                        <option value="semua" selected>Predikat: Semua Nilai</option>
                        <option value="mumtaz">Mumtaz (Sempurna)</option>
                        <option value="jayyid jiddan">Jayyid Jiddan (Sangat Baik)</option>
                        <option value="jayyid">Jayyid (Baik)</option>
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
                    <thead class="bg-light text-muted small text-uppercase"
                        style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="py-3 ps-4" style="width: 5%;">No</th>
                            <th class="py-3" style="width: 25%;">Nama Santri</th>
                            <th class="py-3" style="width: 20%;">Capaian Hafalan</th>
                            <th class="py-3" style="width: 20%;">Ustadz Penguji</th>
                            <th class="py-3 text-center" style="width: 15%;">Predikat</th>
                            <th class="py-3 text-end pe-4" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBodyHafalan">
                        <?php if (!empty($hafalan) && is_array($hafalan)): ?>
                            <?php
                            // Hitung nomor urut kontinu jika menggunakan pager, default ke 1 jika tidak ada
                            $currentPage = isset($pager) ? ($pager->getCurrentPage('hafalan') ?? 1) : 1;
                            $perPage = isset($pager) ? ($pager->getPerPage('hafalan') ?? 10) : 10;
                            $no = ($currentPage - 1) * $perPage + 1;

                            foreach ($hafalan as $h):
                                ?>
                                <?php
                                // Generate Inisial Avatar
                                $words = explode(' ', $h['nama_santri']);
                                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));

                                // Format warna badge predikat
                                $badgeColor = 'success';
                                $predikatLower = strtolower($h['predikat']);
                                if ($predikatLower == 'jayyid')
                                    $badgeColor = 'primary';
                                if ($predikatLower == 'jayyid jiddan')
                                    $badgeColor = 'info';
                                if ($predikatLower == 'maqbul')
                                    $badgeColor = 'warning';
                                ?>
                                <!-- Baris data dengan atribut data-* untuk keperluan filter JS -->
                                <tr class="hafalan-row" data-juz="<?= $h['juz']; ?>"
                                    data-predikat="<?= strtolower($h['predikat']); ?>">
                                    <td class="ps-4 fw-medium text-muted"><?= $no++; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                                style="width: 38px; height: 38px; font-size: 0.9rem;">
                                                <?= $initials; ?>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold text-dark-mode" style="font-size: 0.9rem;">
                                                    <?= esc($h['nama_santri']); ?>
                                                </h6>
                                                <small class="text-secondary" style="font-size: 12px;"><i
                                                        class="fa-regular fa-calendar me-1"></i>
                                                    <?= date('d M Y', strtotime($h['created_at'])); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark-mode d-block">Juz <?= esc($h['juz']); ?> <span
                                                class="badge bg-dark bg-opacity-50 text-dark-mode border ms-1"><?= ucfirst($h['jenis']); ?></span></span>
                                        <small class="text-secondary" style="font-size: 12px;">Surah <?= esc($h['surah']); ?>
                                            (Ayat <?= $h['ayat_mulai']; ?>-<?= $h['ayat_selesai']; ?>)</small>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark-mode d-block"><?= esc($h['nama_guru']); ?></span>
                                        <small class="text-secondary" style="font-size: 12px;"><i
                                                class="fa-solid fa-chalkboard-user me-1"></i> Pengampu
                                            <?= esc($h['nama_kelas']); ?></small>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge bg-<?= $badgeColor; ?> bg-opacity-10 text-<?= $badgeColor; ?> px-3 py-1 rounded-pill small fw-semibold">
                                            <?= esc($h['predikat']); ?>
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-1">
                                            <!-- Tombol Detail (Memicu Modal Detail) -->
                                            <button type="button"
                                                class="btn btn-sm btn-light text-primary border-0 rounded-2 btn-detail"
                                                title="Detail" data-bs-toggle="modal" data-bs-target="#modalDetail"
                                                data-nama="<?= esc($h['nama_santri']); ?>" data-jenis="<?= esc($h['jenis']); ?>"
                                                data-juz="<?= esc($h['juz']); ?>" data-surah="<?= esc($h['surah']); ?>"
                                                data-ayatmulai="<?= esc($h['ayat_mulai']); ?>"
                                                data-ayatselesai="<?= esc($h['ayat_selesai']); ?>"
                                                data-predikat="<?= esc($h['predikat']); ?>"
                                                data-keterangan="<?= esc($h['keterangan'] ?? '-'); ?>"
                                                data-tanggal="<?= date('d M Y, H:i', strtotime($h['created_at'] ?? 'now')); ?>">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>

                                            <button type="button"
                                                class="btn btn-sm btn-light text-warning border-0 rounded-2 btn-edit"
                                                title="Edit" data-bs-toggle="modal" data-bs-target="#modalEdit"
                                                data-id="<?= $h['id']; ?>" data-idsantri="<?= $h['id_santri']; ?>"
                                                data-idguru="<?= $h['id_guru']; ?>" data-jenis="<?= esc($h['jenis']); ?>"
                                                data-juz="<?= esc($h['juz']); ?>" data-surah="<?= esc($h['surah']); ?>"
                                                data-ayatmulai="<?= esc($h['ayat_mulai']); ?>"
                                                data-ayatselesai="<?= esc($h['ayat_selesai']); ?>"
                                                data-predikat="<?= esc($h['predikat']); ?>"
                                                data-keterangan="<?= esc($h['keterangan']); ?>">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                            <a href="<?= base_url('admin/hafalan/delete/' . $h['id']); ?>"
                                                class="btn btn-sm btn-light text-danger border-0 rounded-2" title="Hapus"
                                                onclick="return confirm('Yakin ingin menghapus data hafalan ini?')">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <!-- Baris Kosong Jika Data Tidak Ditemukan -->
                        <tr id="emptyRowHafalan" class="d-none">
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fa-solid fa-folder-open me-1"></i> Tidak ada data setoran hafalan yang
                                ditemukan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Card Footer / Pagination -->
        <div
            class="card card-footer bg-white border-0 py-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <span class="text-secondary small">
                <?php
                $currentPage = $pager->getCurrentPage('hafalan');
                $perPage = $pager->getPerPage('hafalan');
                $total = $pager->getTotal('hafalan');

                $start = $total > 0 ? (($currentPage - 1) * $perPage) + 1 : 0;
                $end = min($currentPage * $perPage, $total);
                ?>
                Menampilkan <?= $start; ?> hingga <?= $end; ?> dari total <?= $total; ?> data hafalan
            </span>

            <!-- Panggil Template Pager Kustom -->
            <?php if (!empty($pager)): ?>
                <?= $pager->links('hafalan', 'hafalan_pagination'); ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Input Setoran Baru -->
<div class="modal fade" id="modalInputHafalan" tabindex="-1" aria-labelledby="modalInputHafalanLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fs-6 fw-semibold" id="modalInputHafalanLabel">
                    <i class="fa-solid fa-plus-circle me-1"></i> Input Setoran Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Route action disesuaikan ke fungsi store hafalan -->
            <form action="<?= base_url('admin/hafalan/store') ?>" method="POST">
                <?= csrf_field(); ?>
                <div class="modal-body p-4">

                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Guru Pengampu / Penilai</label>
                        <select name="id_guru" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Guru --</option>
                            <?php if (!empty($guru)): ?>
                                <?php foreach ($guru as $g): ?>
                                    <option value="<?= $g['id']; ?>"><?= esc($g['nama_guru']); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Pilihan Santri Binaan -->
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Pilih Santri</label>
                        <select name="id_santri" class="form-select select2-santri"
                            data-dropdown-parent="#modalInputHafalan" required>
                            <option value="" disabled selected>-- Pilih Santri --</option>
                            <?php if (!empty($santri)): ?>
                                <?php foreach ($santri as $s): ?>
                                    <option value="<?= $s['id']; ?>"><?= esc($s['nama_santri']); ?> (NIS:
                                        <?= esc($s['nis']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="row">
                        <!-- Jenis Setoran (Ziyadah / Murojaah) -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium small text-muted">Jenis Setoran</label>
                            <select name="jenis" class="form-select" required>
                                <option value="ziyadah">Ziyadah (Hafalan Baru)</option>
                                <option value="murojaah">Murojaah (Ulang Hafalan)</option>
                            </select>
                        </div>

                        <!-- Juz -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium small text-muted">Juz</label>
                            <select name="juz" id="pilih_juz" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Juz --</option>
                                <?php for ($i = 1; $i <= 30; $i++): ?>
                                    <option value="<?= $i; ?>">Juz <?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Surah -->
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Nama Surah</label>
                        <select name="surah" id="pilih_surah" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Juz Terlebih Dahulu --</option>
                        </select>
                    </div>

                    <div class="row">
                        <!-- Ayat Mulai -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium small text-muted">Dari Ayat</label>
                            <input type="number" name="ayat_mulai" id="ayat_mulai" class="form-control"
                                placeholder="Contoh: 1" min="1" required>
                        </div>

                        <!-- Ayat Selesai -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium small text-muted">Sampai Ayat</label>
                            <input type="number" name="ayat_selesai" id="ayat_selesai" class="form-control"
                                placeholder="Contoh: 10" min="1" required>
                        </div>
                    </div>

                    <!-- Predikat / Nilai -->
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Predikat Penilaian</label>
                        <select name="predikat" class="form-select" required>
                            <option value="Mumtaz">Mumtaz (Sangat Baik)</option>
                            <option value="Jayyid Jiddan">Jayyid Jiddan (Baik Sekali)</option>
                            <option value="Jayyid">Jayyid (Baik)</option>
                            <option value="Maqbul">Maqbul (Cukup)</option>
                        </select>
                    </div>

                    <!-- Keterangan Tambahan (Opsional) -->
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Keterangan (Opsional)</label>
                        <textarea name="keterangan" class="form-control" rows="2"
                            placeholder="Catatan tambahan untuk santri..."></textarea>
                    </div>

                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-secondary btn-sm px-3 rounded-pill"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-sm px-3 rounded-pill">Simpan Setoran</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DETAIL HAFALAN -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark" id="modalDetailLabel">Detail Setoran Hafalan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <table class="table table-borderless align-middle mb-0 small">
                    <tr>
                        <td class="text-muted" style="width: 35%;">Nama Santri</td>
                        <td class="fw-semibold text-dark" id="det-nama">: -</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Waktu Setor</td>
                        <td class="text-dark" id="det-tanggal">: -</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Jenis Setoran</td>
                        <td class="text-dark" id="det-jenis">: -</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Capaian</td>
                        <td class="fw-semibold text-dark" id="det-capaian">: -</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Predikat</td>
                        <td>: <span id="det-predikat"
                                class="badge bg-success bg-opacity-10 text-success px-2 py-1">-</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Keterangan</td>
                        <td class="text-dark" id="det-keterangan">: -</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary btn-sm rounded-pill px-4"
                    data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT HAFALAN -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <!-- Form mengarah ke method update di controller -->
            <form action="" id="formEditHafalan" method="POST">
                <?= csrf_field(); ?>
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-dark" id="modalEditLabel">Edit Setoran Hafalan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <input type="hidden" name="id_guru" id="edit-id-guru">
                <div class="modal-body py-3">
                    <!-- Pilih Santri -->
                    <div class="mb-3">
                        <label class="form-label small fw-medium text-muted">Santri</label>
                        <select name="id_santri" id="edit-id-santri" class="form-select form-select-sm" required>
                            <option value="" disabled>-- Pilih Santri --</option>
                            <?php if (!empty($santri)): ?>
                                <?php foreach ($santri as $s): ?>
                                    <option value="<?= $s['id']; ?>"><?= esc($s['nama_santri']); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Jenis Setoran -->
                    <div class="mb-3">
                        <label class="form-label small fw-medium text-muted">Jenis Setoran</label>
                        <select name="jenis" id="edit-jenis" class="form-select form-select-sm" required>
                            <option value="ZIYADAH">ZIYADAH (Hafalan Baru)</option>
                            <option value="MUROJAAH">Murojaah (Ulang Hafalan)</option>
                        </select>
                    </div>

                    <!-- Juz & Surah (Diubah menjadi select agar dinamis via AJAX) -->
                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-medium text-muted">Juz</label>
                            <select name="juz" id="edit-pilih_juz" class="form-select form-select-sm" required>
                                <option value="" disabled selected>-- Pilih --</option>
                                <?php for ($i = 1; $i <= 30; $i++): ?>
                                    <option value="<?= $i; ?>">Juz <?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-medium text-muted">Surah</label>
                            <select name="surah" id="edit-pilih_surah" class="form-select form-select-sm" required>
                                <option value="" disabled selected>-- Pilih Surah --</option>
                            </select>
                        </div>
                    </div>

                    <!-- Ayat Mulai & Selesai -->
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-medium text-muted">Ayat Mulai</label>
                            <input type="number" name="ayat_mulai" id="edit-ayat-mulai"
                                class="form-control form-control-sm" required min="1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium text-muted">Ayat Selesai</label>
                            <input type="number" name="ayat_selesai" id="edit-ayat-selesai"
                                class="form-control form-control-sm" required min="1">
                        </div>
                    </div>

                    <!-- Predikat -->
                    <div class="mb-3">
                        <label class="form-label small fw-medium text-muted">Predikat</label>
                        <select name="predikat" id="edit-predikat" class="form-select form-select-sm" required>
                            <option value="Mumtaz">Mumtaz (Sangat Baik)</option>
                            <option value="Jayyid">Jayyid (Baik)</option>
                            <option value="Maqbul">Maqbul (Cukup)</option>
                        </select>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label class="form-label small fw-medium text-muted">Keterangan (Opsional)</label>
                        <textarea name="keterangan" id="edit-keterangan" class="form-control form-control-sm"
                            rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light btn-sm rounded-pill px-3 text-muted"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-sm rounded-pill px-4 shadow-sm">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
        padding-left: 2.35rem !important;
    }

    .select2-search-icon-wrapper {
        position: relative;
    }

    .select2-search-icon-wrapper::before {
        font-family: "Font Awesome 6 Free";
        content: "\f002";
        font-weight: 900;
        position: absolute;
        left: 25px;
        top: 50%;
        transform: translateY(-50%);
        color: #adb5bd;
        z-index: 10;
        font-size: 0.85rem;
    }
</style>

<script>
    // Inisialisasi Select2
    $(document).ready(function () {
        $('.select2-santri').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#modalInputHafalan'),
            width: '100%',
            placeholder: '-- Pilih Santri --',
            allowClear: true
        });

        $('.select2-santri').on('select2:open', function () {
            let searchField = document.querySelector('.select2-container--bootstrap-5 .select2-search__field');
            if (searchField) {
                searchField.placeholder = "Cari nama santri atau NIS...";

                let parent = searchField.parentNode;
                if (!parent.classList.contains('select2-search-icon-wrapper')) {
                    parent.classList.add('select2-search-icon-wrapper');
                }
            }
        });
    });

    // Script AJAX Dinamis buat Modal Tambah/Input Juz, Surah, dan Ayat
    document.addEventListener('DOMContentLoaded', function () {
        const selectJuz = document.getElementById('pilih_juz');
        const selectSurah = document.getElementById('pilih_surah');
        const inputAyatMulai = document.getElementById('ayat_mulai');
        const inputAyatSelesai = document.getElementById('ayat_selesai');

        // Ketika Juz dipilih
        selectJuz.addEventListener('change', function () {
            const juzId = this.value;

            selectSurah.innerHTML = '<option value="" disabled selected>Memuat data surah...</option>';
            inputAyatMulai.value = '';
            inputAyatSelesai.value = '';

            fetch(`<?= base_url('admin/hafalan/getSurahByJuz'); ?>/${juzId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Server merespon dengan status: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    selectSurah.innerHTML = '<option value="" disabled selected>-- Pilih Surah --</option>';

                    if (!Array.isArray(data) || data.length === 0) {
                        selectSurah.innerHTML = '<option value="" disabled selected>Tidak ada surah ditemukan</option>';
                        return;
                    }

                    data.forEach(surah => {
                        let opt = document.createElement('option');
                        opt.value = surah.nama_surah;
                        opt.textContent = surah.nama_surah;
                        opt.dataset.maxAyat = surah.jumlah_ayat;
                        opt.dataset.defaultMulai = surah.ayat_mulai_default;
                        opt.dataset.defaultSelesai = surah.ayat_selesai_default;
                        selectSurah.appendChild(opt);
                    });
                })
                .catch(error => {
                    console.error('Detail Error:', error);
                    selectSurah.innerHTML = '<option value="" disabled selected>Gagal memuat surah (Cek Console)</option>';
                });
        });

        // Ketika Surah dipilih, atur otomatis nilai ayat mulai & selesai
        selectSurah.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];

            const defaultMulai = selectedOption.dataset.defaultMulai;
            const defaultSelesai = selectedOption.dataset.defaultSelesai;
            const maxAyat = selectedOption.dataset.maxAyat; // Batas maksimal ayat surah tersebut

            if (defaultMulai) {
                inputAyatMulai.value = defaultMulai;
            }
            if (defaultSelesai) {
                inputAyatSelesai.value = defaultSelesai;
            }

            // Terapkan batas maksimal pada input HTML secara dinamis
            if (maxAyat) {
                inputAyatMulai.max = maxAyat;
                inputAyatSelesai.max = maxAyat;
            }
        });

        // Tambahan pencegahan jika pengguna mengetik angka melebihi batas maksimal secara manual
        inputAyatSelesai.addEventListener('input', function () {
            const selectedOption = selectSurah.options[selectSurah.selectedIndex];
            const maxAyat = parseInt(selectedOption.dataset.maxAyat) || 0;

            if (maxAyat > 0 && parseInt(this.value) > maxAyat) {
                this.value = maxAyat; // Otomatis kembalikan ke angka maksimal jika melebihi
            }
        });

        inputAyatMulai.addEventListener('input', function () {
            const selectedOption = selectSurah.options[selectSurah.selectedIndex];
            const maxAyat = parseInt(selectedOption.dataset.maxAyat) || 0;

            if (maxAyat > 0 && parseInt(this.value) > maxAyat) {
                this.value = maxAyat;
            }
        });
    });

    // Script AJAX Dinamis untuk Modal Edit (Juz, Surah, dan Ayat)
    document.addEventListener("DOMContentLoaded", function () {
        const modalEdit = document.getElementById('modalEdit');
        const editJuz = document.getElementById('edit-pilih_juz');
        const editSurah = document.getElementById('edit-pilih_surah');
        const editAyatMulai = document.getElementById('edit-ayat-mulai');
        const editAyatSelesai = document.getElementById('edit-ayat-selesai');

        // Fungsi helper untuk mengambil data surah berdasarkan juz secara AJAX
        function loadSurahForEdit(juzId, selectedSurahName = '') {
            if (!juzId) return;

            editSurah.innerHTML = '<option value="" disabled selected>Memuat data surah...</option>';

            fetch(`<?= base_url('admin/hafalan/getSurahByJuz'); ?>/${juzId}`)
                .then(response => {
                    if (!response.ok) throw new Error('Gagal memuat surah');
                    return response.json();
                })
                .then(data => {
                    editSurah.innerHTML = '<option value="" disabled selected>-- Pilih Surah --</option>';

                    if (Array.isArray(data)) {
                        data.forEach(surah => {
                            let opt = document.createElement('option');
                            opt.value = surah.nama_surah;
                            opt.textContent = surah.nama_surah;
                            opt.dataset.maxAyat = surah.jumlah_ayat;
                            opt.dataset.defaultMulai = surah.ayat_mulai_default;
                            opt.dataset.defaultSelesai = surah.ayat_selesai_default;

                            // Jika nama surah cocok dengan data lama yang sedang diedit, pilih otomatis
                            if (surah.nama_surah === selectedSurahName) {
                                opt.selected = true;
                            }

                            editSurah.appendChild(opt);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    editSurah.innerHTML = '<option value="" disabled selected>Gagal memuat surah</option>';
                });
        }

        // Ketika dropdown Juz pada modal edit diubah manual oleh pengguna
        editJuz.addEventListener('change', function () {
            loadSurahForEdit(this.value);
        });

        // Ketika dropdown Surah pada modal edit diubah, sesuaikan max ayat
        editSurah.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.dataset.maxAyat) {
                editAyatMulai.max = selectedOption.dataset.maxAyat;
                editAyatSelesai.max = selectedOption.dataset.maxAyat;
            }
        });

        // Validasi input manual agar tidak melebihi maksimal ayat
        editAyatSelesai.addEventListener('input', function () {
            const selectedOption = editSurah.options[editSurah.selectedIndex];
            const maxAyat = parseInt(selectedOption?.dataset?.maxAyat) || 0;
            if (maxAyat > 0 && parseInt(this.value) > maxAyat) {
                this.value = maxAyat;
            }
        });

        editAyatMulai.addEventListener('input', function () {
            const selectedOption = editSurah.options[editSurah.selectedIndex];
            const maxAyat = parseInt(selectedOption?.dataset?.maxAyat) || 0;
            if (maxAyat > 0 && parseInt(this.value) > maxAyat) {
                this.value = maxAyat;
            }
        });

        // Saat Modal Edit dibuka, masukkan data lama dari tombol aksi ke dalam form
        modalEdit.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            const id = button.getAttribute('data-id');
            const idSantri = button.getAttribute('data-idsantri');
            const jenis = button.getAttribute('data-jenis');
            const juz = button.getAttribute('data-juz');
            const surah = button.getAttribute('data-surah');
            const ayatMulai = button.getAttribute('data-ayatmulai');
            const ayatSelesai = button.getAttribute('data-ayatselesai');
            const predikat = button.getAttribute('data-predikat');
            const keterangan = button.getAttribute('data-keterangan');

            // Set URL action pada form
            const form = document.getElementById('formEditHafalan');
            form.action = "<?= base_url('admin/hafalan/update/'); ?>" + id;

            // Masukkan nilai teks/pilihan dasar
            document.getElementById('edit-id-santri').value = idSantri;
            document.getElementById('edit-jenis').value = jenis;
            document.getElementById('edit-juz').value = juz;
            document.getElementById('edit-ayat-mulai').value = ayatMulai;
            document.getElementById('edit-ayat-selesai').value = ayatSelesai;
            document.getElementById('edit-predikat').value = predikat;
            document.getElementById('edit-keterangan').value = (keterangan === 'null' || keterangan === '') ? '' : keterangan;

            // Panggil fungsi load surah secara otomatis berdasarkan juz yang tersimpan di database
            loadSurahForEdit(juz, surah);
        });
    });

    // AJAX (Dependent Dropdown)
    document.addEventListener('DOMContentLoaded', function () {
        const selectGuru = document.querySelector('select[name="id_guru"]');
        const selectSantri = document.querySelector('select[name="id_santri"]');

        if (selectGuru && selectSantri) {
            selectGuru.addEventListener('change', function () {
                const idGuru = this.value;

                selectSantri.innerHTML = '<option value="" disabled selected>Memuat santri...</option>';

                fetch("<?= base_url('admin/hafalan/getSantriByGuru/'); ?>" + idGuru)
                    .then(response => response.json())
                    .then(data => {
                        selectSantri.innerHTML = '<option value="" disabled selected>-- Pilih Santri --</option>';

                        if (data.length > 0) {
                            data.forEach(s => {
                                selectSantri.innerHTML += `<option value="${s.id}">${s.nama_santri} (NIS: ${s.nis})</option>`;
                            });
                        } else {
                            selectSantri.innerHTML += '<option value="" disabled>Tidak ada santri di kelas guru ini</option>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        selectSantri.innerHTML = '<option value="" disabled selected>Gagal memuat santri</option>';
                    });
            });
        }
    });

    // Modal tambah setoran hafalan
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const juzFilter = document.getElementById('juzFilter');
        const predikatFilter = document.getElementById('predikatFilter');
        const rows = document.querySelectorAll('#tableBodyHafalan .hafalan-row');
        const totalDataText = document.getElementById('totalDataTextHafalan');
        const emptyRow = document.getElementById('emptyRowHafalan');

        function filterHafalan() {
            const keyword = searchInput ? searchInput.value.toLowerCase() : '';
            const juzVal = juzFilter ? juzFilter.value.toLowerCase() : 'semua';
            const predikatVal = predikatFilter ? predikatFilter.value.toLowerCase() : 'semua';

            let visibleCount = 0;

            rows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                const rowJuz = row.getAttribute('data-juz');
                const rowPredikat = row.getAttribute('data-predikat');

                const matchesKeyword = rowText.includes(keyword);
                const matchesJuz = (juzVal === 'semua' || rowJuz === juzVal);
                const matchesPredikat = (predikatVal === 'semua' || rowPredikat === predikatVal);

                if (matchesKeyword && matchesJuz && matchesPredikat) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (emptyRow) {
                if (visibleCount === 0) {
                    emptyRow.classList.remove('d-none');
                } else {
                    emptyRow.classList.add('d-none');
                }
            }

            if (totalDataText) {
                totalDataText.textContent = `Menampilkan total ${visibleCount} data setoran hafalan`;
            }
        }

        if (searchInput) searchInput.addEventListener('keyup', filterHafalan);
        if (juzFilter) juzFilter.addEventListener('change', filterHafalan);
        if (predikatFilter) predikatFilter.addEventListener('change', filterHafalan);
    });

    // Modal detail setoran
    document.addEventListener("DOMContentLoaded", function () {
        const modalDetail = document.getElementById('modalDetail');
        modalDetail.addEventListener('show.bs.modal', function (event) {
            // Ambil data dari tombol yang diklik
            const button = event.relatedTarget;

            // Masukkan ke dalam elemen modal
            document.getElementById('det-nama').innerText = ': ' + button.getAttribute('data-nama');
            document.getElementById('det-tanggal').innerText = ': ' + button.getAttribute('data-tanggal');
            document.getElementById('det-jenis').innerText = ': ' + button.getAttribute('data-jenis');
            document.getElementById('det-capaian').innerText = ': Juz ' + button.getAttribute('data-juz') + ' (' + button.getAttribute('data-surah') + ' ayat ' + button.getAttribute('data-ayatmulai') + '-' + button.getAttribute('data-ayatselesai') + ')';
            document.getElementById('det-predikat').innerText = button.getAttribute('data-predikat');
            document.getElementById('det-keterangan').innerText = ': ' + button.getAttribute('data-keterangan');
        });
    });

    // Modal edit setoran
    document.addEventListener("DOMContentLoaded", function () {
        const modalEdit = document.getElementById('modalEdit');
        const editJuz = document.getElementById('edit-pilih_juz');
        const editSurah = document.getElementById('edit-pilih_surah');
        const editAyatMulai = document.getElementById('edit-ayat-mulai');
        const editAyatSelesai = document.getElementById('edit-ayat-selesai');

        // Fungsi helper untuk mengambil data surah berdasarkan juz secara AJAX
        function loadSurahForEdit(juzId, selectedSurahName = '') {
            if (!juzId) return;

            editSurah.innerHTML = '<option value="" disabled selected>Memuat data surah...</option>';

            fetch(`<?= base_url('admin/hafalan/getSurahByJuz'); ?>/${juzId}`)
                .then(response => {
                    if (!response.ok) throw new Error('Gagal memuat surah');
                    return response.json();
                })
                .then(data => {
                    editSurah.innerHTML = '<option value="" disabled selected>-- Pilih Surah --</option>';

                    if (Array.isArray(data)) {
                        data.forEach(surah => {
                            let opt = document.createElement('option');
                            opt.value = surah.nama_surah;
                            opt.textContent = surah.nama_surah;
                            opt.dataset.maxAyat = surah.jumlah_ayat;

                            // Jika nama surah cocok dengan data lama, pilih otomatis
                            if (surah.nama_surah === selectedSurahName) {
                                opt.selected = true;
                            }

                            editSurah.appendChild(opt);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    editSurah.innerHTML = '<option value="" disabled selected>Gagal memuat surah</option>';
                });
        }

        // Ketika dropdown Juz pada modal edit diubah manual
        editJuz.addEventListener('change', function () {
            loadSurahForEdit(this.value);
        });

        // Saat Modal Edit dibuka
        modalEdit.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            // Ambil data dari tombol
            const id = button.getAttribute('data-id');
            const idGuru = button.getAttribute('data-idguru');
            const idSantri = button.getAttribute('data-idsantri');
            const jenis = button.getAttribute('data-jenis');
            const juz = button.getAttribute('data-juz');
            const surah = button.getAttribute('data-surah');
            const ayatMulai = button.getAttribute('data-ayatmulai');
            const ayatSelesai = button.getAttribute('data-ayatselesai');
            const predikat = button.getAttribute('data-predikat');
            const keterangan = button.getAttribute('data-keterangan');

            // Set URL action pada form
            const form = document.getElementById('formEditHafalan');
            form.action = "<?= base_url('admin/hafalan/update/'); ?>" + id;

            // Masukkan data ke dalam input form modal dengan aman
            if (idSantri) document.getElementById('edit-id-santri').value = idSantri;
            if (idGuru) document.getElementById('edit-id-guru').value = idGuru;
            if (jenis) document.getElementById('edit-jenis').value = jenis;
            if (juz) document.getElementById('edit-pilih_juz').value = juz;
            if (ayatMulai) document.getElementById('edit-ayat-mulai').value = ayatMulai;
            if (ayatSelesai) document.getElementById('edit-ayat-selesai').value = ayatSelesai;
            if (predikat) document.getElementById('edit-predikat').value = predikat;
            document.getElementById('edit-keterangan').value = (!keterangan || keterangan === 'null') ? '' : keterangan;

            // Panggil fungsi load surah secara otomatis berdasarkan juz yang tersimpan
            if (juz) {
                loadSurahForEdit(juz, surah);
            }
        });
    });

    // <!-- Script untuk Update Teks Menampilkan Sesuai Filter -->
    document.addEventListener("DOMContentLoaded", function () {
        function updatePaginationText() {
            const rows = document.querySelectorAll("#tableBodyHafalan tr.hafalan-row, #tableBodyHafalan tr:not(#emptyRowHafalan)");

            let totalVisible = 0;
            rows.forEach(row => {
                if (row.style.display !== "none" && !row.id.includes("emptyRow")) {
                    totalVisible++;
                }
            });

            const textInfo = document.getElementById("textInfoPagination");
            if (totalVisible > 0) {
                textInfo.innerText = `Menampilkan total ${totalVisible} riwayat setoran yang sesuai`;
            } else {
                textInfo.innerText = `Tidak ada data riwayat setoran yang cocok`;
            }
        }

        updatePaginationText();

        const observer = new MutationObserver(updatePaginationText);
        const targetNode = document.getElementById("tableBodyHafalan");
        if (targetNode) {
            observer.observe(targetNode, {
                childList: true,
                subtree: true,
                attributes: true,
                attributeFilter: ['style']
            });
        }
    });
</script>

<?= $this->endSection() ?>