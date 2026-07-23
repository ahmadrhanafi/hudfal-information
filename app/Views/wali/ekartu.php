<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1" style="text-transform: none !important;">e-Kartu Santri Digital</h3>
            <p class="text-muted mb-0 small" style="text-transform: none !important;">Kartu identitas digital ananda yang digunakan untuk absensi, akses asrama, dan transaksi kantin pesantren.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm" style="text-transform: none !important;">
                <i class="fa-solid fa-print text-success me-1"></i> Cetak Kartu Fisik
            </button>
            <button class="btn btn-success btn-sm px-3 rounded-pill shadow-sm" style="text-transform: none !important;">
                <i class="fa-solid fa-download me-1"></i> Unduh e-Kartu (PNG)
            </button>
        </div>
    </div>

    <!-- Konten Utama: Preview Kartu Digital & Informasi -->
    <div class="row g-4 justify-content-center">

        <!-- Kolom Pratinjau Kartu Digital (Style ID Card / E-Money) -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 text-white overflow-hidden position-relative" style="background: linear-gradient(135deg, #198754 0%, #146c43 100%);">
                <!-- Aksen Dekoratif Background -->
                <div class="position-absolute top-0 end-0 p-4 opacity-10">
                    <i class="fa-solid fa-mosque fa-8x"></i>
                </div>

                <div class="card-body p-4 p-md-4 position-relative z-1">
                    <!-- Header Kartu -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-white text-success rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </div>
                            <span class="fw-bold small text-uppercase tracking-wider" style="font-size: 0.75rem;">Pesantren Al-Hidayah</span>
                        </div>
                        <span class="badge bg-white text-success px-2 py-1 rounded-pill" style="font-size: 0.7rem;">Aktif</span>
                    </div>

                    <!-- Informasi Santri -->
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="bg-white text-success rounded-3 d-flex align-items-center justify-content-center fw-bold fs-3 shadow-sm" style="width: 65px; height: 65px;">
                            AZ
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 text-white" style="text-transform: none !important; font-size: 1.1rem;">Ahmad Zaki Al-Faruq</h5>
                            <span class="d-block text-white-50 small">NIS: 202401001</span>
                            <span class="badge bg-success bg-opacity-50 text-white border border-light border-opacity-25 mt-1 px-2 py-0" style="font-size: 0.7rem;">Kelas 8A Tsanawiyah</span>
                        </div>
                    </div>

                    <!-- Footer Kartu (QR Code Simulation & Chip) -->
                    <div class="d-flex justify-content-between align-items-end pt-3 border-top border-light border-opacity-25">
                        <div>
                            <span class="d-block text-white-50" style="font-size: 0.65rem; text-transform: uppercase;">Saldo e-Kantin</span>
                            <span class="fw-bold fs-5 text-white font-monospace">Rp 125.000</span>
                        </div>
                        <div class="bg-white p-2 rounded-3 text-dark text-center shadow-sm">
                            <i class="fa-solid fa-qrcode fa-2x lh-1 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-3">
                <small class="text-muted"><i class="fa-solid fa-circle-info me-1"></i> Tunjukkan QR Code di atas kepada pengurus saat absen atau belanja di kantin.</small>
            </div>
        </div>

        <!-- Kolom Informasi & Pengaturan Kartu -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-3" style="text-transform: none !important;">
                        <i class="fa-solid fa-id-card text-success me-2"></i> Detail & Keamanan Kartu
                    </h5>
                    <p class="text-muted small mb-4" style="text-transform: none !important;">Status fungsionalitas dan riwayat penggunaan e-Kartu ananda dalam sistem terpadu pesantren.</p>

                    <!-- Informasi Detail List -->
                    <div class="d-flex flex-column gap-3 mb-4">
                        <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-3">
                            <span class="text-muted small">Nomor Seri Kartu</span>
                            <span class="font-monospace fw-semibold text-dark small">UID-8829-9102-3841</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-3">
                            <span class="text-muted small">Masa Berlaku Kartu</span>
                            <span class="fw-semibold text-dark small">Juli 2026 - Juli 2027</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-3">
                            <span class="text-muted small">Status Penggunaan</span>
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill small">Normal / Digunakan</span>
                        </div>
                    </div>

                    <!-- Tombol Blokir / Laporkan Hilang -->
                    <div class="p-3 bg-danger bg-opacity-10 rounded-4 border border-danger border-opacity-10 d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                        <div>
                            <h6 class="fw-semibold text-danger mb-1" style="font-size: 0.9rem;">Kartu Hilang atau Rusak?</h6>
                            <p class="text-muted small mb-0" style="font-size: 0.78rem;">Anda dapat memblokir sementara untuk keamanan saldo kantin.</p>
                        </div>
                        <button class="btn btn-outline-danger btn-sm px-3 rounded-pill text-nowrap" onclick="return confirm('Yakin ingin memblokir e-Kartu ini sementara?')">
                            <i class="fa-solid fa-triangle-exclamation me-1"></i> Blokir Kartu
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

<?= $this->endSection() ?>