<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Page Header -->
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-1" style="text-transform: none !important;">Pengaturan Akun Wali Santri</h3>
        <p class="text-muted mb-0 small" style="text-transform: none !important;">Kelola informasi kontak orang tua, informasi ananda, dan sandi portal wali.</p>
    </div>

    <div class="row g-4">
        <!-- Sidebar Menu / Tabs -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-body p-2">
                    <div class="nav flex-column nav-pills gap-1" id="settingsWaliTab" role="tablist">
                        <button class="nav-link active text-start py-2 px-3 rounded-3 small fw-semibold" id="w-profile-tab" data-bs-toggle="pill" data-bs-target="#w-profile" type="button" role="tab">
                            <i class="fa-solid fa-user-shield me-2 text-success"></i> Profil Orang Tua
                        </button>
                        <button class="nav-link text-start py-2 px-3 rounded-3 small fw-semibold text-dark" id="w-student-tab" data-bs-toggle="pill" data-bs-target="#w-student" type="button" role="tab">
                            <i class="fa-solid fa-child-reaching me-2 text-success"></i> Data Ananda
                        </button>
                        <button class="nav-link text-start py-2 px-3 rounded-3 small fw-semibold text-dark" id="w-security-tab" data-bs-toggle="pill" data-bs-target="#w-security" type="button" role="tab">
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
                            <h5 class="fw-bold text-dark mb-3" style="text-transform: none !important;">Informasi Kontak Wali Santri</h5>
                            <p class="text-muted small mb-4">Pastikan nomor WhatsApp dan email aktif untuk menerima laporan hafalan & tagihan.</p>

                            <form>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold text-dark">Nama Ayah / Bunda / Wali</label>
                                        <input type="text" class="form-control form-control-sm bg-light border-0 py-2" value="Bapak Abdullah & Ibu Siti">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold text-dark">Nomor WhatsApp (Penerima Notifikasi)</label>
                                        <input type="text" class="form-control form-control-sm bg-light border-0 py-2" value="081987654321">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label small fw-semibold text-dark">Alamat Rumah Domisili</label>
                                    <textarea class="form-control bg-light border-0" rows="3">Jl. Mawar Indah Blok B2 No. 12, Depok, Jawa Barat</textarea>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm px-4 rounded-pill shadow-sm">Simpan Kontak</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Data Ananda -->
                <div class="tab-pane fade" id="w-student" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 bg-white">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-3" style="text-transform: none !important;">Informasi Santri (Anak Terhubung)</h5>
                            <p class="text-muted small mb-4">Data santri yang terhubung dengan akun portal wali Anda.</p>

                            <div class="p-3 bg-light rounded-4 mb-3 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 45px; height: 45px;">
                                        AZ
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold text-dark mb-1" style="font-size: 0.95rem;">Ahmad Zaki Al-Faruq</h6>
                                        <small class="text-muted">NIS: 202401001 • Kelas 8A Tsanawiyah</small>
                                    </div>
                                </div>
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill small">Terhubung</span>
                            </div>
                            <small class="text-muted"><i class="fa-solid fa-circle-info me-1"></i> Jika Anda memiliki lebih dari satu anak di pesantren ini, silakan hubungi bagian administrasi untuk penautan akun ganda.</small>
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Keamanan -->
                <div class="tab-pane fade" id="w-security" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 bg-white">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-3" style="text-transform: none !important;">Keamanan Portal Wali</h5>
                            <p class="text-muted small mb-4">Ganti kata sandi akun portal wali Anda.</p>

                            <form>
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-dark">Kata Sandi Saat Ini</label>
                                    <input type="password" class="form-control form-control-sm bg-light border-0 py-2" placeholder="••••••••••••">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-dark">Kata Sandi Baru</label>
                                    <input type="password" class="form-control form-control-sm bg-light border-0 py-2" placeholder="Minimal 8 karakter">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label small fw-semibold text-dark">Konfirmasi Kata Sandi Baru</label>
                                    <input type="password" class="form-control form-control-sm bg-light border-0 py-2" placeholder="Ulangi sandi baru">
                                </div>
                                <button type="submit" class="btn btn-success btn-sm px-4 rounded-pill shadow-sm">Perbarui Kata Sandi</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>