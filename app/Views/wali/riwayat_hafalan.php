<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
/**
 * @var mixed $total_setoran
 */
?>

<div class="container-fluid px-0">

    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark-mode mb-1" style="text-transform: none !important;">Riwayat Hafalan <?= esc($santri_aktif['nama_santri'] ?? 'Ananda'); ?></h3>
            <p class="text-secondary mb-0 small" style="text-transform: none !important;">
                Catatan lengkap setoran hafalan Al-Qur'an ananda di pesantren.
            </p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <?php
            $noHpGuru = $santri_aktif['no_hp_guru'] ?? '';
            if (!empty($noHpGuru) && substr($noHpGuru, 0, 1) === '0') {
                $noHpGuru = '62' . substr($noHpGuru, 1);
            }
            ?>
            <a href="<?= !empty($noHpGuru) ? 'https://wa.me/' . esc($noHpGuru) : '#'; ?>"
                <?= !empty($noHpGuru) ? 'target="_blank"' : 'onclick="alert(\'Nomor WhatsApp guru belum tersedia\'); return false;"'; ?>
                class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm text-decoration-none"
                style="text-transform: none !important;">
                <i class="fab fa-whatsapp text-success me-1 fs-6"></i> <?= esc($santri_aktif['nama_guru'] ?? 'Belum ada'); ?>
            </a>
        </div>
    </div>

    <!-- Ringkasan Statistik Capaian Hafalan (Dinamis) -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-15 p-3 rounded-3 text-success">
                        <i class="fa-solid fa-book-quran fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-secondary small fw-medium" style="text-transform: none !important;">JUZ AKTIF SAAT INI</span>
                        <h3 class="fw-bold text-dark-mode mb-0 mt-1">
                            <?= esc($juz_aktif ?? 'Juz 30'); ?>
                        </h3>
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
                        <span class="text-secondary small fw-medium" style="text-transform: none !important;">TOTAL SETORAN PERIODE INI</span>
                        <h3 class="fw-bold text-dark-mode mb-0 mt-1">
                            <?= esc($total_setoran ?? 0); ?> <span class="fs-6 fw-normal text-secondary">Kali Setor</span>
                        </h3>
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
                        <span class="text-secondary small fw-medium" style="text-transform: none !important;">PREDIKAT DOMINAN</span>
                        <h3 class="fw-bold text-dark-mode mb-0 mt-1">
                            <?= esc($predikat_dominan ?? '-'); ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar Card (Search Realtime & Filter Disatukan) -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-body p-3">
            <form method="get" action="" id="formFilterRiwayat" class="row g-3 align-items-center">
                <!-- Search Bar Realtime -->
                <div class="col-lg-<?= (!empty($santri_list) && count($santri_list) > 1) ? '4' : '7'; ?>">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-0 ps-3 text-muted">
                            <i class="fa-solid fa-search"></i>
                        </span>
                        <input type="text" id="searchRiwayat" class="form-control bg-light border-0 py-2" placeholder="Cari berdasarkan surah, catatan, atau penguji...">
                    </div>
                </div>

                <!-- Dropdown Pilih Anak (Hanya muncul jika anak lebih dari 1) -->
                <?php if (!empty($santri_list) && count($santri_list) > 1): ?>
                    <div class="col-lg-4">
                        <select name="id_santri" class="form-select form-select-sm bg-light border-0 py-2" onchange="this.form.submit()">
                            <?php foreach ($santri_list as $s): ?>
                                <!-- DIPERBAIKI: Mengambil string/id dari array $s, bukan variabel objek/array global $santri_aktif -->
                                <option value="<?= esc($s['id']); ?>" <?= (isset($santri_aktif['id']) && $santri_aktif['id'] == $s['id']) ? 'selected' : ''; ?>>
                                    Anak: <?= esc($s['nama_santri']); ?> (<?= esc($s['nama_kelas'] ?? '-'); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <!-- Filter Periode -->
                <div class="col-lg-<?= (!empty($santri_list) && count($santri_list) > 1) ? '4' : '5'; ?>">
                    <select name="periode" class="form-select form-select-sm bg-light border-0 py-2" onchange="this.form.submit()">
                        <option value="bulan_ini" <?= (($periode ?? 'bulan_ini') == 'bulan_ini') ? 'selected' : ''; ?>>Periode: Bulan Ini</option>
                        <option value="minggu_ini" <?= (($periode ?? '') == 'minggu_ini') ? 'selected' : ''; ?>>Periode: Minggu Ini</option>
                        <option value="semester_ini" <?= (($periode ?? '') == 'semester_ini') ? 'selected' : ''; ?>>Periode: Semester Ini</option>
                        <option value="semua" <?= (($periode ?? '') == 'semua') ? 'selected' : ''; ?>>Semua Riwayat</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-header bg-white border-0 py-3 px-4">
            <h5 class="fw-bold text-dark mb-1">Riwayat Setoran: <?= esc($santri_aktif['nama_santri'] ?? 'Tidak Ada Data Santri'); ?></h5>
            <p class="text-muted small mb-0">NIS: <?= esc($santri_aktif['nis'] ?? '-'); ?> &bull; Kelas: <?= esc($santri_aktif['nama_kelas'] ?? '-'); ?></p>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="tabelRiwayatHafalan">
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
                            <?php
                            $currentPage = isset($pager) ? ($pager->getCurrentPage('hafalan') ?? 1) : 1;
                            $perPage = isset($pager) ? ($pager->getPerPage('hafalan') ?? 10) : 10;
                            $no = ($currentPage - 1) * $perPage + 1;

                            foreach ($riwayat as $row):
                            ?>
                                <tr>
                                    <td class="ps-4 fw-medium text-muted"><?= $no++; ?></td>
                                    <td>
                                        <div class="fw-semibold text-dark-mode small"><?= date('d M Y', strtotime($row['created_at'])); ?></div>
                                        <small class="text-secondary" style="font-size: 0.75rem;"><i class="fa-regular fa-clock me-1"></i> <?= date('H:i', strtotime($row['created_at'])); ?> WIB</small>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark-mode d-block">Surah <?= esc($row['surah']); ?> <span class="badge bg-secondary rounded-lg text-white small"><?= esc($row['jenis']); ?></span></span>
                                        <small class="text-secondary">Juz <?= esc($row['juz']); ?> (Ayat <?= esc($row['ayat_mulai']); ?> - <?= esc($row['ayat_selesai']); ?>)</small>
                                    </td>
                                    <td>
                                        <span class="small text-dark-mode d-block"><?= esc($row['nama_guru'] ?? 'Ustadz Pembimbing'); ?></span>
                                        <small class="text-secondary" style="font-size: 0.75rem;">Pengampu Tahfidz</small>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $predikat = strtolower($row['predikat'] ?? '');
                                        $badgeClass = 'bg-success bg-opacity-10 text-success';
                                        if (str_contains($predikat, 'jayyid jiddan') || str_contains($predikat, 'mumtaz')) $badgeClass = 'bg-primary bg-opacity-10 text-primary';
                                        elseif (str_contains($predikat, 'jayyid')) $badgeClass = 'bg-warning bg-opacity-10 text-warning text-dark';
                                        ?>
                                        <span class="badge <?= $badgeClass; ?> px-3 py-1 rounded-pill small fw-semibold mb-1"><?= esc($row['predikat']); ?></span>
                                        <small class="d-block text-secondary" style="font-size: 0.7rem;"><?= esc($row['catatan'] ?? 'Lancar'); ?></small>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr id="emptyRow">
                                <td colspan="5" class="text-center py-4 text-muted small">Belum ada riwayat setoran hafalan untuk anak Anda.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Card Footer / Info -->
        <div class="card-footer bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
            <span class="text-muted small">Menampilkan total <span id="jumlahBaris"><?= !empty($riwayat) ? count($riwayat) : 0; ?></span> riwayat setoran</span>
        </div>
    </div>

</div>

<!-- Skrip JavaScript untuk Search Realtime -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById('searchRiwayat');
        const table = document.getElementById('tabelRiwayatHafalan');
        const trs = table.getElementsByTagName('tr');
        const jumlahBarisSpan = document.getElementById('jumlahBaris');

        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
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