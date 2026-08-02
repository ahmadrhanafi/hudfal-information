<?= $this->extend('layout/main') ?>

<?php
/**
 * @var string $title
 * @var string $nama_kelas
 * @var string $periode
 * @var array{juz: string|int, persen: int|float} $juz_dominan
 * @var float|int $rata_setoran
 * @var string $predikat_umum
 * @var array<int, array{nama: string, persen: int|float, color: string}> $capaian_juz
 * @var array $grafik_setoran
 */
?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1" style="text-transform: none !important;"><?= esc($title); ?></h3>
            <p class="text-muted mb-0 small" style="text-transform: none !important;">Analisis mendalam mengenai grafik perkembangan setoran, rata-rata hafalan, dan progres seluruh santri.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <!-- Tombol Unduh PDF Dinamis -->
            <a href="<?= base_url('admin/statistik-hafalan/export?periode=' . $periode); ?>" class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm text-decoration-none" style="text-transform: none !important;">
                <i class="fa-solid fa-download text-success me-1"></i> Unduh PDF
            </a>

            <!-- Dropdown Filter Periode -->
            <div class="dropdown">
                <button class="btn btn-success btn-sm px-3 rounded-pill shadow-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" style="text-transform: none !important;">
                    <i class="fa-solid fa-filter me-1"></i> Periode: <?= ucwords(str_replace('_', ' ', $periode)); ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                    <li><a class="dropdown-item small <?= ($periode == 'bulan_ini') ? 'active' : ''; ?>" href="<?= base_url('admin/statistik-hafalan?periode=bulan_ini'); ?>">Bulan Ini</a></li>
                    <li><a class="dropdown-item small <?= ($periode == 'semester_ini') ? 'active' : ''; ?>" href="<?= base_url('admin/statistik-hafalan?periode=semester_ini'); ?>">Semester Ini</a></li>
                    <li><a class="dropdown-item small <?= ($periode == 'tahun_ini') ? 'active' : ''; ?>" href="<?= base_url('admin/statistik-hafalan?periode=tahun_ini'); ?>">Tahun Ini</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Analitik Ringkasan Kartu -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-15 p-3 rounded-3 text-success">
                        <i class="fa-solid fa-chart-line fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">RATA-RATA SETORAN HARIAN</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1"><?= esc((string) $rata_setoran); ?> <span class="fs-6 fw-normal text-muted">Ayat / Hari</span></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-15 p-3 rounded-3 text-primary">
                        <i class="fa-solid fa-trophy fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">JUZ PALING BANYAK DISETOR</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">Juz <?= esc((string) ($juz_dominan['juz'] ?? '-')); ?> <span class="fs-6 fw-normal text-success">(<?= esc((string) ($juz_dominan['persen'] ?? 0)); ?>%)</span></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-15 p-3 rounded-3 text-warning">
                        <i class="fa-solid fa-star fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">PREDIKAT TERDOMINASI</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1"><?= esc((string) $predikat_umum); ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik & Breakdown Bagian Bawah -->
    <div class="row g-4">
        <!-- Grafik Utama -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="fw-bold text-dark m-0" style="text-transform: none !important;">
                            <i class="fa-solid fa-chart-area text-success me-2"></i> Grafik Tren Setoran Global (<?= ucwords(str_replace('_', ' ', $periode)); ?>)
                        </h5>
                        <span class="badge bg-light text-secondary border">Real-time Data</span>
                    </div>

                    <!-- Canvas untuk Chart.js -->
                    <div style="position: relative; height: 320px; width: 100%;">
                        <canvas id="grafikSetoranGlobal"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Berdasarkan Juz -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-4" style="text-transform: none !important;">
                        <i class="fa-solid fa-layer-group text-success me-2"></i> Capaian per Juz (Global)
                    </h5>

                    <?php if (!empty($capaian_juz)): ?>
                        <?php foreach ($capaian_juz as $juz): ?>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between small fw-semibold mb-1">
                                    <span class="text-dark"><?= esc((string) ($juz['nama'] ?? '')); ?></span>
                                    <span class="text-<?= esc((string) ($juz['color'] ?? 'secondary')); ?>"><?= esc((string) ($juz['persen'] ?? 0)); ?>%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-<?= esc((string) ($juz['color'] ?? 'secondary')); ?> rounded-pill" role="progressbar" style="width: <?= esc((string) ($juz['persen'] ?? 0)); ?>%;"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <div class="mt-4 pt-2 text-center">
                        <small class="text-muted">Persentase dihitung dari akumulasi total seluruh santri aktif.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Pastikan CDN Chart.js ada (hapus baris ini jika di layout/main.php sudah ada) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Script Inisialisasi Chart.js -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const canvasEl = document.getElementById('grafikSetoranGlobal');
        if (!canvasEl) return;

        const ctx = canvasEl.getContext('2d');
        const rawData = <?= json_encode($grafik_setoran ?? []); ?>;

        let labels = [];
        let dataValues = [];

        if (rawData && rawData.labels && rawData.values) {
            labels = rawData.labels;
            dataValues = rawData.values;
        } else if (Array.isArray(rawData) && rawData.length > 0) {
            labels = rawData.map(item => item.bulan || item.tanggal || item.label || '');
            dataValues = rawData.map(item => item.total || item.jumlah || item.value || 0);
        } else {
            labels = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];
            dataValues = [0, 0, 0, 0];
        }

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Ayat Disetor',
                    data: dataValues,
                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                    borderColor: '#198754',
                    borderWidth: 3,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#198754',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(33, 37, 41, 0.9)',
                        titleFont: {
                            size: 13
                        },
                        bodyFont: {
                            size: 13
                        },
                        padding: 10,
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.04)'
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
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