<?= $this->extend('layout/main') ?>

<?php
/**
 * @var string $nama_kelas
 * @var string $periode
 * @var float|int $rata_setoran
 * @var array $juz_dominan
 * @var array $predikat_umum
 * @var array $capaian_juz
 * @var array $grafik_setoran
 */
?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1" style="text-transform: none !important;">Statistik Hafalan Santri Binaan</h3>
            <p class="text-muted mb-0 small" style="text-transform: none !important;">Analisis grafik perkembangan setoran dan rata-rata hafalan santri.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <?php $currentPeriode = $_GET['periode'] ?? 'bulan_ini'; ?>
            <a href="<?= base_url('guru/statistik-hafalan/export?periode=' . $currentPeriode); ?>" class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm" style="text-transform: none !important;">
                <i class="fa-solid fa-download text-success me-1"></i> Unduh Laporan
            </a>

            <div class="dropdown">
                <button class="btn btn-success btn-sm px-3 rounded-pill shadow-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" style="text-transform: none !important;">
                    <i class="fa-solid fa-filter me-1"></i> Periode:
                    <?= ($currentPeriode == 'minggu_ini') ? 'Minggu Ini' : (($currentPeriode == 'semester_ini') ? 'Semester Ini' : 'Bulan Ini'); ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                    <li><a class="dropdown-item small <?= ($currentPeriode == 'minggu_ini') ? 'active' : ''; ?>" href="<?= base_url('guru/statistik-hafalan?periode=minggu_ini'); ?>">Minggu Ini</a></li>
                    <li><a class="dropdown-item small <?= ($currentPeriode == 'bulan_ini') ? 'active' : ''; ?>" href="<?= base_url('guru/statistik-hafalan?periode=bulan_ini'); ?>">Bulan Ini</a></li>
                    <li><a class="dropdown-item small <?= ($currentPeriode == 'semester_ini') ? 'active' : ''; ?>" href="<?= base_url('guru/statistik-hafalan?periode=semester_ini'); ?>">Semester Ini</a></li>
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
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">RATA-RATA SETORAN KELAS</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">
                            <?= esc((string) ($rata_setoran ?? 0)); ?> <span class="fs-6 fw-normal text-muted">Ayat / Hari</span>
                        </h3>
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
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">JUZ DOMINAN KELAS</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">
                            <?= esc($juz_dominan['nama'] ?? 'Juz 30'); ?>
                            <span class="fs-6 fw-normal text-success">(<?= esc($juz_dominan['persentase'] ?? 0); ?>%)</span>
                        </h3>
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
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">PREDIKAT TERBANYAK</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">
                            <?= esc($predikat_umum['predikat'] ?? 'Mumtaz'); ?>
                            <span class="fs-6 fw-normal text-muted">(<?= esc($predikat_umum['keterangan'] ?? 'Sangat Baik'); ?>)</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik & Breakdown Bagian Bawah -->
    <div class="row g-4">
        <!-- Grafik Utama dengan Chart.js -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="fw-bold text-dark m-0" style="text-transform: none !important;">
                            <i class="fa-solid fa-chart-area text-success me-2"></i> Grafik Progres Hafalan Kelas Binaan
                        </h5>
                        <span class="badge bg-light text-secondary border"><?= esc($nama_kelas); ?></span>
                    </div>

                    <!-- Elemen Canvas untuk Chart.js -->
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="grafikKelasChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Berdasarkan Juz (Kelas Binaan) -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-4" style="text-transform: none !important;">
                        <i class="fa-solid fa-layer-group text-success me-2"></i> Capaian Juz Kelas
                    </h5>

                    <?php if (!empty($capaian_juz)): ?>
                        <?php
                        $colors = ['bg-success', 'bg-primary', 'bg-warning', 'bg-info', 'bg-secondary'];
                        $i = 0;
                        foreach ($capaian_juz as $row):
                            $bgClass = $colors[$i % count($colors)];
                            $persen = ($row['jumlah'] * 15 > 100) ? 100 : $row['jumlah'] * 15;
                            $i++;
                        ?>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between small fw-semibold mb-1">
                                    <span class="text-dark">Juz <?= esc($row['juz']); ?></span>
                                    <!-- TAMBAHKAN KODE INI SUPAYA ANGKA PERSENTASE MUNCUL -->
                                    <span class="text-muted">
                                        <?= esc($row['jumlah']); ?> Setoran
                                        <span class="fw-bold text-success">(<?= $persen; ?>%)</span>
                                    </span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar <?= $bgClass; ?> rounded-pill" role="progressbar" style="width: <?= $persen; ?>%;"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center text-muted py-4 small">
                            <i class="fa-solid fa-info-circle mb-2 fa-lg"></i>
                            <p class="mb-0">Belum ada data capaian juz untuk kelas ini.</p>
                        </div>
                    <?php endif; ?>

                    <div class="mt-4 pt-2 text-center">
                        <small class="text-muted">Persentase dihitung dari total target hafalan kelas binaan aktif.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
            <h5 class="fw-bold text-dark mb-1" style="text-transform: none !important; font-size: 1.05rem;">Rekapitulasi Setoran Santri</h5>
            <p class="text-muted small mb-3">Data rekapitulasi setoran hafalan santri.</p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Santri</th>
                            <th>Total Setoran</th>
                            <th>Rata-rata Ayat</th>
                            <th>Juz Terakhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Lakukan looping data rekap per santri di sini -->
                        <?php if (!empty($rekap_santri)): ?>
                            <?php $no = 1;
                            foreach ($rekap_santri as $santri): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= esc($santri['nama_santri'] ?? '-'); ?></td>
                                    <td><?= esc($santri['total_setoran'] ?? 0); ?> Ayat</td>
                                    <td><?= round($santri['rata_ayat'], 1); ?> Ayat</td>
                                    <td>Juz <?= esc($santri['juz_terakhir'] ?? '-'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr></tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fa-solid fa-info-circle mb-2 fa-lg"></i>
                                <p class="mb-0">Belum ada data setoran santri untuk periode ini.</p>
                            </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Pastikan Chart.js sudah ter-load di layout utama (main.php). Jika belum, include CDN-nya -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const rawData = <?= json_encode($grafik_setoran ?? []); ?>;

        // Mapping data dari PHP ke format Chart.js
        const labels = rawData.map(item => item.created_at ? new Date(item.created_at).toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        }) : '-');
        const dataValues = rawData.map(item => item.total);

        const ctx = document.getElementById('grafikKelasChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels.length > 0 ? labels : ['Belum ada data'],
                datasets: [{
                    label: 'Jumlah Setoran Hafalan',
                    data: dataValues.length > 0 ? dataValues : [0],
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
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
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>