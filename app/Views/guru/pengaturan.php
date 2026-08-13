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
        <h3 class="fw-bold text-dark-mode mb-1" style="text-transform: none !important;">Pengaturan Akun Pengajar</h3>
        <p class="text-secondary mb-0 small" style="text-transform: none !important;">Kelola informasi profil pengajar,
            jadwal mengajar, dan keamanan akun Anda.</p>
    </div>

    <div class="row g-4">
        <!-- Sidebar Menu / Tabs -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-body p-2">
                    <div class="nav flex-column nav-pills gap-1" id="settingsUstadzTab" role="tablist">
                        <button class="nav-link active text-start py-2 px-3 rounded-3 small fw-semibold text-dark"
                            id="u-security-tab" data-bs-toggle="pill" data-bs-target="#u-security" type="button"
                            role="tab" style="font-size: 13px;">
                            <i class="fa-solid fa-lock me-2 text-success"></i> Ubah Kata Sandi
                        </button>
                        <!-- <button class="nav-link text-start py-2 px-3 rounded-3 small fw-semibold text-dark"
                            id="u-notification-tab" data-bs-toggle="pill" data-bs-target="#u-notification" type="button"
                            role="tab">
                            <i class="fa-solid fa-bell me-2 text-success"></i> Notifikasi Setoran
                        </button> -->
                        <button class="nav-link text-start py-2 px-3 rounded-3 small fw-semibold text-dark"
                            id="u-help-tab" data-bs-toggle="pill" data-bs-target="#u-help" type="button" role="tab"
                            style="font-size: 13px;">
                            <i class="fa-solid fa-circle-question me-2 text-success"></i> Bantuan Pengguna
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="col-lg-9">

            <div class="tab-content" id="settingsUstadzTabContent">

                <!-- Tab 2: Keamanan -->
                <div class="tab-pane fade show active" id="u-security" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 bg-white">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark-mode mb-1" style="text-transform: none !important;">Keamanan
                                Akun
                            </h5>
                            <p class="text-secondary small mb-4">Ganti kata sandi panel pengajar Anda.</p>

                            <form action="<?= base_url('guru/pengaturan/update-password'); ?>" method="POST">
                                <?= csrf_field(); ?>
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-dark-mode">Kata Sandi Lama</label>
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
                                <button type="submit"
                                    class="btn btn-success btn-sm px-4 rounded-pill shadow-sm">Perbarui
                                    Sandi</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Notifikasi -->
                <!-- <div class="tab-pane fade" id="u-notification" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 bg-white">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-3" style="text-transform: none !important;">Preferensi
                                Notifikasi</h5>
                            <p class="text-muted small mb-4">Atur jenis pemberitahuan yang ingin Anda terima.</p>

                            <form action="<?= base_url('guru/pengaturan/update-notification'); ?>" method="POST">
                                <?= csrf_field(); ?>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="notif_jadwal" id="notif1"
                                        value="1" <?= (isset($guru['notif_jadwal']) && $guru['notif_jadwal'] == 1) ? 'checked' : 'checked'; ?>>
                                    <label class="form-check-label small fw-semibold text-dark ms-2"
                                        for="notif1">Pengingat
                                        Jadwal Setoran Hafalan Harian</label>
                                </div>
                                <div class="form-check form-switch mb-4">
                                    <input class="form-check-input" type="checkbox" name="notif_laporan" id="notif2"
                                        value="1" <?= (isset($guru['notif_laporan']) && $guru['notif_laporan'] == 1) ? 'checked' : 'checked'; ?>>
                                    <label class="form-check-label small fw-semibold text-dark ms-2"
                                        for="notif2">Notifikasi
                                        Laporan Bulanan Kelas</label>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm px-4 rounded-pill shadow-sm">Simpan
                                    Pengaturan</button>
                            </form>
                        </div>
                    </div>
                </div> -->

                <!-- Tab 4: Bantuan & Panduan -->
                <div class="tab-pane fade" id="u-help" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 bg-white">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark-mode mb-1" style="text-transform: none !important;">
                                Bantuan &
                                Panduan Pengajar</h5>
                            <p class="text-secondary small mb-4">Panduan singkat penggunaan sistem dan tata cara
                                pelaporan
                                kendala.</p>

                            <!-- Accordion Panduan -->
                            <div class="accordion accordion-flush" id="accordionHelp">
                                <!-- Item 1 -->
                                <div class="accordion-item border rounded-3 mb-3 overflow-hidden shadow-sm">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed small fw-semibold text-dark bg-light"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                            aria-expanded="false" aria-controls="collapseOne" style="font-size: 14px;">
                                            <i class="fa-solid fa-book-open me-2 text-success"></i> Bagaimana cara
                                            menginput nilai atau setoran hafalan santri?
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionHelp">
                                        <div class="accordion-body small text-muted">
                                            Pilih menu <strong>Data Hafalan</strong> pada sidebar utama panel guru.
                                            Tekan tombol input hafalan baru, cari nama santri yang bersangkutan, lalu
                                            masukkan detail surah, ayat, jenis hafalan serta predikat kelulusan setoran,
                                            kemudian klik simpan.
                                        </div>
                                    </div>
                                </div>

                                <!-- Item 2 -->
                                <div class="accordion-item border rounded-3 mb-3 overflow-hidden shadow-sm">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed small fw-semibold text-dark bg-light"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                            aria-expanded="false" aria-controls="collapseTwo" style="font-size: 14px;">
                                            <i class="fa-solid fa-user-gear me-2 text-success"></i> Bagaimana jika
                                            terjadi kesalahan penugasan kelas atau biodata?
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="headingTwo" data-bs-parent="#accordionHelp">
                                        <div class="accordion-body small text-muted">
                                            Data kelas binaan dan NIP bersifat terikat dengan data induk yang dikelola
                                            oleh Administrator. Jika terdapat kesalahan penulisan nama, gelar,
                                            atau penugasan kelas, silakan hubungi bagian Admin Pesantren secara
                                            langsung.
                                        </div>
                                    </div>
                                </div>

                                <!-- Item 3 -->
                                <div class="accordion-item border rounded-3 mb-3 overflow-hidden shadow-sm">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed small fw-semibold text-dark bg-light"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                            aria-expanded="false" aria-controls="collapseThree"
                                            style="font-size: 14px;">
                                            <i class="fa-solid fa-shield-halved me-2 text-success"></i> Apa yang harus
                                            dilakukan jika lupa kata sandi akun?
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse"
                                        aria-labelledby="headingThree" data-bs-parent="#accordionHelp">
                                        <div class="accordion-body small text-muted">
                                            Anda dapat mengubah kata sandi secara mandiri melalui menu <strong>Ubah Kata
                                                Sandi</strong> di halaman pengaturan ini apabila masih dapat login. Jika
                                            sudah terkunci atau lupa sama sekali, mintalah bantuan Admin untuk melakukan
                                            *reset password* akun Anda.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kontak Admin Card -->
                            <div class="alert alert-success bg-success bg-opacity-25 border-2 border-success rounded-4 p-3 mt-4 d-flex align-items-center"
                                role="alert">
                                <i class="fa-solid fa-headset text-success rounded-pill bg-success bg-opacity-25 p-2 me-3 mb-3"
                                    style="font-size: 20px;"></i>
                                <div>
                                    <h6 class="fw-bold text-dark-mode mb-1 small">Butuh bantuan teknis lebih lanjut?
                                    </h6>
                                    <p class="text-secondary small mb-0">Hubungi tim pengembang atau administrator
                                        melalui
                                        WhatsApp layanan internal pesantren.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>