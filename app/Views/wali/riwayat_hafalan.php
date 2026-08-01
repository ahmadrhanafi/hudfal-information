<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1" style="text-transform: none !important;">Riwayat Hafalan Ananda</h3>
            <p class="text-muted mb-0 small" style="text-transform: none !important;">Catatan lengkap rekam jejak setoran hafalan Al-Qur'an ananda <strong><?= esc($santri_aktif['nama_santri'] ?? '-'); ?></strong> di pesantren.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm" style="text-transform: none !important;">
                <i class="fa-solid fa-download text-success me-1"></i> Unduh Rekap PDF
            </button>
        </div>
    </div>

    <!-- Ringkasan Statistik Capaian Hafalan -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-15 p-3 rounded-3 text-success">
                        <i class="fa-solid fa-book-quran fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">JUZ AKTIF SAAT INI</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">Juz 30 <span class="fs-6 fw-normal text-success">(Amma)</span></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-15 p-3 rounded-3 text-primary">
                        <i class="fa-solid fa-layer-group fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">TOTAL SETORAN BULAN INI</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">12 <span class="fs-6 fw-normal text-muted">Kali Setor</span></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-15 p-3 rounded-3 text-warning">
                        <i class="fa-solid fa-award fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">PREDIKAT DOMINAN</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">Mumtaz <span class="fs-6 fw-normal text-muted">(Sangat Baik)</span></h3>
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
                        <input type="text" class="form-control bg-light border-0 py-2" placeholder="Cari berdasarkan nama surah atau catatan ustadz...">
                    </div>
                </div>
                <div class="col-lg-5">
                    <select class="form-select form-select-sm bg-light border-0 py-2">
                        <option selected>Filter Periode: Bulan Ini (Juli 2026)</option>
                        <option value="juni">Bulan Juni 2026</option>
                        <option value="mei">Bulan Mei 2026</option>
                        <option value="semua">Semua Riwayat</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Info Anak & Dropdown Pilihan Anak -->
    <?php if (!empty($santri_list) && count($santri_list) > 1): ?>
        <div class="mb-3 d-flex align-items-center gap-2">
            <label class="fw-semibold small text-muted">Pilih Anak:</label>
            <select class="form-select form-select-sm w-auto" onchange="location = this.value;">
                <?php foreach ($santri_list as $s): ?>
                    <option value="<?= base_url('wali/riwayat-hafalan?id_santri=' . $s['id']); ?>" <?= (isset($santri_aktif) && $santri_aktif['id'] == $s['id']) ? 'selected' : ''; ?>>
                        <?= esc($s['nama_santri']); ?> (Kelas <?= esc($s['nama_kelas']); ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endif; ?>

    <!-- Main Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-header bg-white border-0 py-3 px-4">
            <h5 class="fw-bold text-dark mb-1">Riwayat Setoran: <?= esc($santri_aktif['nama_santri'] ?? 'Tidak Ada Data Santri'); ?></h5>
            <p class="text-muted small mb-0">NIS: <?= esc($santri_aktif['nis'] ?? '-'); ?> &bull; Kelas: <?= esc($santri_aktif['nama_kelas'] ?? '-'); ?></p>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="py-3 ps-4" style="width: 5%;">No</th>
                            <th class="py-3" style="width: 25%;">Tanggal & Waktu Setor</th>
                            <th class="py-3" style="width: 30%;">Capaian Hafalan (Surah & Ayat)</th>
                            <th class="py-3" style="width: 20%;">Ustadz Penguji</th>
                            <th class="py-3 text-center" style="width: 20%;">Predikat & Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($riwayat) && is_array($riwayat)): ?>
                            <?php $no = 1;
                            foreach ($riwayat as $row): ?>
                                <tr>
                                    <td class="ps-4 fw-medium text-muted"><?= $no++; ?></td>
                                    <td>
                                        <div class="fw-semibold text-dark small"><?= date('d M Y', strtotime($row['created_at'])); ?></div>
                                        <small class="text-muted" style="font-size: 0.75rem;"><i class="fa-regular fa-clock me-1"></i> <?= date('H:i', strtotime($row['created_at'])); ?> WIB</small>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark d-block">Surah <?= esc($row['surah']); ?></span>
                                        <small class="text-muted">Juz <?= esc($row['juz']); ?> (Ayat <?= esc($row['ayat_mulai']); ?> - <?= esc($row['ayat_selesai']); ?>)</small>
                                    </td>
                                    <td>
                                        <span class="small text-dark d-block"><?= esc($row['nama_penguji'] ?? 'Ustadz Pembimbing'); ?></span>
                                        <small class="text-muted" style="font-size: 0.75rem;">Pengampu Tahfidz</small>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $predikat = strtolower($row['predikat']);
                                        $badgeClass = 'bg-success bg-opacity-10 text-success';
                                        if ($predikat == 'jayyid jiddan') $badgeClass = 'bg-primary bg-opacity-10 text-primary';
                                        elseif ($predikat == 'jayyid') $badgeClass = 'bg-warning bg-opacity-10 text-warning text-dark';
                                        ?>
                                        <span class="badge <?= $badgeClass; ?> px-3 py-1 rounded-pill small fw-semibold mb-1"><?= esc($row['predikat']); ?></span>
                                        <small class="d-block text-muted" style="font-size: 0.7rem;"><?= esc($row['catatan'] ?? 'Lancar'); ?></small>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted small">Belum ada riwayat setoran hafalan untuk anak Anda.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Card Footer / Pagination info -->
        <div class="card-footer bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
            <span class="text-muted small">Menampilkan total <?= !empty($riwayat) ? count($riwayat) : 0; ?> riwayat setoran</span>
        </div>
    </div>

</div>

<?= $this->endSection() ?>