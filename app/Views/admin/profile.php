<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$user = $user ?? [];
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
                        <span class="text-secondary small" style="font-size: 12px;">
                            <?= session()->getFlashdata('success'); ?>
                        </span>
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
                        <span class="text-secondary small" style="font-size: 12px;">
                            <?= session()->getFlashdata('error'); ?>
                        </span>
                    </div>
                </div>
                <button type="button" class="btn-close position-absolute top-0 end-0 mt-2 me-2 shadow-none"
                    style="font-size: 8px; width: 16px; height: 16px;" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Page Header -->
    <div class="mb-4">
        <h3 class="fw-bold text-dark-mode mb-1" style="text-transform: none !important;">Profil Saya
        </h3>
        <p class="text-secondary mb-0 small" style="text-transform: none !important;">Kelola profil Anda disini.</p>
    </div>

    <div class="row g-4">
        <!-- Kolom Kiri: Kartu Ringkasan Profil -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white text-center p-4">
                <div class="card-body">
                    <div class="position-relative d-inline-block mb-3">
                        <?php
                        $folderRelatif = FCPATH . 'uploads/profile/' . ($user['foto'] ?? '');
                        $adaFoto = !empty($user['foto']) && file_exists($folderRelatif);
                        ?>

                        <?php if ($adaFoto): ?>
                            <img src="<?= base_url('uploads/profile/' . $user['foto']) ?>"
                                class="rounded-circle shadow-sm object-fit-cover" style="width: 100px; height: 100px;"
                                alt="Foto Profil">
                        <?php else: ?>
                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center fw-bold fs-2 mx-auto shadow-sm"
                                style="width: 100px; height: 100px;">
                                <?= strtoupper(substr($user['name'], 0, 2)) ?>
                            </div>
                        <?php endif; ?>
                        <!-- <span
                            class="position-absolute bottom-0 end-0 p-2 bg-success border border-light rounded-circle">
                            <span class="visually-hidden">Active</span>
                        </span> -->
                    </div>
                    <h5 class="fw-bold text-dark-mode mb-1">
                        <?= esc($user['name']) ?>
                    </h5>
                    <p class="text-secondary font-monospace small mb-3">
                        @<?= esc($user['username']) ?>
                    </p>
                    <span
                        class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-semibold text-uppercase small">
                        <i class="fa-solid fa-shield-halved me-1"></i>
                        <?= esc($user['role']) ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Form Edit Profil & Keamanan -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark-mode mb-1" style="text-transform: none !important;">Pengaturan Akun
                    </h5>
                    <p class="text-secondary small mb-4">Perbarui informasi data diri, username, dan keamanan kata sandi
                        akun
                        Anda.</p>

                    <form action="<?= base_url('admin/profile/update') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <!-- Upload Foto -->
                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-dark-mode">Foto Profil</label>
                            <input type="file" class="form-control form-control-sm bg-light border-0 py-2" name="foto"
                                accept=".jpg, .jpeg, .png">
                            <small class="text-secondary d-block mt-1">Format yang diizinkan: JPG, JPEG, PNG. Maksimal
                                ukuran
                                2MB.</small>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark-mode">Nama Lengkap</label>
                                <input type="text"
                                    class="form-control form-control-sm bg-light border-0 py-2 <?= session('errors.name') ? 'is-invalid' : '' ?>"
                                    name="name" value="<?= old('name', $user['name']) ?>" required>
                                <div class="invalid-feedback">
                                    <?= session('errors.name') ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark-mode">Username</label>
                                <input type="text"
                                    class="form-control form-control-sm bg-light border-0 py-2 <?= session('errors.username') ? 'is-invalid' : '' ?>"
                                    name="username" value="<?= old('username', $user['username']) ?>" required>
                                <div class="invalid-feedback">
                                    <?= session('errors.username') ?>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success btn-sm px-4 rounded-pill shadow-sm py-2 mt-2">
                                <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>