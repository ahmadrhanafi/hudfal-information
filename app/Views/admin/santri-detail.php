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
            <h3 class="fw-bold text-dark-mode mb-1"><i
                    class="fa-solid fa-id-card-clip text-success me-2"></i><?= esc($santri['nama_santri']); ?></h3>
            <p class="text-secondary small mb-0">Informasi profil lengkap santri.</p>
        </div>
        <div>
            <a href="<?= base_url('admin/santri'); ?>"
                class="btn btn-sm px-3 py-2 rounded-pill border-0 fw-semibold bg-success bg-opacity-10 text-success shadow-sm hover-bg-success">
                <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Daftar
            </a>
        </div>
    </div>

    <?php
    $tglLahir = $santri['tanggal_lahir'] ? date('d', strtotime($santri['tanggal_lahir'])) . ' ' . ['01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agu', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des']
    [date('m', strtotime($santri['tanggal_lahir']))] . ' ' . date('Y', strtotime($santri['tanggal_lahir'])) : '-';
    ?>

    <div class="row g-4">
        <!-- Kolom Kiri: Pratinjau E-Kartu Santri (Digital ID Card) -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
                <div
                    class="card-header bg-success text-white py-3 px-4 d-flex justify-content-between align-items-center">
                    <span class="fw-semibold small tracking-wider text-uppercase"><i class="fa-solid id-card me-1"></i>
                        E-Kartu Santri</span>
                    <span class="badge bg-white text-success px-2 py-1 fw-bold" style="font-size: 10px;">AKTIF</span>
                </div>

                <div class="card-body bg-success bg-opacity-25 border-2 border-success p-4 text-center">
                    <!-- Pratinjau E-Card Menggunakan Gambar Desain Asli -->
                    <div class="position-relative overflow-hidden shadow-sm mb-4 rounded-4 mx-auto"
                        style="width: 100%; max-width: 380px; aspect-ratio: 1.58 / 1; background-color: #198754;">

                        <!-- Background Kartu Depan (Otomatis pakai base64 jika dicetak, atau langsung file lokal via base_url saat di web) -->
                        <img src="<?= !empty($base64ImgDepan) ? $base64ImgDepan : base_url('assets/img/depan_kartu.png'); ?>"
                            alt="Desain Kartu Depan"
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 1;"
                            onerror="this.style.display='none';">

                        <!-- Foto Santri -->
                        <?php if (!empty($santri['foto'])): ?>
                            <div
                                style="position: absolute; top: 32%; left: 5%; width: 22%; height: 50%; border-radius: 4px; overflow: hidden; z-index: 2; background: #ddd;">
                                <img src="<?= !empty($base64FotoSantri) ? $base64FotoSantri : base_url('uploads/santri/' . $santri['foto']); ?>"
                                    alt="Foto Santri" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        <?php endif; ?>

                        <div
                            style="position: absolute; top: 43.5%; left: 54%; z-index: 2; font-weight: 500; font-size: 8px; color: #07328f; text-align: left; white-space: nowrap;">
                            <?= esc($santri['nama_santri'] ?? ''); ?>
                        </div>

                        <div
                            style="position: absolute; top: 51.3%; left: 54%; z-index: 2; font-weight: 500; font-size: 8px; font-family: monospace; color: #07328f; text-align: left;">
                            <?= esc($santri['nis'] ?? ''); ?>
                        </div>

                        <div
                            style="position: absolute; top: 58.2%; left: 54%; z-index: 2; font-weight: 500; font-size: 8px; color: #07328f; text-align: left;">
                            <?= esc(($santri['tempat_lahir'] ?? '-') . ', ' . ($santri['tanggal_lahir'] ?? '-')); ?>
                        </div>

                        <div
                            style="position: absolute; top: 65.5%; left: 54%; z-index: 2; font-weight: 500; font-size: 8px; color: #07328f; text-align: left;">
                            <?= esc($santri['no_hp_wali'] ?? '-'); ?>
                        </div>

                        <div
                            style="position: absolute; top: 72.6%; left: 54%; z-index: 2; font-weight: 500; font-size: 8px; color: #07328f; text-align: left; max-width: 60%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <?= esc($santri['alamat_wali'] ?? '-'); ?>
                        </div>
                    </div>

                    <!-- Tombol Aksi Kartu -->
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('admin/santri/cetakKartu/' . $santri['id']); ?>"
                            class="btn btn-success rounded-3 py-2 fw-semibold shadow-sm" target="_blank">
                            <i class="fa-solid fa-print me-1"></i> Cetak E-Kartu Santri
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Detail Informasi Akademik & Wali -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
                <div
                    class="card-header bg-success rounded-top-4 py-3 px-4 border-0 d-flex align-items-center justify-content-between">
                    <h5 class="card-title fw-semibold mb-1 text-white"
                        style="text-transform: none !important; font-size: 1.05rem;">Rincian Data Santri & Wali</h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-secondary w-30 py-3">Nomor Induk Santri (NIS)</td>
                                    <td class="fw-bold text-dark-mode py-3">: <span
                                            class="font-monospace"><?= esc($santri['nis']); ?></span></td>
                                </tr>
                                <tr>
                                    <td class="text-secondary py-3">Nama Lengkap Santri</td>
                                    <td class="fw-bold text-dark-mode py-3">: <?= esc($santri['nama_santri']); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-secondary py-3">Tempat, Tanggal Lahir</td>
                                    <td class="fw-bold text-dark-mode py-3">:
                                        <?= esc($santri['tempat_lahir'] ?? '-'); ?>, <?= $tglLahir; ?>
                                    </td>
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
                                <tr>
                                    <td colspan="2" class="p-0">
                                        <hr class="my-2 text-secondary opacity-25">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-secondary py-3">Nama Wali Santri</td>
                                    <td class="fw-bold text-dark-mode py-3">:
                                        <?= esc($santri['nama_wali'] ?? 'Belum ada wali'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-secondary py-3">No. HP / WhatsApp Wali</td>
                                    <td class="fw-semibold py-3">:
                                        <?php if (!empty($santri['no_hp_wali'])): ?>
                                            <a href="https://wa.me/<?= esc($santri['no_hp_wali']); ?>" target="_blank"
                                                class="text-decoration-none text-success fw-bold">
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
                <div
                    class="card-footer bg-success py-3 px-4 border-0 d-flex align-items-center justify-content-between rounded-bottom-4">
                    <span class="text-white small">
                        <i class="fa-solid fa-clock-rotate-left me-1"></i> Terakhir diperbarui oleh sistem
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>