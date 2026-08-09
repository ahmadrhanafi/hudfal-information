<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

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
        <h3 class="fw-bold text-dark mb-1" style="text-transform: none !important;">Pengaturan Sistem & Profil Admin
        </h3>
        <p class="text-muted mb-0 small" style="text-transform: none !important;">Kelola konfigurasi umum aplikasi
            pesantren, profil admin, dan keamanan akun.</p>
    </div>

    <div class="row g-4">
        <!-- Sidebar Menu / Tabs -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-body p-2">
                    <div class="nav flex-column nav-pills gap-1" id="settingsTab" role="tablist">
                        <button class="nav-link active text-start py-2 px-3 rounded-3 small fw-semibold"
                            id="general-tab" data-bs-toggle="pill" data-bs-target="#general" type="button" role="tab">
                            <i class="fa-solid fa-sliders me-2 text-success"></i> Konfigurasi Umum
                        </button>
                        <button class="nav-link text-start py-2 px-3 rounded-3 small fw-semibold text-dark"
                            id="security-tab" data-bs-toggle="pill" data-bs-target="#security" type="button" role="tab">
                            <i class="fa-solid fa-shield-halved me-2 text-success"></i> Keamanan & Sandi
                        </button>
                        <button class="nav-link text-start py-2 px-3 rounded-3 small fw-semibold text-dark"
                            id="backup-tab" data-bs-toggle="pill" data-bs-target="#backup" type="button" role="tab">
                            <i class="fa-solid fa-database me-2 text-success"></i> Backup Database
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="col-lg-9">
            <div class="tab-content" id="settingsTabContent">

                <!-- Tab 1: Konfigurasi Umum -->
                <div class="tab-pane fade show active" id="general" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 bg-white">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-3" style="text-transform: none !important;">Pengaturan
                                Sistem Pesantren</h5>
                            <p class="text-muted small mb-4">Ubah identitas aplikasi, tahun ajaran aktif, dan
                                konfigurasi lembaga.</p>

                            <form>
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-dark">Nama Pesantren /
                                        Lembaga</label>
                                    <input type="text" class="form-control form-control-sm bg-light border-0 py-2"
                                        value="Pesantren Al-Hidayah Digital">
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold text-dark">Tahun Ajaran Aktif</label>
                                        <select class="form-select form-select-sm bg-light border-0 py-2">
                                            <option selected>2026/2027 Ganjil</option>
                                            <option value="2025/2026">2025/2026 Genap</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold text-dark">Zona Waktu</label>
                                        <select class="form-select form-select-sm bg-light border-0 py-2">
                                            <option selected>WIB (Waktu Indonesia Barat)</option>
                                            <option value="wita">WITA</option>
                                            <option value="wit">WIT</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label small fw-semibold text-dark">Alamat Resmi Pesantren</label>
                                    <textarea class="form-control bg-light border-0"
                                        rows="3">Jl. Pesantren Al-Hidayah No. 10, Parung, Bogor, Jawa Barat</textarea>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm px-4 rounded-pill shadow-sm">Simpan
                                    Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Keamanan -->
                <div class="tab-pane fade" id="security" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 bg-white">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-3" style="text-transform: none !important;">Keamanan Akun
                            </h5>
                            <p class="text-muted small mb-4">Ganti kata sandi secara berkala untuk menjaga keamanan
                                sistem.</p>

                            <form>
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-dark">Kata Sandi Saat Ini</label>
                                    <input type="password" class="form-control form-control-sm bg-light border-0 py-2"
                                        placeholder="••••••••••••">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-dark">Kata Sandi Baru</label>
                                    <input type="password" class="form-control form-control-sm bg-light border-0 py-2"
                                        placeholder="Minimal 8 karakter">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label small fw-semibold text-dark">Konfirmasi Kata Sandi
                                        Baru</label>
                                    <input type="password" class="form-control form-control-sm bg-light border-0 py-2"
                                        placeholder="Ulangi kata sandi baru">
                                </div>
                                <button type="submit"
                                    class="btn btn-success btn-sm px-4 rounded-pill shadow-sm">Perbarui Sandi</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Backup -->
                <div class="tab-pane fade" id="backup" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 bg-white">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-3" style="text-transform: none !important;">Cadangkan Data
                                (Backup)</h5>
                            <p class="text-muted small mb-4">Unduh salinan basis data sistem untuk mengantisipasi
                                kehilangan data.</p>

                            <div class="p-3 bg-light rounded-4 mb-4 d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-semibold text-dark mb-1" style="font-size: 0.9rem;">Backup Database
                                        SQL Lengkap</h6>
                                    <small class="text-muted">Terakhir dicadangkan: 20 Juli 2026</small>
                                </div>
                                <button class="btn btn-success btn-sm px-3 rounded-pill shadow-sm">Unduh SQL</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>