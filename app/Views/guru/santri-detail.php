<?php

/**
 * @var string $title
 * @var array $santri
 */
?>

<?= $this->extend('layout/main'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1 class="h3 text-dark fw-bold mb-1"><?= esc($title); ?></h1>
            <p class="text-muted small mb-0">Detail informasi lengkap untuk data santri.</p>
        </div>
        <a href="<?= base_url('guru/santri'); ?>" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        <!-- Informasi Utama Santri -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center py-4">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px; font-size: 32px;">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-1"><?= esc($santri['nama_santri']); ?></h4>
                    <p class="text-muted mb-3 font-monospace">NIS: <?= esc($santri['nis']); ?></p>

                    <?php if ($santri['jenis_kelamin'] == 'L'): ?>
                        <span class="badge bg-info text-dark px-3 py-2">Laki-laki</span>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark px-3 py-2">Perempuan</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Detail Informasi & Relasi -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold text-dark mb-0">Informasi Akademik & Wali</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted w-25">Nomor Induk Santri</td>
                            <td class="fw-semibold">: <?= esc($santri['nis']); ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Nama Lengkap</td>
                            <td class="fw-semibold">: <?= esc($santri['nama_santri']); ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Jenis Kelamin</td>
                            <td class="fw-semibold">: <?= ($santri['jenis_kelamin'] == 'L') ? 'Laki-laki' : 'Perempuan'; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Kelas</td>
                            <td class="fw-semibold">: <span class="badge bg-success bg-opacity-10 text-success"><?= esc($santri['nama_kelas'] ?? 'Belum ada kelas'); ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Wali Santri</td>
                            <td class="fw-semibold">: <?= esc($santri['nama_wali'] ?? 'Belum ada wali'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">No. HP Wali</td>
                            <td class="fw-semibold">: <?= esc($santri['no_hp_wali'] ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Alamat Wali</td>
                            <td class="fw-semibold">: <?= esc($santri['alamat_wali'] ?? '-'); ?></td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer bg-light py-3 text-end">
                    <a href="<?= base_url('guru/santri'); ?>" class="btn btn-primary btn-sm px-4">Selesai</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>