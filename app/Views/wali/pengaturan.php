<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$wali = $wali ?? [];
?>

<div class="container-fluid px-0">

    <!-- Flash Message Floating -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080; max-width: 400px;">
        <!-- Alert Success -->
        <?php if (session()->getFlashdata('success')): ?>
            <div id="flash-alert-success"
                class="alert alert-success fade show rounded-4 shadow-lg border-0 d-flex align-items-center p-3 mb-2 position-relative"
                role="alert">
                <div class="d-flex align-items-center flex-grow-1 pe-4">
                    <div class="text-success fs-5 me-3 flex-shrink-0">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <span class="fw-bold d-block text-success mb-0">Berhasil!</span>
                        <span class="text-secondary small"
                            style="font-size: 12px;"><?= session()->getFlashdata('success'); ?></span>
                    </div>
                </div>
                <button type="button" class="btn-close position-absolute top-0 end-0 mt-3 me-3 shadow-none"
                    style="font-size: 10px; width: 20px; height: 20px;" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Alert Error -->
        <?php if (session()->getFlashdata('error')): ?>
            <div id="flash-alert-error"
                class="alert alert-danger fade show rounded-4 shadow-lg border-0 d-flex align-items-center p-3 mb-2 position-relative"
                role="alert">
                <div class="d-flex align-items-center flex-grow-1 pe-4">
                    <div class="text-danger fs-5 me-3 flex-shrink-0">
                        <i class="fa fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <span class="fw-bold d-block text-danger mb-0">Gagal!</span>
                        <span class="text-secondary small"
                            style="font-size: 12px;"><?= session()->getFlashdata('error'); ?></span>
                    </div>
                </div>
                <button type="button" class="btn-close position-absolute top-0 end-0 mt-2 me-2 shadow-none"
                    style="font-size: 8px; width: 16px; height: 16px;" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Page Header -->
    <div class="mb-4">
        <h3 class="fw-bold text-dark-mode mb-1" style="text-transform: none !important;">Pengaturan Akun Wali Santri
        </h3>
        <p class="text-secondary mb-0 small" style="text-transform: none !important;">Kelola informasi kontak orang tua,
            informasi ananda, dan sandi portal wali.</p>
    </div>

    <div class="row g-4">
        <!-- Sidebar Menu / Tabs -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-body p-2">
                    <div class="nav flex-column nav-pills gap-1" id="settingsWaliTab" role="tablist">
                        <button class="nav-link active text-start py-2 px-3 rounded-3 small fw-semibold"
                            id="w-profile-tab" data-bs-toggle="pill" data-bs-target="#w-profile" type="button"
                            role="tab">
                            <i class="fa-solid fa-user-shield me-2 text-success"></i> Profil Orang Tua
                        </button>
                        <button class="nav-link text-start py-2 px-3 rounded-3 small fw-semibold text-dark"
                            id="w-student-tab" data-bs-toggle="pill" data-bs-target="#w-student" type="button"
                            role="tab">
                            <i class="fa-solid fa-child-reaching me-2 text-success"></i> Data Ananda
                        </button>
                        <button class="nav-link text-start py-2 px-3 rounded-3 small fw-semibold text-dark"
                            id="w-security-tab" data-bs-toggle="pill" data-bs-target="#w-security" type="button"
                            role="tab">
                            <i class="fa-solid fa-key me-2 text-success"></i> Keamanan Sandi
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="col-lg-9">

            <div class="tab-content" id="settingsWaliTabContent">

                <!-- Tab 1: Profil Orang Tua -->
                <div class="tab-pane fade show active" id="w-profile" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 bg-white">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark-mode mb-3" style="text-transform: none !important;">Informasi
                                Kontak Wali Santri</h5>
                            <p class="text-secondary small mb-4">Pastikan nomor WhatsApp dan email aktif untuk menerima
                                laporan hafalan & tagihan.</p>

                            <form action="<?= base_url('wali/pengaturan/update-profile'); ?>" method="POST">
                                <?= csrf_field(); ?>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold text-dark-mode">Nama Ayah / Bunda /
                                            Wali</label>
                                        <input type="text" name="nama_wali"
                                            class="form-control form-control-sm bg-light border-0 py-2"
                                            value="<?= esc($wali['nama_wali'] ?? ''); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold text-dark-mode">Nomor
                                            WhatsApp</label>
                                        <input type="text" name="no_hp"
                                            class="form-control form-control-sm bg-light border-0 py-2"
                                            value="<?= esc($wali['no_hp'] ?? ''); ?>" required>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label small fw-semibold text-dark-mode">Alamat Rumah
                                        Domisili</label>
                                    <textarea name="alamat" class="form-control bg-light border-0" rows="3"
                                        required><?= esc($wali['alamat'] ?? ''); ?></textarea>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit"
                                        class="btn btn-success btn-sm px-4 rounded-pill shadow-sm">Simpan
                                        Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Data Ananda -->
                <div class="tab-pane fade" id="w-student" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 bg-white">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark-mode mb-3" style="text-transform: none !important;">Informasi
                                Ananda (Santri Terhubung)</h5>
                            <p class="text-secondary small mb-4">Data santri yang terhubung dengan akun portal wali
                                Anda.</p>

                            <?php if (!empty($list_santri)): ?>
                                <?php foreach ($list_santri as $santri): ?>
                                    <?php
                                    $fotoSantri = $santri['foto'] ?? '';
                                    $pathFoto = FCPATH . 'uploads/santri/' . $fotoSantri;

                                    if (!empty($fotoSantri) && file_exists($pathFoto)) {
                                        $urlSantri = base_url('uploads/santri/' . $fotoSantri);
                                        $tampilkanFoto = true;
                                    } else {
                                        $tampilkanFoto = false;
                                    }
                                    ?>

                                    <div class="p-3 bg-light rounded-4 mb-3 d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">

                                            <?php if ($tampilkanFoto): ?>
                                                <img src="<?= $urlSantri; ?>" alt="<?= esc($santri['nama_santri']); ?>"
                                                    class="rounded-circle object-fit-cover border shadow-sm"
                                                    style="width: 45px; height: 45px;">
                                            <?php else: ?>
                                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                                    style="width: 45px; height: 45px;">
                                                    <?= strtoupper(substr($santri['nama_santri'], 0, 2)); ?>
                                                </div>
                                            <?php endif; ?>

                                            <div>
                                                <h6 class="fw-semibold text-dark mb-1" style="font-size: 0.95rem;">
                                                    <?= esc($santri['nama_santri']); ?>
                                                </h6>
                                                <small class="text-muted">NIS: <?= esc($santri['nis']); ?> • Kelas
                                                    <?= esc($santri['nama_kelas'] ?? '-'); ?></small>
                                            </div>
                                        </div>
                                        <span
                                            class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill small">Terhubung</span>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center py-4 text-muted small">Belum ada data santri/ananda yang terhubung
                                    dengan akun Anda.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Keamanan -->
                <div class="tab-pane fade" id="w-security" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 bg-white">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark-mode mb-3" style="text-transform: none !important;">Keamanan
                                Portal Wali</h5>
                            <p class="text-secondary small mb-4">Ganti kata sandi akun portal wali Anda.</p>

                            <form action="<?= base_url('wali/pengaturan/update-password'); ?>" method="POST">
                                <?= csrf_field(); ?>
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-dark-mode">Kata Sandi Saat
                                        Ini</label>
                                    <input type="password" name="current_password"
                                        class="form-control form-control-sm bg-light border-0 py-2"
                                        placeholder="••••••••••••" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-dark-mode">Kata Sandi Baru</label>
                                    <input type="password" name="new_password"
                                        class="form-control form-control-sm bg-light border-0 py-2"
                                        placeholder="Minimal 8 karakter" required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label small fw-semibold text-dark-mode">Konfirmasi Kata Sandi
                                        Baru</label>
                                    <input type="password" name="confirm_password"
                                        class="form-control form-control-sm bg-light border-0 py-2"
                                        placeholder="Ulangi sandi baru" required>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit"
                                        class="btn btn-success btn-sm px-4 rounded-pill shadow-sm">Perbarui Kata
                                        Sandi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>