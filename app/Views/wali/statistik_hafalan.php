<?php

/**
 * @var mixed $santri
 * @var mixed $periode
 * @var mixed $total_juz
 * @var mixed $streak
 * @var mixed $rata_predikat
 * @var mixed $komposisi
 * @var mixed $grafik_bulanan
 * @var mixed $detail_juz
 * @var mixed $selected_santri
 */

$santriData     = $santri ?? [];
$santriVal      = is_array($santriData) ? ($santriData['nama_santri'] ?? '-') : '-';
$periodeVal     = isset($periode) ? (string)$periode : 'bulan_ini';
$totalJuzVal    = is_numeric($total_juz ?? null) ? (string)$total_juz : '0';
$streakVal      = is_numeric($streak ?? null) ? (string)$streak : '0';
$rataPredVal    = is_array($rata_predikat ?? null) ? (string)($rata_predikat['predikat'] ?? 'Mumtaz') : (string)($rata_predikat ?? 'Mumtaz');

$komposisiZiy   = is_array($komposisi ?? null) ? (string)($komposisi['ziyadah'] ?? '0') : '0';
$komposisiMur   = is_array($komposisi ?? null) ? (string)($komposisi['murojaah'] ?? '0') : '0';

$grafikBulanan  = is_array($grafik_bulanan ?? null) ? $grafik_bulanan : [];
$detailJuz      = is_array($detail_juz ?? null) ? $detail_juz : [];
?>

<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Page Header & Filter Pilihan Anak & Periode -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-user-name mb-1" style="text-transform: none !important;">Statistik Hafalan Ananda</h3>
            <p class="text-muted mb-0 small" style="text-transform: none !important;">
                Menampilkan rekam jejak hafalan santri: <span class="fw-semibold text-user-name"><?= esc($selected_santri['nama_santri'] ?? $nama_santri ?? 'Ananda'); ?></span>
            </p>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <!-- Dropdown Pilih Anak (Hanya muncul jika anak lebih dari 1) -->
            <?php if (!empty($santri) && is_array($santri) && count($santri) > 1): ?>
                <div class="dropdown">
                    <button class="btn btn-outline-success btn-sm dropdown-toggle rounded-pill px-3 py-2 bg-white shadow-sm" type="button" id="dropdownPilihAnak" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-child-reaching me-1"></i> <strong><?= esc($selected_santri['nama_santri']); ?></strong>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2" aria-labelledby="dropdownPilihAnak" style="min-width: 200px;">
                        <?php foreach ($santri as $a): ?>
                            <li>
                                <a class="dropdown-item rounded-3 py-2 px-3 small <?= ($a['id'] == $selected_santri['id']) ? 'active bg-success text-white' : 'text-dark'; ?>"
                                    href="<?= base_url('wali/statistik-hafalan?anak=' . $a['id'] . '&periode=' . ($periode ?? 'bulan_ini')); ?>">
                                    <?= esc($a['nama_santri']); ?> <small class="opacity-75">(<?= esc($a['nama_kelas'] ?? '-'); ?>)</small>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Form Filter Periode & Kirim ID Anak Sekaligus -->
            <form method="get" action="" id="formPeriode" class="d-flex align-items-center">
                <?php if (!empty($selected_santri)): ?>
                    <input type="hidden" name="anak" value="<?= esc($selected_santri['id']); ?>">
                <?php endif; ?>
                <select name="periode" class="form-select form-select-sm bg-white border shadow-sm rounded-pill px-3 py-2" style="width: 140px !important;" onchange="document.getElementById('formPeriode').submit()">
                    <option value="minggu_ini" <?= (($periode ?? '') == 'minggu_ini') ? 'selected' : ''; ?>>Minggu Ini</option>
                    <option value="bulan_ini" <?= (($periode ?? '') == 'bulan_ini') ? 'selected' : ''; ?>>Bulan Ini</option>
                    <option value="semester_ini" <?= (($periode ?? '') == 'semester_ini') ? 'selected' : ''; ?>>Semester Ini</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Ringkasan Statistik Utama -->
    <div class="row g-4 mb-4">
        <!-- Total Juz Selesai -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-15 p-3 rounded-3 text-success">
                        <i class="fa-solid fa-book-quran fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">TOTAL JUZ SELESAI</span>
                        <h3 class="fw-bold mb-0 mt-1 text-user-name">
                            <?= esc($total_juz ?? 0); ?> <span class="fs-6 fw-normal text-muted">Juz</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Streak Setoran Harian -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-15 p-3 rounded-3 text-warning">
                        <i class="fa-solid fa-fire fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">STREAK SETORAN</span>
                        <h3 class="fw-bold mb-0 mt-1 text-user-name">
                            <?= esc($streak ?? 0); ?> <span class="fs-6 fw-normal text-muted">Hari Aktif</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rata-rata Predikat -->
        <div class="col-xl-4 col-md-12">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-15 p-3 rounded-3 text-primary">
                        <i class="fa-solid fa-award fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">PREDIKAT RATA-RATA</span>
                        <h3 class="fw-bold text-primary mb-0 mt-1">
                            <?php
                            if (is_array($rata_predikat)) {
                                // Jika array, ambil teks predikatnya (sesuaikan key-nya, misal 'predikat' atau 'nama_predikat')
                                echo esc($rata_predikat['predikat'] ?? $rata_predikat['nama_predikat'] ?? 'Jayyid Jiddan');
                            } else {
                                echo esc($rata_predikat ?? '-');
                            }
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    $chartLabels   = $chart_labels ?? ['2026-08-01', '2026-08-02'];
    $chartZiyadah  = $chart_ziyadah ?? [1, 3];
    $chartMurojaah = $chart_murojaah ?? [0, 1];
    $komposisiZiy  = $komposisi['ziyadah'] ?? 0;
    $komposisiMur  = $komposisi['murojaah'] ?? 0;
    ?>

    <!-- Baris Grafik & Komposisi -->
    <div class="row g-4 mb-4">
        <!-- Grafik Progres Hafalan (Line Chart) -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="text-success">
                            <i class="fa-solid fa-chart-line fa-lg"></i>
                        </div>
                        <h5 class="fw-bold mb-0 text-user-name" style="text-transform: none !important; font-size: 1.05rem;">Grafik Progres Hafalan Ananda</h5>
                    </div>
                    <span class="badge bg-secondary-subtle text-secondary border px-3 py-2 rounded-pill small fw-semibold">
                        <?= esc(ucwords(str_replace('_', ' ', $periode ?? 'bulan_ini'))); ?>
                    </span>
                </div>
                <p class="text-muted small mb-4">Grafik tren pencapaian setoran hafalan berdasarkan rentang waktu terpilih.</p>

                <div style="position: relative; height: 300px; width: 100%;">
                    <canvas id="progresHafalanChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Komposisi Ziyadah vs Murojaah -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <h5 class="fw-bold mb-1 text-user-name" style="text-transform: none !important; font-size: 1.05rem;">Komposisi Setoran</h5>
                <p class="text-muted small mb-4">Rasio perbandingan antara hafalan baru dan pengulangan.</p>

                <div class="mb-4">
                    <div class="d-flex justify-content-between small fw-semibold mb-1">
                        <span class="text-success"><i class="fa-solid fa-circle-plus me-1"></i> Ziyadah (Baru)</span>
                        <span class="text-user-name"><?= esc($komposisiZiy); ?>%</span>
                    </div>
                    <div class="progress rounded-pill bg-secondary-subtle" style="height: 10px;">
                        <div class="progress-bar bg-success rounded-pill" role="progressbar" style="width: <?= esc($komposisiZiy); ?>%;"></div>
                    </div>
                </div>

                <div>
                    <div class="d-flex justify-content-between small fw-semibold mb-1">
                        <span class="text-primary"><i class="fa-solid fa-rotate-right me-1"></i> Murojaah (Ulang)</span>
                        <span class="text-user-name"><?= esc($komposisiMur); ?>%</span>
                    </div>
                    <div class="progress rounded-pill bg-secondary-subtle" style="height: 10px;">
                        <div class="progress-bar bg-primary rounded-pill" role="progressbar" style="width: <?= esc($komposisiMur); ?>%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Rekap Progress Juz -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
            <h5 class="fw-bold text-dark mb-1" style="text-transform: none !important; font-size: 1.05rem;">Detail Capaian per Juz</h5>
            <p class="text-muted small mb-3">Status penyelesaian juz Al-Qur'an ananda berdasarkan filter terpilih.</p>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="py-3 ps-4" style="width: 15%;">Juz</th>
                            <th class="py-3" style="width: 35%;">Nama Surah / Keterangan</th>
                            <th class="py-3" style="width: 30%;">Total Setoran</th>
                            <th class="py-3 text-end pe-4" style="width: 20%;">Predikat Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($detailJuz) && is_array($detailJuz)): ?>
                            <?php foreach ($detailJuz as $row): ?>
                                <?php
                                $rJuz   = is_array($row) ? (string)($row['juz'] ?? '-') : '-';
                                $rSurah = is_array($row) ? (string)($row['surah'] ?? '-') : '-';
                                $rTotal = is_array($row) ? (string)($row['total_setoran'] ?? '0') : '0';
                                $rPred  = is_array($row) ? (string)($row['predikat'] ?? '-') : '-';

                                // Logika warna badge dinamis berdasarkan predikat
                                $predikatLower = strtolower($rPred);
                                $badgeClass = 'bg-success bg-opacity-10 text-success';
                                if (str_contains($predikatLower, 'mumtaz') || str_contains($predikatLower, 'jayyid jiddan')) {
                                    $badgeClass = 'bg-primary bg-opacity-10 text-primary';
                                } elseif (str_contains($predikatLower, 'jayyid')) {
                                    $badgeClass = 'bg-warning bg-opacity-10 text-warning text-dark';
                                } elseif (str_contains($predikatLower, 'maqbul')) {
                                    $badgeClass = 'bg-secondary bg-opacity-10 text-secondary';
                                }
                                ?>
                                <tr>
                                    <td class="ps-4 fw-semibold text-dark">Juz <?= esc($rJuz); ?></td>
                                    <td>
                                        <span class="fw-semibold text-dark d-block small"><?= esc($rSurah); ?></span>
                                        <small class="text-muted" style="font-size: 0.75rem;">Terekam di sistem</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border px-2 py-1"><?= esc($rTotal); ?> Kali Setor</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <span class="badge <?= $badgeClass; ?> px-3 py-1 rounded-pill small fw-semibold"><?= esc($rPred); ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Belum ada data capaian juz pada periode ini.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3 px-4">
            <small class="text-muted"><i class="fa-solid fa-circle-info me-1"></i> Data statistik diperbarui secara otomatis setiap kali ustadz pembimbing memasukkan log setoran harian.</small>
        </div>
    </div>

</div>

<!-- Sertakan Chart.js CDN jika belum ada di layout utama -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('progresHafalanChart').getContext('2d');

        // Data dari PHP
        const labels = <?= json_encode($chartLabels); ?>;
        const dataZiyadah = <?= json_encode($chartZiyadah); ?>;
        const dataMurojaah = <?= json_encode($chartMurojaah); ?>;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Ziyadah (Baru)',
                        data: dataZiyadah,
                        borderColor: '#198754', // Hijau Bootstrap
                        backgroundColor: function(context) {
                            const chart = context.chart;
                            const {
                                ctx,
                                chartArea
                            } = chart;
                            if (!chartArea) return null;
                            const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                            gradient.addColorStop(0, 'rgba(25, 135, 84, 0.0)');
                            gradient.addColorStop(1, 'rgba(25, 135, 84, 0.2)');
                            return gradient;
                        },
                        borderWidth: 2.5,
                        pointBackgroundColor: '#198754',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.2
                    },
                    {
                        label: 'Murojaah (Ulang)',
                        data: dataMurojaah,
                        borderColor: '#0d6efd',
                        backgroundColor: function(context) {
                            const chart = context.chart;
                            const {
                                ctx,
                                chartArea
                            } = chart;
                            if (!chartArea) return null;
                            const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                            gradient.addColorStop(0, 'rgba(13, 110, 253, 0.0)');
                            gradient.addColorStop(1, 'rgba(13, 110, 253, 0.2)');
                            return gradient;
                        },
                        borderWidth: 2.5,
                        pointBackgroundColor: '#0d6efd',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            boxWidth: 12,
                            font: {
                                size: 12,
                                family: 'inherit'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(33, 37, 41, 0.9)',
                        titleFont: {
                            size: 12
                        },
                        bodyFont: {
                            size: 12
                        },
                        padding: 10,
                        cornerRadius: 8,
                        // Tambahkan callbacks label di sini
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += context.parsed.y + ' Ayat';
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: {
                                size: 11
                            }
                        },
                        grid: {
                            color: '#f1f5f9'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>