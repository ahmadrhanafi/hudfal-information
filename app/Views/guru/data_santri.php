<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$santri = $santri ?? [];
/** @var \CodeIgniter\Pager\Pager $pager
 * @var string $nama_kelas
 **/
?>

<div class="container-fluid px-0">

    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1 text-dark-mode" style="text-transform: none !important;">Data Santri Kelas
                <?= esc($nama_kelas); ?>
            </h3>
            <p class="text-muted mb-0 small text-dark-mode" style="text-transform: none !important;">Daftar santri yang
                berada di bawah perwalian atau kelas yang Anda ajar.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="<?= base_url('guru/santri/cetak'); ?>" target="_blank"
                class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm text-decoration-none"
                style="text-transform: none !important;">
                <i class="fa-solid fa-print text-success me-1"></i> Cetak Data Santri
            </a>
        </div>
    </div>

    <!-- Filter & Search Toolbar Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-body p-3">
            <div class="row g-3 align-items-center">
                <div class="col-lg-9">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-0 ps-3 text-muted">
                            <i class="fa-solid fa-search"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control bg-light border-0 py-2"
                            placeholder="Cari nama santri, NIS, atau wali...">
                    </div>
                </div>
                <div class="col-lg-3">
                    <select id="genderFilter" class="form-select form-select-sm bg-light border-0 py-2">
                        <option value="semua" selected>Filter: Semua Gender</option>
                        <option value="l">Laki-laki</option>
                        <option value="p">Perempuan</option>
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
                            <th class="py-3" style="width: 30%;">Nama Santri</th>
                            <th class="py-3" style="width: 15%;">NIS</th>
                            <th class="py-3" style="width: 15%;">Kelas</th>
                            <th class="py-3 text-center" style="width: 15%;">Status</th>
                            <th class="py-3 text-end pe-4" style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBodySantri">
                        <?php if (!empty($santri) && is_array($santri)): ?>
                            <?php
                            // Hitung penomoran kontinu jika menggunakan pager, default ke 1 jika tidak ada pager
                            $currentPage = isset($pager) ? ($pager->getCurrentPage('santri') ?? 1) : 1;
                            $perPage = isset($pager) ? ($pager->getPerPage('santri') ?? 10) : 10;
                            $no = ($currentPage - 1) * $perPage + 1;

                            foreach ($santri as $s):
                                ?>
                                <?php
                                // Generate Inisial Avatar Dinamis
                                $words = explode(' ', $s['nama_santri']);
                                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));

                                // Format warna status aktif santri
                                $statusColor = 'success';
                                $statusText = ucfirst($s['status_aktif'] ?? 'Aktif');
                                $statusLower = strtolower($s['status_aktif'] ?? 'aktif');

                                if ($statusLower == 'izin')
                                    $statusColor = 'warning';
                                if ($statusLower == 'sakit')
                                    $statusColor = 'info';
                                if ($statusLower == 'keluar' || $statusLower == 'tidak aktif')
                                    $statusColor = 'danger';
                                ?>
                                <!-- Baris data dengan atribut data-* untuk filter JS -->
                                <tr class="santri-row"
                                    data-kelas="<?= strtolower(str_replace(' ', '', $s['nama_kelas'] ?? '')); ?>"
                                    data-status="<?= $statusLower; ?>"
                                    data-gender="<?= strtolower($s['jenis_kelamin'] ?? ''); ?>">
                                    <td class="ps-4 fw-medium text-muted"><?= $no++; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                                style="width: 38px; height: 38px; font-size: 0.9rem;">
                                                <?= $initials; ?>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold text-dark-mode" style="font-size: 0.9rem;">
                                                    <?= esc($s['nama_santri']); ?>
                                                </h6>
                                                <small class="text-muted text-dark-mode">Wali:
                                                    <?= esc($s['nama_wali'] ?? 'Belum diset'); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="font-monospace text-secondary small"><?= esc($s['nis']); ?></span></td>
                                    <td><span
                                            class="badge bg-light text-dark border px-2 py-1"><?= esc($s['nama_kelas'] ?? '-'); ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge bg-<?= $statusColor; ?> bg-opacity-10 text-<?= $statusColor; ?> px-3 py-1 rounded-pill small fw-semibold">
                                            <?= $statusText; ?>
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="<?= base_url('guru/santri-detail/' . $s['id']) ?>"
                                                class="btn btn-sm btn-light text-primary border-0 rounded-2"
                                                title="Lihat Detail Akademik">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url('guru/detail-riwayat-hafalan/' . $s['id']) ?>"
                                                class="btn btn-sm btn-light text-success border-0 rounded-2"
                                                title="Lihat Hafalan">
                                                <i class="fa-solid fa-book-quran"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <!-- Baris Kosong Jika Data Tidak Ditemukan -->
                        <tr id="emptyRowSantri" class="d-none">
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fa-solid fa-folder-open me-1"></i> Tidak ada data santri yang ditemukan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Card Footer / Total Data Dinamis -->
        <div
            class="card card-footer bg-white border-0 py-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <span class="text-secondary small" id="totalDataTextSantri">Menampilkan total <?= count($santri); ?> santri
                binaan</span>
        </div>
    </div>

</div>

<!-- Skrip JavaScript Filter & Search Realtime -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const genderFilter = document.getElementById('genderFilter'); // Diubah dari kelasFilter
        const rows = document.querySelectorAll('#tableBodySantri .santri-row');
        const totalDataText = document.getElementById('totalDataTextSantri');
        const emptyRow = document.getElementById('emptyRowSantri');

        function filterSantri() {
            const keyword = searchInput ? searchInput.value.toLowerCase() : '';
            const genderVal = genderFilter ? genderFilter.value.toLowerCase() : 'semua';

            let visibleCount = 0;

            rows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                const rowGender = row.getAttribute('data-gender'); // Mengambil data-gender dari tr

                const matchesKeyword = rowText.includes(keyword);
                const matchesGender = (genderVal === 'semua' || rowGender === genderVal);

                if (matchesKeyword && matchesGender) {
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
                totalDataText.textContent = `Menampilkan total ${visibleCount} santri binaan`;
            }
        }

        if (searchInput) searchInput.addEventListener('keyup', filterSantri);
        if (genderFilter) genderFilter.addEventListener('change', filterSantri);
    });
</script>

<?= $this->endSection() ?>