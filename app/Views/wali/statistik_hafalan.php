<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1" style="text-transform: none !important;">Statistik & Grafik Hafalan Ananda</h3>
            <p class="text-muted mb-0 small" style="text-transform: none !important;">Pantau grafik perkembangan setoran Al-Qur'an, capaian juz, dan tingkat konsistensi harian.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm" style="text-transform: none !important;">
                <i class="fa-solid fa-file-pdf text-success me-1"></i> Unduh Laporan PDF
            </button>
        </div>
    </div>

    <!-- Ringkasan Statistik Utama -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-15 p-3 rounded-3 text-success">
                        <i class="fa-solid fa-book-quran fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">TOTAL JUZ TERSERAH</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">4.5 <span class="fs-6 fw-normal text-muted">Juz</span></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-15 p-3 rounded-3 text-primary">
                        <i class="fa-solid fa-fire fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">KONSISTENSI (STREAK)</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">18 <span class="fs-6 fw-normal text-success">Hari Beruntun</span></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-15 p-3 rounded-3 text-warning">
                        <i class="fa-solid fa-award fa-2x"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium" style="text-transform: none !important;">RATA-RATA PREDIKAT</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">Mumtaz <span class="fs-6 fw-normal text-success">(Sangat Baik)</span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Baris Grafik (Visualisasi Statistik) -->
    <div class="row g-4 mb-4">
        <!-- Grafik Perkembangan Bulanan (Simulasi Chart) -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="fw-bold text-dark mb-1" style="text-transform: none !important; font-size: 1.05rem;">Grafik Capaian Ayat per Bulan</h5>
                            <p class="text-muted small mb-0">Akumulasi jumlah ayat yang berhasil dihafal dalam 6 bulan terakhir.</p>
                        </div>
                        <select class="form-select form-select-sm bg-light border-0 py-1 px-3 w-auto">
                            <option selected>Tahun 2026</option>
                            <option value="2025">Tahun 2025</option>
                        </select>
                    </div>

                    <!-- Visualisasi Batang Sederhana (Responsive Simulated Chart) -->
                    <div class="d-flex align-items-end justify-content-between gap-2 px-2 pt-4 pb-2" style="height: 220px; border-bottom: 2px solid #f8f9fa;">
                        <div class="text-center w-100 d-flex flex-column align-items-center h-100 justify-content-end">
                            <span class="small text-muted mb-1" style="font-size: 0.7rem;">120 ayat</span>
                            <div class="w-75 bg-success bg-opacity-25 rounded-top" style="height: 40%;"></div>
                            <span class="small text-muted mt-2 fw-semibold" style="font-size: 0.75rem;">Feb</span>
                        </div>
                        <div class="text-center w-100 d-flex flex-column align-items-center h-100 justify-content-end">
                            <span class="small text-muted mb-1" style="font-size: 0.7rem;">150 ayat</span>
                            <div class="w-75 bg-success bg-opacity-50 rounded-top" style="height: 55%;"></div>
                            <span class="small text-muted mt-2 fw-semibold" style="font-size: 0.75rem;">Mar</span>
                        </div>
                        <div class="text-center w-100 d-flex flex-column align-items-center h-100 justify-content-end">
                            <span class="small text-muted mb-1" style="font-size: 0.7rem;">190 ayat</span>
                            <div class="w-75 bg-success bg-opacity-75 rounded-top" style="height: 70%;"></div>
                            <span class="small text-muted mt-2 fw-semibold" style="font-size: 0.75rem;">Apr</span>
                        </div>
                        <div class="text-center w-100 d-flex flex-column align-items-center h-100 justify-content-end">
                            <span class="small text-muted mb-1" style="font-size: 0.7rem;">160 ayat</span>
                            <div class="w-75 bg-success rounded-top opacity-75" style="height: 60%;"></div>
                            <span class="small text-muted mt-2 fw-semibold" style="font-size: 0.75rem;">Mei</span>
                        </div>
                        <div class="text-center w-100 d-flex flex-column align-items-center h-100 justify-content-end">
                            <span class="small text-muted mb-1" style="font-size: 0.7rem;">210 ayat</span>
                            <div class="w-75 bg-success rounded-top" style="height: 85%;"></div>
                            <span class="small text-muted mt-2 fw-semibold" style="font-size: 0.75rem;">Jun</span>
                        </div>
                        <div class="text-center w-100 d-flex flex-column align-items-center h-100 justify-content-end">
                            <span class="small text-success fw-bold mb-1" style="font-size: 0.7rem;">240 ayat</span>
                            <div class="w-75 bg-success rounded-top shadow-sm" style="height: 100%;"></div>
                            <span class="small text-success fw-bold mt-2" style="font-size: 0.75rem;">Jul</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Distribusi Jenis Setoran (Ziyadah vs Murojaah) -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="fw-bold text-dark mb-1" style="text-transform: none !important; font-size: 1.05rem;">Komposisi Setoran</h5>
                        <p class="text-muted small mb-4">Perbandingan aktivitas ziyadah (hafalan baru) dan murojaah (pengulangan).</p>
                    </div>

                    <div class="d-flex flex-column gap-3 mb-4">
                        <div>
                            <div class="d-flex justify-content-between align-items-center small mb-1">
                                <span class="fw-semibold text-dark"><i class="fa-solid fa-circle text-success me-1" style="font-size: 0.5rem;"></i> Ziyadah (Hafalan Baru)</span>
                                <span class="text-muted fw-semibold">65%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success rounded-pill" role="progressbar" style="width: 65%;"></div>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex justify-content-between align-items-center small mb-1">
                                <span class="fw-semibold text-dark"><i class="fa-solid fa-circle text-primary me-1" style="font-size: 0.5rem;"></i> Murojaah (Pengulangan)</span>
                                <span class="text-muted fw-semibold">35%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary rounded-pill" role="progressbar" style="width: 35%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-3 text-center">
                        <small class="text-muted"><i class="fa-solid fa-circle-check text-success me-1"></i> Rasio hafalan dan pengulangan sangat seimbang.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Rekap Progress Juz -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
            <h5 class="fw-bold text-dark mb-1" style="text-transform: none !important; font-size: 1.05rem;">Detail Capaian per Juz</h5>
            <p class="text-muted small mb-3">Status penyelesaian juz Al-Qur'an ananda di pesantren.</p>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="py-3 ps-4" style="width: 15%;">Juz</th>
                            <th class="py-3" style="width: 35%;">Nama Juz / Surah Utama</th>
                            <th class="py-3" style="width: 30%;">Status Progress</th>
                            <th class="py-3 text-end pe-4" style="width: 20%;">Predikat Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ps-4 fw-semibold text-dark">Juz 30</td>
                            <td>
                                <span class="fw-semibold text-dark d-block small">Juz 'Amma (An-Naba' s.d An-Nas)</span>
                                <small class="text-muted" style="font-size: 0.75rem;">Selesai disetorkan</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress w-100" style="height: 6px;">
                                        <div class="progress-bar bg-success rounded-pill" style="width: 100%;"></div>
                                    </div>
                                    <span class="small fw-semibold text-success">100%</span>
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <span class="badge bg-success text-white px-3 py-1 rounded-pill small fw-semibold">Mumtaz</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4 fw-semibold text-dark">Juz 29</td>
                            <td>
                                <span class="fw-semibold text-dark d-block small">Tabarakalladzii (Al-Mulk s.d Al-Mursalat)</span>
                                <small class="text-muted" style="font-size: 0.75rem;">Dalam proses hafalan</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress w-100" style="height: 6px;">
                                        <div class="progress-bar bg-primary rounded-pill" style="width: 50%;"></div>
                                    </div>
                                    <span class="small fw-semibold text-primary">50%</span>
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <span class="badge bg-primary text-white px-3 py-1 rounded-pill small fw-semibold">Jayyid Jiddan</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4 fw-semibold text-dark">Juz 1</td>
                            <td>
                                <span class="fw-semibold text-dark d-block small">Alif Lam Mim (Al-Baqarah ayat 1-141)</span>
                                <small class="text-muted" style="font-size: 0.75rem;">Mulai dirintis</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress w-100" style="height: 6px;">
                                        <div class="progress-bar bg-warning rounded-pill" style="width: 20%;"></div>
                                    </div>
                                    <span class="small fw-semibold text-warning">20%</span>
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <span class="badge bg-warning text-dark px-3 py-1 rounded-pill small fw-semibold">Jayyid</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3 px-4">
            <small class="text-muted"><i class="fa-solid fa-circle-info me-1"></i> Data statistik diperbarui secara otomatis setiap kali ustadz pembimbing memasukkan log setoran harian.</small>
        </div>
    </div>

</div>

<?= $this->endSection() ?>