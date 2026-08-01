<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$santri = $santri ?? [];
?>

<!-- Filter & Search Toolbar Card -->
<div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
    <div class="card-body p-3">
        <div class="row g-3 align-items-center">
            <div class="col-lg-6">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-0 ps-3 text-muted">
                        <i class="fa-solid fa-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control bg-light border-0 py-2" placeholder="Cari surah, ayat, juz, atau tanggal...">
                </div>
            </div>
            <div class="col-lg-3">
                <select id="filterJenis" class="form-select form-select-sm bg-light border-0 py-2">
                    <option value="">Jenis: Semua Jenis</option>
                    <option value="ziyadah">Ziyadah (Baru)</option>
                    <option value="murojaah">Murojaah (Ulang)</option>
                </select>
            </div>
            <div class="col-lg-3">
                <select id="filterPredikat" class="form-select form-select-sm bg-light border-0 py-2">
                    <option value="">Predikat: Semua</option>
                    <option value="mumtaz">Mumtaz</option>
                    <option value="jayyid jiddan">Jayyid Jiddan</option>
                    <option value="jayyid">Jayyid</option>
                    <option value="maqbul">Maqbul</option>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
    <!-- Header Ringkas Identitas Santri -->
    <div class="card-header bg-white border-0 p-4 pb-2">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-dark mb-1"><?= esc($santri['nama_santri']); ?></h5>
                <p class="text-muted small mb-0">NIS: <?= esc($santri['nis']); ?> &bull; Kelas: <?= esc($santri['nama_kelas'] ?? 'Belum Ada Kelas'); ?></p>
            </div>
            <a href="<?= base_url('guru/riwayat-hafalan'); ?>" class="btn btn-sm btn-light text-secondary border rounded-3 px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                    <tr>
                        <th class="py-3 ps-4" style="width: 5%;">No</th>
                        <th class="py-3" style="width: 25%;">Tanggal Setoran</th>
                        <th class="py-3" style="width: 20%;">Jenis & Target</th>
                        <th class="py-3" style="width: 20%;">Capaian (Juz / Surah)</th>
                        <th class="py-3 text-center" style="width: 15%;">Predikat</th>
                        <th class="py-3 text-end pe-4" style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabelRiwayat">
                    <?php if (!empty($riwayat) && is_array($riwayat)): ?>
                        <?php $no = 1;
                        foreach ($riwayat as $row): ?>
                            <tr class="item-row"
                                data-search="<?= strtolower(esc($row['surah'] . ' ' . $row['juz'] . ' ' . ($row['ayat_mulai'] ?? '') . ' ' . ($row['ayat_selesai'] ?? '') . ' ' . $row['created_at'])); ?>"
                                data-jenis="<?= strtolower($row['jenis'] ?? ''); ?>"
                                data-predikat="<?= strtolower($row['predikat'] ?? ''); ?>">
                                <td class="ps-4 fw-medium text-muted nomor-urut"><?= $no++; ?></td>
                                <td>
                                    <small class="text-muted" style="font-size: 0.8rem;"><i class="fa-regular fa-calendar me-1"></i> <?= date('d M Y, H:i', strtotime($row['created_at'])); ?> WIB</small>
                                </td>
                                <td>
                                    <?php if (strtolower($row['jenis']) == 'ziyadah'): ?>
                                        <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill small fw-semibold">Ziyadah</span>
                                    <?php else: ?>
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded-pill small fw-semibold">Murojaah</span>
                                    <?php endif; ?>
                                    <small class="text-muted d-block mt-1">Juz <?= esc($row['juz']); ?></small>
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark d-block">Surah <?= esc($row['surah']); ?></span>
                                    <small class="text-muted">Ayat <?= esc($row['ayat_mulai'] ?? '-'); ?> - <?= esc($row['ayat_selesai'] ?? '-'); ?></small>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $predikat = strtolower($row['predikat']);
                                    $badgeClass = 'bg-success text-white';
                                    if ($predikat == 'jayyid jiddan') $badgeClass = 'bg-primary text-white';
                                    elseif ($predikat == 'jayyid') $badgeClass = 'bg-warning text-dark';
                                    ?>
                                    <span class="badge <?= $badgeClass; ?> px-3 py-1 rounded-pill small fw-semibold"><?= esc($row['predikat']); ?></span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="<?= base_url('guru/hafalan/edit/' . $row['id']) ?>" class="btn btn-sm btn-light text-success border-0 rounded-2" title="Edit Detail">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="<?= base_url('guru/hafalan/hapus/' . $row['id']) ?>" class="btn btn-sm btn-light text-danger border-0 rounded-2" title="Hapus Log" onclick="return confirm('Hapus riwayat setoran ini?')">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr id="emptyRow">
                            <td colspan="6" class="text-center py-4 text-muted small">Belum ada data riwayat setoran hafalan untuk santri ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <!-- Pesan Kosong Realtime -->
            <div id="noResult" class="text-center py-4 text-muted small d-none">
                Tidak ada riwayat setoran yang cocok dengan filter atau pencarian Anda.
            </div>
        </div>
    </div>

    <!-- Card Footer info -->
    <div class="card-footer bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
        <span class="text-muted small" id="infoJumlah">Menampilkan total <?= !empty($riwayat) ? count($riwayat) : 0; ?> riwayat setoran</span>
    </div>
</div>

<!-- JavaScript Realtime Filter & Search -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("searchInput");
        const filterJenis = document.getElementById("filterJenis");
        const filterPredikat = document.getElementById("filterPredikat");
        const rows = document.querySelectorAll(".item-row");
        const noResultDiv = document.getElementById("noResult");
        const infoJumlah = document.getElementById("infoJumlah");

        function filterTable() {
            const keyword = searchInput.value.toLowerCase().trim();
            const jenisVal = filterJenis.value.toLowerCase();
            const predikatVal = filterPredikat.value.toLowerCase();

            let visibleCount = 0;
            let visibleNo = 1;

            rows.forEach(row => {
                const dataSearch = row.getAttribute("data-search") || "";
                const dataJenis = row.getAttribute("data-jenis") || "";
                const dataPredikat = row.getAttribute("data-predikat") || "";

                const matchesSearch = dataSearch.includes(keyword);
                const matchesJenis = (jenisVal === "" || dataJenis.includes(jenisVal));
                const matchesPredikat = (predikatVal === "" || dataPredikat.includes(predikatVal));

                if (matchesSearch && matchesJenis && matchesPredikat) {
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
                infoJumlah.textContent = `Menampilkan ${visibleCount} dari total ${rows.length} riwayat setoran`;
            }
        }

        if (searchInput) searchInput.addEventListener("keyup", filterTable);
        if (filterJenis) filterJenis.addEventListener("change", filterTable);
        if (filterPredikat) filterPredikat.addEventListener("change", filterTable);
    });
</script>

<?= $this->endSection() ?>