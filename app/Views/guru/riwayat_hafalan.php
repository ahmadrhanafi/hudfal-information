<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$santri = $santri ?? [];
?>

<div class="container-fluid px-0">

    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1 text-dark-mode" style="text-transform: none !important;">Riwayat Setoran Hafalan Santri</h3>
            <p class="text-muted mb-0 small text-dark-mode" style="text-transform: none !important;">Pantau rekam jejak hafalan Al-Qur'an (ziyadah dan murojaah) santri binaan kelas Anda.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm" style="text-transform: none !important;">
                <i class="fa-solid fa-file-excel text-success me-1"></i> Ekspor Rekap
            </button>
        </div>
    </div>

    <!-- Ringkasan Statistik Hafalan -->
    <div class="row g-4 mb-4">
        <!-- Total Setoran Bulan Ini -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-15 p-3 rounded-3 text-success">
                        <i class="fa-solid fa-book-quran fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted text-dark-mode small fw-medium" style="text-transform: none !important;">TOTAL SETORAN BULAN INI</span>
                        <h3 class="fw-bold text-dark-mode mb-0 mt-1">
                            <?= $total_setoran_bulan_ini ?? 0; ?> <span class="fs-6 fw-normal text-muted text-dark-mode">Sesi</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rata-rata Predikat -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-15 p-3 rounded-3 text-primary">
                        <i class="fa-solid fa-award fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted text-dark-mode small fw-medium" style="text-transform: none !important;">PREDIKAT DOMINAN</span>
                        <h3 class="fw-bold text-primary mb-0 mt-1">
                            <?= esc($predikat_umum ?? 'Mumtaz'); ?> <span class="fs-6 fw-normal text-success">(Bulan Ini)</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Santri Aktif Setoran -->
        <div class="col-xl-4 col-md-12">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-15 p-3 rounded-3 text-warning">
                        <i class="fa-solid fa-user-check fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted text-dark-mode small fw-medium" style="text-transform: none !important;">SANTRI AKTIF SETORAN</span>
                        <h3 class="fw-bold text-dark-mode mb-0 mt-1">
                            <?= $santri_aktif ?? 0; ?> / <?= $total_santri ?? 0; ?> <span class="fs-6 fw-normal text-muted text-dark-mode">Santri</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-body p-3">
            <div class="row g-3 align-items-center">
                <div class="col-lg-12">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-0 ps-3 text-muted">
                            <i class="fa-solid fa-search"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control bg-light border-0 py-2" placeholder="Cari nama atau nomor induk santri...">
                    </div>
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
                                <?php
                                // Generate Inisial Avatar Dinamis
                                $words = explode(' ', $s['nama_santri']);
                                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));

                                // Format warna status aktif santri
                                $statusColor = 'success';
                                $statusText = ucfirst($s['status_aktif'] ?? 'Aktif');
                                $statusLower = strtolower($s['status_aktif'] ?? 'aktif');

                                if ($statusLower == 'izin') $statusColor = 'warning';
                                if ($statusLower == 'sakit') $statusColor = 'info';
                                if ($statusLower == 'keluar' || $statusLower == 'tidak aktif') $statusColor = 'danger';
                                ?>
                                <tr class="item-row" data-search="<?= strtolower(esc($s['nama_santri'] . ' ' . $s['nis'] . ' ' . ($s['nama_kelas'] ?? ''))); ?>">
                                    <td class="ps-4 fw-medium text-muted nomor-urut"><?= $no++; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.9rem;">
                                                <?= $initials; ?>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold text-dark-mode" style="font-size: 0.9rem;"><?= esc($s['nama_santri']); ?></h6>
                                                <small class="text-muted text-dark-mode">Wali: <?= esc($s['nama_wali'] ?? 'N/A'); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted text-dark-mode"><?= esc($s['nis']); ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border px-2 py-1"><?= esc($s['nama_kelas'] ?? '-'); ?></span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="<?= base_url('guru/detail-riwayat-hafalan/' . $s['id']); ?>" class="btn btn-sm btn-light border rounded-pill px-3">
                                            <i class="fa-solid fa-eye text-primary me-1"></i> Detail Hafalan
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("searchInput");
        const rows = document.querySelectorAll(".item-row");
        const noResultDiv = document.getElementById("noResult");
        const infoJumlah = document.getElementById("infoJumlah");

        function filterTable() {
            const keyword = searchInput.value.toLowerCase().trim();

            let visibleCount = 0;
            let visibleNo = 1;

            rows.forEach(row => {
                const dataSearch = row.getAttribute("data-search") || "";
                const matchesSearch = dataSearch.includes(keyword);

                if (matchesSearch) {
                    row.style.display = "";
                    const nomorTd = row.querySelector(".nomor-urut");
                    if (nomorTd) {
                        nomorTd.textContent = visibleNo++;
                    }
                    visibleCount++;
                } else {
                    row.style.display = "none";
                }
            });

            if (visibleCount === 0 && rows.length > 0) {
                if (noResultDiv) noResultDiv.classList.remove("d-none");
            } else {
                if (noResultDiv) noResultDiv.classList.add("d-none");
            }

            if (infoJumlah) {
                infoJumlah.textContent = `Menampilkan ${visibleCount} dari total ${rows.length} data riwayat`;
            }
        }

        if (searchInput) {
            searchInput.addEventListener("keyup", filterTable);
        }
    });
</script>

<?= $this->endSection() ?>