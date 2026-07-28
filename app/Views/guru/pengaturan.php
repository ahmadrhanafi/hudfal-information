<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Page Header -->
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-1" style="text-transform: none !important;">Pengaturan Akun Ustadz</h3>
        <p class="text-muted mb-0 small" style="text-transform: none !important;">Kelola informasi profil pengajar, jadwal mengajar, dan keamanan akun Anda.</p>
    </div>

    <div class="row g-4">
        <!-- Sidebar Menu / Tabs -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-body p-2">
                    <div class="nav flex-column nav-pills gap-1" id="settingsUstadzTab" role="tablist">
                        <button class="nav-link active text-start py-2 px-3 rounded-3 small fw-semibold" id="u-profile-tab" data-bs-toggle="pill" data-bs-target="#u-profile" type="button" role="tab">
                            <i class="fa-solid fa-user-pen me-2 text-success"></i> Profil Pengajar
                        </button>
                        <button class="nav-link text-start py-2 px-3 rounded-3 small fw-semibold text-dark" id="u-security-tab" data-bs-toggle="pill" data-bs-target="#u-security" type="button" role="tab">
                            <i class="fa-solid fa-lock me-2 text-success"></i> Ubah Kata Sandi
                        </button>
                        <button class="nav-link text-start py-2 px-3 rounded-3 small fw-semibold text-dark" id="u-notification-tab" data-bs-toggle="pill" data-bs-target="#u-notification" type="button" role="tab">
                            <i class="fa-solid fa-bell me-2 text-success"></i> Notifikasi Setoran
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="col-lg-9">
            <div class="tab-content" id="settingsUstadzTabContent">

                <!-- Tab 1: Profil Pengajar -->
                <div class="tab-pane fade show active" id="u-profile" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 bg-white">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-3" style="text-transform: none !important;">Informasi Profil Ustadz</h5>
                            <p class="text-muted small mb-4">Perbarui biodata dan nomor kontak resmi Anda.</p>

                            <form>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold text-dark">Nama Lengkap & Gelar</label>
                                        <input type="text" class="form-control form-control-sm bg-light border-0 py-2" value="Ustadz Ahmad Hidayat, Lc.">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold text-dark">Nomor WhatsApp / HP</label>
                                        <input type="text" class="form-control form-control-sm bg-light border-0 py-2" value="081234567890">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-dark">Kelas Binaan / Perwalian Utama</label>
                                    <input type="text" class="form-control form-control-sm bg-light border-0 py-2" value="Kelas 8A Tsanawiyah" readonly>
                                    <small class="text-muted">Hubungi admin jika terjadi kesalahan penugasan kelas.</small>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label small fw-semibold text-dark">Bio Singkat / Motto Mengajar</label>
                                    <textarea class="form-control bg-light border-0" rows="3">Mencetak generus qur'ani yang berakhlak mulia dan hafal Al-Qur'an.</textarea>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm px-4 rounded-pill shadow-sm">Simpan Profil</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Keamanan -->
                <div class="tab-pane fade" id="u-security" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 bg-white">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-3" style="text-transform: none !important;">Keamanan Akun Ustadz</h5>
                            <p class="text-muted small mb-4">Ganti kata sandi panel ustadz Anda.</p>

                            <form>
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-dark">Kata Sandi Lama</label>
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
                                <button type="submit" class="btn btn-success btn-sm px-4 rounded-pill shadow-sm">Perbarui Sandi</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Notifikasi -->
                <div class="tab-pane fade" id="u-notification" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 bg-white">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-3" style="text-transform: none !important;">Preferensi Notifikasi</h5>
                            <p class="text-muted small mb-4">Atur jenis pemberitahuan yang ingin Anda terima.</p>

                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="notif1" checked>
                                <label class="form-check-label small fw-semibold text-dark ms-2" for="notif1">Pengingat Jadwal Setoran Hafalan Harian</label>
                            </div>
                            <div class="form-check form-switch mb-4">
                                <input class="form-check-input" type="checkbox" id="notif2" checked>
                                <label class="form-check-label small fw-semibold text-dark ms-2" for="notif2">Notifikasi Laporan Bulanan Kelas</label>
                            </div>
                            <button type="submit" class="btn btn-success btn-sm px-4 rounded-pill shadow-sm">Simpan Pengaturan</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>