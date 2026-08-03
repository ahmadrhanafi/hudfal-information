<?php

/**
 * @var string $title
 * @var array $santri
 */
?>

<?= $this->extend('layout/main'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4 py-3">

    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark-mode mb-1"><i class="fa-solid fa-id-card-clip text-success me-2"></i><?= esc($santri['nama_santri']); ?></h3>
            <p class="text-secondary small mb-0">Informasi profil lengkap <?= esc($santri['nama_santri']); ?>.</p>
        </div>
        <div>
            <a href="<?= base_url('guru/santri'); ?>" class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar
            </a>
        </div>
    </div>

    <div class="row g-4">

        <!-- Kolom Kiri: Pratinjau E-Kartu Santri (Digital ID Card) -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
                <div class="card-header bg-success text-white py-3 px-4 d-flex justify-content-between align-items-center">
                    <span class="fw-semibold small tracking-wider text-uppercase"><i class="fa-solid id-card me-1"></i> E-Kartu Santri</span>
                    <span class="badge bg-white text-success px-2 py-1 fw-bold" style="font-size: 10px;">AKTIF</span>
                </div>

                <div class="card-body p-4 text-center">
                    <!-- Desain Fisik E-Card Mini -->
                    <div class="p-4 rounded-4 text-white text-start position-relative overflow-hidden shadow-sm mb-4" style="background: linear-gradient(135deg, #198754 0%, #157347 100%);">
                        <!-- Watermark Icon Background -->
                        <div class="position-absolute opacity-10" style="right: -20px; bottom: -20px; font-size: 120px;">
                            <i class="fa-solid fa-graduation-cap opacity-25"></i>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="small fw-bold tracking-wider" style="font-size: 11px; opacity: 0.85;">PONDOK PESANTREN HUDATUL FALAH</span>
                            <i class="fa-solid fa-qrcode fs-3 text-white opacity-75"></i>
                        </div>

                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-white text-success rounded-circle d-flex align-items-center justify-content-center fw-bold fs-4 shadow-sm flex-shrink-0" style="width: 50px; height: 50px;">
                                <?= strtoupper(substr($santri['nama_santri'], 0, 1)); ?>
                            </div>
                            <div class="overflow-hidden">
                                <h6 class="fw-bold mb-0 text-truncate text-white"><?= esc($santri['nama_santri']); ?></h6>
                                <span class="small text-white-50 font-monospace" style="font-size: 12px;">NIS: <?= esc($santri['nis']); ?></span>
                            </div>
                        </div>

                        <div class="pt-2 border-top border-white border-opacity-25 d-flex justify-content-between align-items-center" style="font-size: 11px;">
                            <span>Kelas: <strong><?= esc($santri['nama_kelas'] ?? 'Belum ada'); ?></strong></span>
                            <span><?= ($santri['jenis_kelamin'] == 'L') ? 'Laki-laki' : 'Perempuan'; ?></span>
                        </div>
                    </div>

                    <!-- Tombol Aksi Kartu -->
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success rounded-3 py-2 fw-semibold shadow-sm" onclick="window.print();">
                            <i class="fa-solid fa-print me-1"></i> Cetak / Unduh E-Card
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Detail Informasi Akademik & Wali -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
                <div class="card-header bg-success rounded-top-4 py-3 px-4 border-0 d-flex align-items-center justify-content-between">
                    <h5 class="card-title fw-bold text-dark-mode mb-0">Rincian Data Santri & Wali</h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-secondary w-30 py-3">Nomor Induk Santri (NIS)</td>
                                    <td class="fw-bold text-dark-mode py-3">: <span class="font-monospace"><?= esc($santri['nis']); ?></span></td>
                                </tr>
                                <tr>
                                    <td class="text-secondary py-3">Nama Lengkap Santri</td>
                                    <td class="fw-bold text-dark-mode py-3">: <?= esc($santri['nama_santri']); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-secondary py-3">Jenis Kelamin</td>
                                    <td class="fw-semibold py-3">:
                                        <?php if ($santri['jenis_kelamin'] == 'L'): ?>
                                            <span class="text-dark-mode">Laki-laki</span>
                                        <?php else: ?>
                                            <span class="text-dark-mode">Perempuan</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-secondary py-3">Kelas Akademik</td>
                                    <td class="fw-semibold py-3">:
                                        <span class="text-dark-mode">
                                            <?= esc($santri['nama_kelas'] ?? 'Belum ada kelas'); ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="border-top">
                                    <td class="text-secondary py-3">Nama Wali Santri</td>
                                    <td class="fw-bold text-dark-mode py-3">: <?= esc($santri['nama_wali'] ?? 'Belum ada wali'); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-secondary py-3">No. HP / WhatsApp Wali</td>
                                    <td class="fw-semibold py-3">:
                                        <?php if (!empty($santri['no_hp_wali'])): ?>
                                            <a href="https://wa.me/<?= esc($santri['no_hp_wali']); ?>" target="_blank" class="text-decoration-none text-success fw-bold">
                                                <?= esc($santri['no_hp_wali']); ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-secondary py-3">Alamat Lengkap Wali</td>
                                    <td class="fw-semibold py-3">: <?= esc($santri['alamat_wali'] ?? '-'); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-success py-3 px-4 border-0 text-end rounded-bottom-4">
                    <a href="<?= base_url('guru/santri'); ?>" class="btn btn-secondary btn-sm bg-secondary bg-opacity-30 px-4 py-2 rounded-3 shadow-sm">Selesai</a>
                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection(); ?>