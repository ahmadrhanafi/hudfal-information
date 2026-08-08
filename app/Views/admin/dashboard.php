<?= $this->extend('layout/main') ?>

<?php
/**
 * @var string $title
 * @var string $nama_kelas
 * @var string $total_santri
 * @var string $total_ustadz
 * @var string $total_setoran
 * @var string $periode
 * @var array{juz: string|int, persen: int|float} $juz_dominan
 * @var float|int $rata_setoran
 * @var string $predikat_umum
 * @var array<int, array{nama: string, persen: int|float, color: string}> $capaian_juz
 * @var array $grafik_setoran
 * @var array $grafik_data
 */
?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Welcome Banner Modern -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 position-relative overflow-hidden">
                <div class="position-absolute top-0 end-0 mt-4 me-5 d-none d-lg-block">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 text-success d-flex align-items-center justify-content-center"
                        style="width: 70px; height: 70px;">
                        <i class="fa-solid fa-mosque fa-2x"></i>
                    </div>
                </div>
                <div style="z-index: 1;">
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-semibold mb-2"
                        style="text-transform: none !important;">
                        <i class="fa-solid fa-circle-check me-1"></i> Panel Administrator
                    </span>
                    <h3 class="fw-bold text-dark-mode mb-1" style="text-transform: none !important;">Selamat Datang,
                        <?= session()->get('name') ?>!
                    </h3>
                    <p class="text-secondary small mb-0" style="text-transform: none !important;">Ringkasan data
                        operasional sistem monitoring hafalan di Ponpes Hudatul Falah saat ini.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Cards Row -->
    <div class="row g-4 mb-4">
        <!-- Card 1: Total Ustadz -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-primary">
                            <i class="fa-solid fa-chalkboard-user fa-lg"></i>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold"
                            style="text-transform: none !important;">Status Aktif</span>
                    </div>
                    <h6 class="text-secondary mb-1 font-monospace small" style="text-transform: none !important;">TOTAL
                        USTADZ</h6>
                    <h2 class="fw-bold text-dark-mode mb-0"><?= esc($total_ustadz ?? 0); ?></h2>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Santri -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-success bg-opacity-10 p-3 rounded-3 text-success">
                            <i class="fa-solid fa-user-graduate fa-lg"></i>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success fw-semibold"
                            style="text-transform: none !important;">Keseluruhan</span>
                    </div>
                    <h6 class="text-secondary mb-1 font-monospace small" style="text-transform: none !important;">TOTAL
                        SANTRI</h6>
                    <h2 class="fw-bold text-dark-mode mb-0"><?= esc($total_santri ?? 0); ?></h2>
                </div>
            </div>
        </div>

        <!-- Card 3: Setoran Hafalan -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-3 text-warning">
                            <i class="fa-solid fa-book-quran fa-lg"></i>
                        </div>
                        <span class="badge bg-warning bg-opacity-10 text-warning fw-semibold"
                            style="text-transform: none !important;">Semua Data</span>
                    </div>
                    <h6 class="text-secondary mb-1 font-monospace small" style="text-transform: none !important;">
                        SETORAN HAFALAN</h6>
                    <h2 class="fw-bold text-dark-mode mb-0"><?= esc($total_setoran ?? 0); ?></h2>
                </div>
            </div>
        </div>

        <!-- Card 4: Santri Khatam / Lulus -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white position-relative overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-success bg-opacity-10 p-3 rounded-3 text-success">
                            <i class="fa-solid fa-award fa-lg"></i>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success fw-semibold"
                            style="text-transform: none !important;">Kelulusan
                        </span>
                    </div>
                    <h6 class="text-secondary mb-1 font-monospace small" style="text-transform: none !important;">TOTAL
                        HAFIDZ/AH</h6>
                    <div class="d-flex align-baseline gap-2 mt-1">
                        <h2 class="fw-bold text-dark-mode mb-0" style="font-size: 1.8rem;">
                            <?= number_format($total_khatam ?? 0, 0, ',', '.'); ?>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Bawah: Grafik & Menu Pintasan -->
    <div class="row g-4">
        <!-- Kolom Grafik / Aktivitas -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="fw-bold text-dark-mode m-0"
                            style="text-transform: none !important; font-size: 18px;">
                            <i class="fa-solid fa-chart-line text-success me-2"></i> Perkembangan Hafalan
                            Semua Santri
                        </h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light border dropdown-toggle px-3 rounded-pill" type="button"
                                data-bs-toggle="dropdown">
                                Periode: <span
                                    class="fw-semibold"><?= ucwords(str_replace('_', ' ', $periode)); ?></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li><a class="dropdown-item small <?= ($periode == 'minggu_ini') ? 'active' : ''; ?>"
                                        href="<?= base_url('admin/dashboard?periode=minggu_ini'); ?>">Minggu Ini</a>
                                </li>
                                <li><a class="dropdown-item small <?= ($periode == 'bulan_ini') ? 'active' : ''; ?>"
                                        href="<?= base_url('admin/dashboard?periode=bulan_ini'); ?>">Bulan Ini</a></li>
                                <li><a class="dropdown-item small <?= ($periode == 'tahun_ini') ? 'active' : ''; ?>"
                                        href="<?= base_url('admin/dashboard?periode=tahun_ini'); ?>">Tahun Ini</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Canvas untuk Chart.js -->
                    <div style="position: relative; height: 280px; width: 100%;">
                        <canvas id="grafikDashboardAdmin"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Menu Pintasan -->
        <div class="col-lg-4">
            <div
                class="card border-0 shadow-sm rounded-4 bg-success text-white h-100 position-relative overflow-hidden">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-white bg-opacity-25 p-3 rounded-3 text-white me-3">
                                <i class="fa-solid fa-bolt fa-lg"></i>
                            </div>
                            <h5 class="fw-bold m-0 text-white"
                                style="text-transform: none !important; font-size: 18px;">Menu Pintasan
                            </h5>
                        </div>
                        <p class="small text-white-50 mb-4" style="text-transform: none !important;">Akses cepat fitur
                            utama administrasi pesantren tanpa harus mencari di menu sidebar.</p>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="<?= base_url('admin/santri') ?>"
                            class="btn btn-light text-success fw-semibold rounded-3 py-2 text-start px-3 shadow-sm d-flex align-items-center justify-content-between"
                            style="text-transform: none !important;">
                            <span><i class="fa-solid fa-user-graduate me-2 text-success"></i> Kelola Data Santri</span>
                            <i class="fa-solid fa-arrow-right small"></i>
                        </a>
                        <a href="<?= base_url('admin/hafalan') ?>"
                            class="btn btn-light text-success fw-semibold rounded-3 py-2 text-start px-3 shadow-sm d-flex align-items-center justify-content-between"
                            style="text-transform: none !important;">
                            <span><i class="fa-solid fa-receipt me-2 text-success"></i> Data Hafalan Santri</span>
                            <i class="fa-solid fa-arrow-right small"></i>
                        </a>
                        <a href="<?= base_url('admin/ustadz') ?>"
                            class="btn btn-light text-success fw-semibold rounded-3 py-2 text-start px-3 shadow-sm d-flex align-items-center justify-content-between"
                            style="text-transform: none !important;">
                            <span><i class="fa-solid fa-chalkboard-user me-2 text-success"></i> Data Ustadz &
                                Kelas</span>
                            <i class="fa-solid fa-arrow-right small"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sertakan Script Chart.js (Pastikan CDN Chart.js sudah ada di header/footer layout utama anda) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('grafikDashboardAdmin').getContext('2d');

        // Data dari Controller PHP
        const chartLabels = <?= json_encode($grafik_data['labels']); ?>;
        const chartValues = <?= json_encode($grafik_data['values']); ?>;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Jumlah Santri Menyetor',
                    data: chartValues,
                    borderColor: '#198754', // Warna hijau nuansa pesantren
                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                    pointRadius: 3,
                    pointBackgroundColor: '#198754'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.04)'
                        },
                        ticks: {
                            stepSize: 1,
                            precision: 0,
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
    </script>

    <?= $this->endSection() ?>