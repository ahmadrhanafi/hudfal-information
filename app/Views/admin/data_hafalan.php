<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$hafalan  = $hafalan ?? [];
?>

<div class="container-fluid px-0">

    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1" style="text-transform: none !important;">Monitoring Data Hafalan</h3>
            <p class="text-muted mb-0 small" style="text-transform: none !important;">Pantau perkembangan setoran hafalan Al-Qur'an, juz, surah, serta predikat nilai santri.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm" style="text-transform: none !important;">
                <i class="fa-solid fa-file-excel text-success me-1"></i> Rekap Laporan
            </button>
            <a href="<?= base_url('admin/hafalan/tambah') ?>" class="btn btn-success btn-sm px-3 rounded-pill shadow-sm" style="text-transform: none !important;">
                <i class="fa-solid fa-plus me-1"></i> Input Setoran Baru
            </a>
        </div>
    </div>

    <!-- Alert Notifikasi Flashmessage -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> <?= session()->getFlashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

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
                        <input type="text" id="searchInput" class="form-control bg-light border-0 py-2" placeholder="Cari nama santri atau ustadz penguji...">
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
                        <option value="mumtaz">Mumtaz (Sangat Baik)</option>
                        <option value="jayyid jiddan">Jayyid Jiddan</option>
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
                    <thead class="bg-light text-muted small text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
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
                        <?php if (!empty($hafalan)): ?>
                            <?php $no = 1;
                            foreach ($hafalan as $h): ?>
                                <?php
                                // Generate Inisial Avatar
                                $words = explode(' ', $h['nama_santri']);
                                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));

                                // Format warna badge predikat
                                $badgeColor = 'success';
                                $predikatLower = strtolower($h['predikat']);
                                if ($predikatLower == 'jayyid') $badgeColor = 'primary';
                                if ($predikatLower == 'jayyid jiddan') $badgeColor = 'info';
                                if ($predikatLower == 'maqbul') $badgeColor = 'warning';
                                ?>
                                <!-- Baris data dengan atribut data-* untuk keperluan filter JS -->
                                <tr class="hafalan-row"
                                    data-juz="<?= $h['juz']; ?>"
                                    data-predikat="<?= strtolower($h['predikat']); ?>">
                                    <td class="ps-4 fw-medium text-muted"><?= $no++; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.9rem;">
                                                <?= $initials; ?>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold text-dark" style="font-size: 0.9rem;"><?= esc($h['nama_santri']); ?></h6>
                                                <small class="text-muted"><i class="fa-regular fa-calendar me-1"></i> <?= date('d M Y', strtotime($h['created_at'])); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark d-block">Juz <?= esc($h['juz']); ?> <span class="badge bg-light text-secondary border ms-1"><?= ucfirst($h['jenis']); ?></span></span>
                                        <small class="text-muted">Surah <?= esc($h['surah']); ?> (Ayat <?= $h['ayat_mulai']; ?>-<?= $h['ayat_selesai']; ?>)</small>
                                    </td>
                                    <td><span class="text-secondary small fw-medium"><?= esc($h['nama_guru']); ?></span></td>
                                    <td class="text-center">
                                        <span class="badge bg-<?= $badgeColor; ?> bg-opacity-10 text-<?= $badgeColor; ?> px-3 py-1 rounded-pill small fw-semibold">
                                            <?= esc($h['predikat']); ?>
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="#" class="btn btn-sm btn-light text-primary border-0 rounded-2" title="Detail">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-light text-warning border-0 rounded-2" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="<?= base_url('admin/hafalan/delete/' . $h['id']); ?>" class="btn btn-sm btn-light text-danger border-0 rounded-2" title="Hapus" onclick="return confirm('Yakin ingin menghapus data hafalan ini?')">
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
                                <i class="fa-solid fa-folder-open me-1"></i> Tidak ada data setoran hafalan yang ditemukan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Card Footer / Total Data Dinamis -->
        <div class="card-footer bg-white border-0 py-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <span class="text-muted small" id="totalDataTextHafalan">Menampilkan total <?= count($hafalan); ?> data setoran hafalan</span>
        </div>
    </div>

</div>

<!-- Skrip JavaScript Filter & Search Realtime -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
</script>

<?= $this->endSection() ?>