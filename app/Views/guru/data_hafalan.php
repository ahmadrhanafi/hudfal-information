<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
/** @var \CodeIgniter\Pager\Pager $pager
 * @var string $nama_kelas
 **/
?>

<div class="container-fluid px-0">

    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1 text-dark-mode" style="text-transform: none !important;">Data Hafalan Santri Kelas <?= esc($nama_kelas); ?></h3>
            <p class="text-secondary mb-0 small text-dark-mode" style="text-transform: none !important;">Kelola catatan setoran hafalan Al-Qur'an harian untuk santri kelas binaan Anda.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-success btn-sm px-3 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#modalInputHafalan" style="text-transform: none !important;">
                <i class="fa-solid fa-plus me-1"></i> Input Setoran Baru
            </button>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="py-3 ps-4" style="width: 5%;">No</th>
                            <th class="py-3" style="width: 30%;">Nama Santri & Waktu Setor</th>
                            <th class="py-3" style="width: 25%;">Capaian Hafalan</th>
                            <th class="py-3 text-center" style="width: 15%;">Predikat</th>
                            <th class="py-3 text-end pe-4" style="width: 25%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($hafalan)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada data setoran hafalan tercatat.</td>
                            </tr>
                        <?php else: ?>
                            <?php
                            $currentPage = $pager->getCurrentPage('hafalan') ?? 1;
                            $perPage = $pager->getPerPage('hafalan') ?? 10;

                            $no = ($currentPage - 1) * $perPage + 1;

                            foreach ($hafalan as $row):
                            ?>
                                <tr>
                                    <td class="ps-4 fw-medium text-muted"><?= $no++; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.9rem;">
                                                <?= strtoupper(substr($row['nama_santri'], 0, 2)); ?>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold text-dark-mode" style="font-size: 0.9rem;"><?= esc($row['nama_santri']); ?></h6>
                                                <small class="text-muted text-dark-mode"><i class="fa-regular fa-calendar me-1"></i> <?= date('d M Y, H:i', strtotime($row['created_at'] ?? 'now')); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark-mode d-block">Juz <?= esc($row['juz']); ?> <span
                                                class="badge bg-dark bg-opacity-50 text-dark-mode border ms-1"><?= ucfirst($row['jenis']); ?></span></span>
                                        <small class="text-secondary" style="font-size: 12px;">Surah <?= esc($row['surah']); ?>
                                            (Ayat <?= $row['ayat_mulai']; ?>-<?= $row['ayat_selesai']; ?>)</small>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $badgeColor = 'success';
                                        if (strtolower($row['predikat']) == 'jayyid') $badgeColor = 'primary';
                                        if (strtolower($row['predikat']) == 'maqbul') $badgeColor = 'warning';
                                        ?>
                                        <span class="badge bg-<?= $badgeColor; ?> bg-opacity-10 text-<?= $badgeColor; ?> px-3 py-1 rounded-pill small fw-semibold">
                                            <?= ucfirst($row['predikat']); ?>
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-1">
                                            <!-- Tombol Detail (Memicu Modal Detail) -->
                                            <button type="button" class="btn btn-sm btn-light text-primary border-0 rounded-2 btn-detail"
                                                title="Detail"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalDetail"
                                                data-nama="<?= esc($row['nama_santri']); ?>"
                                                data-jenis="<?= esc($row['jenis']); ?>"
                                                data-juz="<?= esc($row['juz']); ?>"
                                                data-surah="<?= esc($row['surah']); ?>"
                                                data-ayatmulai="<?= esc($row['ayat_mulai']); ?>"
                                                data-ayatselesai="<?= esc($row['ayat_selesai']); ?>"
                                                data-predikat="<?= esc($row['predikat']); ?>"
                                                data-keterangan="<?= esc($row['keterangan'] ?? '-'); ?>"
                                                data-tanggal="<?= date('d M Y, H:i', strtotime($row['created_at'] ?? 'now')); ?>">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>

                                            <button type="button" class="btn btn-sm btn-light text-warning border-0 rounded-2"
                                                title="Edit"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEdit"
                                                data-id="<?= $row['id']; ?>"
                                                data-idsantri="<?= $row['id_santri']; ?>"
                                                data-jenis="<?= esc($row['jenis']); ?>"
                                                data-juz="<?= esc($row['juz']); ?>"
                                                data-surah="<?= esc($row['surah']); ?>"
                                                data-ayatmulai="<?= esc($row['ayat_mulai']); ?>"
                                                data-ayatselesai="<?= esc($row['ayat_selesai']); ?>"
                                                data-predikat="<?= esc($row['predikat']); ?>"
                                                data-keterangan="<?= esc($row['keterangan']); ?>">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                            <a href="<?= base_url('guru/hafalan/delete/' . $row['id']) ?>" class="btn btn-sm btn-light text-danger border-0 rounded-2" title="Hapus Setoran" onclick="return confirm('Yakin ingin menghapus catatan setoran hafalan ini?')">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Card Footer / Pagination -->
        <div class="card card-footer bg-white border-0 py-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <span class="text-secondary small">
                <?php
                // Ambil informasi detail pagination
                $details = $pager->getDetails('hafalan'); // Pastikan grup name sesuai
                // Jika data kosong, tampilkan 0
                $total = $details['total'] ?? 0;
                $perPage = $details['perPage'] ?? 10;
                $currentPage = $details['currentPage'] ?? 1;

                $start = $total > 0 ? (($currentPage - 1) * $perPage) + 1 : 0;
                $end = min($currentPage * $perPage, $total);
                ?>
                Menampilkan <?= $start; ?> hingga <?= $end; ?> dari total <?= $total; ?> data hafalan
            </span>

            <!-- Panggil Template Pager Kustom -->
            <?php if (!empty($pager)): ?>
                <?= $pager->links('hafalan', 'hafalan_pagination'); ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- MODAL INPUT HAFALAN -->
<div class="modal fade" id="modalInputHafalan" tabindex="-1" aria-labelledby="modalInputHafalanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fs-6 fw-semibold" id="modalInputHafalanLabel">
                    <i class="fa-solid fa-plus-circle me-1"></i> Input Setoran Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Route action disesuaikan ke fungsi store hafalan -->
            <form action="<?= base_url('guru/hafalan/store') ?>" method="POST">
                <?= csrf_field(); ?>
                <div class="modal-body p-4">

                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Ustadz/ah Pengampu</label>
                        <select class="form-select" disabled>
                            <?php if (!empty($guru)): ?>
                                <?php foreach ($guru as $g): ?>
                                    <option value="<?= $g['id']; ?>" <?= (session()->get('ref_id') == $g['id']) ? 'selected' : ''; ?>>
                                        <?= esc($g['nama_guru']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <input type="hidden" name="id_guru" value="<?= session()->get('ref_id'); ?>">
                    </div>

                    <!-- Pilihan Santri Binaan -->
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Pilih Santri</label>
                        <select name="id_santri" class="form-select select2-santri" data-dropdown-parent="#modalInputHafalan" required>
                            <option value="" disabled selected>-- Pilih Santri --</option>
                            <?php if (!empty($santri)): ?>
                                <?php foreach ($santri as $s): ?>
                                    <option value="<?= $s['id']; ?>"><?= esc($s['nama_santri']); ?> (NIS: <?= esc($s['nis']); ?>)</option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="row">
                        <!-- Jenis Setoran (Ziyadah / Murojaah) -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium small text-muted">Jenis Setoran</label>
                            <select name="jenis" class="form-select" required>
                                <option value="ZIYADAH">Ziyadah (Hafalan Baru)</option>
                                <option value="MUROJAAH">Murojaah (Ulang Hafalan)</option>
                            </select>
                        </div>

                        <!-- Juz -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium small text-muted">Juz</label>
                            <select name="juz" id="input-juz" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Juz --</option>
                                <?php for ($i = 1; $i <= 30; $i++): ?>
                                    <option value="<?= $i; ?>">Juz <?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Surah (Dibuat Dinamis Berdasarkan Juz) -->
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Nama Surah</label>
                        <select name="surah" id="input-surah" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Juz Terlebih Dahulu --</option>
                        </select>
                    </div>

                    <div class="row">
                        <!-- Ayat Mulai -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium small text-muted">Dari Ayat</label>
                            <input type="number" name="ayat_mulai" id="input-ayat-mulai" class="form-control" placeholder="Contoh: 1" min="1" required>
                        </div>

                        <!-- Ayat Selesai -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium small text-muted">Sampai Ayat</label>
                            <input type="number" name="ayat_selesai" id="input-ayat-selesai" class="form-control" placeholder="Contoh: 10" min="1" required>
                            </div>
                    </div>

                    <!-- Predikat / Nilai -->
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Predikat Penilaian</label>
                        <select name="predikat" class="form-select" required>
                            <option value="Mumtaz">Mumtaz (Sangat Baik)</option>
                            <option value="Jayyid Jiddan">Jayyid Jiddan (Baik Sekali)</option>
                            <option value="Jayyid">Jayyid (Baik)</option>
                            <option value="Maqbul">Maqbul (Cukup)</option>
                        </select>
                    </div>

                    <!-- Keterangan Tambahan (Opsional) -->
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Keterangan (Opsional)</label>
                        <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan tambahan untuk santri..."></textarea>
                    </div>

                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-secondary btn-sm px-3 rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-sm px-3 rounded-pill">Simpan Setoran</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DETAIL HAFALAN -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark" id="modalDetailLabel">Detail Setoran Hafalan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <table class="table table-borderless align-middle mb-0 small">
                    <tr>
                        <td class="text-muted" style="width: 35%;">Nama Santri</td>
                        <td class="fw-semibold text-dark" id="det-nama">: -</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Waktu Setor</td>
                        <td class="text-dark" id="det-tanggal">: -</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Jenis Setoran</td>
                        <td class="text-dark" id="det-jenis">: -</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Capaian</td>
                        <td class="fw-semibold text-dark" id="det-capaian">: -</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Predikat</td>
                        <td>: <span id="det-predikat" class="badge bg-success bg-opacity-10 text-success px-2 py-1">-</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Keterangan</td>
                        <td class="text-dark" id="det-keterangan">: -</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary btn-sm rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT HAFALAN -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <!-- Form mengarah ke method update di controller -->
            <form action="" id="formEditHafalan" method="POST">
                <?= csrf_field(); ?>
                <input type="hidden" name="id_guru" id="edit-id-guru">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-dark" id="modalEditLabel">Edit Setoran Hafalan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <!-- Pilih Santri -->
                    <div class="mb-3">
                        <label class="form-label small fw-medium text-muted">Santri</label>
                        <select name="id_santri" id="edit-id-santri" class="form-select form-select-sm" required>
                            <option value="" disabled>-- Pilih Santri --</option>
                            <?php if (!empty($santri)): ?>
                                <?php foreach ($santri as $s): ?>
                                    <option value="<?= $s['id']; ?>"><?= esc($s['nama_santri']); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Jenis Setoran -->
                    <div class="mb-3">
                        <label class="form-label small fw-medium text-muted">Jenis Setoran</label>
                        <select name="jenis" id="edit-jenis" class="form-select form-select-sm" required>
                            <option value="ZIYADAH">ZIYADAH (Hafalan Baru)</option>
                            <option value="MUROJAAH">MUROJAAH (Ulang Hafalan)</option>
                        </select>
                    </div>

                    <!-- Juz & Surah -->
                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-medium text-muted">Juz</label>
                            <select name="juz" id="edit-juz" class="form-select form-select-sm" required>
                                <option value="" disabled>-- Pilih Juz --</option>
                                <?php for ($i = 1; $i <= 30; $i++): ?>
                                    <option value="<?= $i; ?>">Juz <?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-medium text-muted">Surah</label>
                            <select name="surah" id="edit-surah" class="form-select form-select-sm" required>
                                <option value="" disabled selected>-- Pilih Surah --</option>
                            </select>
                        </div>
                    </div>

                    <!-- Ayat Mulai & Selesai -->
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-medium text-muted">Ayat Mulai</label>
                            <input type="number" name="ayat_mulai" id="edit-ayat-mulai" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium text-muted">Ayat Selesai</label>
                            <input type="number" name="ayat_selesai" id="edit-ayat-selesai" class="form-control form-control-sm" required>
                        </div>
                    </div>

                    <!-- Predikat -->
                    <div class="mb-3">
                        <label class="form-label small fw-medium text-muted">Predikat</label>
                        <select name="predikat" id="edit-predikat" class="form-select form-select-sm" required>
                            <option value="Mumtaz">Mumtaz (Sangat Baik)</option>
                            <option value="Jayyid Jiddan">Jayyid Jiddan (Baik Sekali)</option>
                            <option value="Jayyid">Jayyid (Baik)</option>
                            <option value="Maqbul">Maqbul (Cukup)</option>
                        </select>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label class="form-label small fw-medium text-muted">Keterangan (Opsional)</label>
                        <textarea name="keterangan" id="edit-keterangan" class="form-control form-control-sm" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light btn-sm rounded-pill px-3 text-muted" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-sm rounded-pill px-4 shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SCRIPT JAVASCRIPT UNTUK AJAX & FILTER -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Fungsi reusable untuk mengambil data surah berdasarkan juz via AJAX
        function loadSurahByJuz(juz, targetSelectId, selectedSurah = '', inputMulaiId = '', inputSelesaiId = '', valMulai = '', valSelesai = '') {
            const surahSelect = document.getElementById(targetSelectId);
            if (!surahSelect) return;

            surahSelect.innerHTML = '<option value="" disabled selected>Memuat data...</option>';

            if (!juz) {
                surahSelect.innerHTML = '<option value="" disabled selected>-- Pilih Juz Terlebih Dahulu --</option>';
                return;
            }

            fetch("<?= base_url('guru/hafalan/getSurahByJuz/'); ?>" + juz)
                .then(response => response.json())
                .then(data => {
                    surahSelect.innerHTML = '<option value="" disabled selected>-- Pilih Surah --</option>';
                    if (data && data.length > 0) {
                        data.forEach(item => {
                            let suratName = item.surah || item.nama_surah || item.surat || item.name || Object.values(item)[0];
                            let maxAyat = item.jumlah_ayat || item.total_ayat || item.verses_count || item.ayat || 300;
                            let defaultMulai = item.ayat_mulai_default || 1;
                            let defaultSelesai = item.ayat_selesai_default || maxAyat;

                            let isSelected = (suratName === selectedSurah) ? 'selected' : '';

                            surahSelect.innerHTML += `<option value="${suratName}" data-max-ayat="${maxAyat}" data-default-mulai="${defaultMulai}" data-default-selesai="${defaultSelesai}" ${isSelected}>${suratName}</option>`;
                        });

                        if (selectedSurah && inputMulaiId && inputSelesaiId) {
                            updateMaxAyat(surahSelect, inputMulaiId, inputSelesaiId, valMulai, valSelesai);
                        }
                    } else {
                        surahSelect.innerHTML = '<option value="" disabled selected>Tidak ada surah ditemukan</option>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    surahSelect.innerHTML = '<option value="" disabled selected>Gagal memuat surah</option>';
                });
        }

        // Fungsi untuk memperbarui nilai dan atribut max pada input ayat
        function updateMaxAyat(surahSelectElement, inputMulaiId, inputSelesaiId, valMulai = '', valSelesai = '') {
            const selectedOption = surahSelectElement.options[surahSelectElement.selectedIndex];
            if (!selectedOption) return;

            const maxAyat = selectedOption.getAttribute('data-max-ayat') || 300;
            const defaultMulai = selectedOption.getAttribute('data-default-mulai') || 1;
            const defaultSelesai = selectedOption.getAttribute('data-default-selesai') || maxAyat;

            const inputMulai = document.getElementById(inputMulaiId);
            const inputSelesai = document.getElementById(inputSelesaiId);

            if (inputMulai) {
                inputMulai.max = maxAyat;
                inputMulai.value = (valMulai !== '') ? valMulai : defaultMulai;
            }
            if (inputSelesai) {
                inputSelesai.max = maxAyat;
                inputSelesai.value = (valSelesai !== '') ? valSelesai : defaultSelesai;
            }
        }

        // 1. Event listener Modal Input Hafalan Baru
        const inputJuz = document.getElementById('input-juz');
        const inputSurah = document.getElementById('input-surah');

        if (inputJuz) {
            inputJuz.addEventListener('change', function () {
                // Panggil AJAX load surah, set target ke input-surah, dan otomatis update input ayat mulai/selesai
                loadSurahByJuz(this.value, 'input-surah', '', 'input-ayat-mulai', 'input-ayat-selesai');
            });
        }

        if (inputSurah) {
            inputSurah.addEventListener('change', function () {
                updateMaxAyat(this, 'input-ayat-mulai', 'input-ayat-selesai');
            });
        }

        // 2. Event listener Modal Edit Hafalan
        const editJuz = document.getElementById('edit-juz');
        const editSurah = document.getElementById('edit-surah');

        if (editJuz) {
            editJuz.addEventListener('change', function () {
                loadSurahByJuz(this.value, 'edit-surah', '', 'edit-ayat-mulai', 'edit-ayat-selesai');
            });
        }

        if (editSurah) {
            editSurah.addEventListener('change', function () {
                updateMaxAyat(this, 'edit-ayat-mulai', 'edit-ayat-selesai');
            });
        }

        // Pengaman tambahan: cegah ketik manual melebihi max ayat
        ['input-ayat-mulai', 'input-ayat-selesai', 'edit-ayat-mulai', 'edit-ayat-selesai'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('input', function () {
                    const max = parseInt(this.max) || 0;
                    if (max > 0 && parseInt(this.value) > max) {
                        this.value = max;
                    }
                });
            }
        });

        // Modal Detail
        const modalDetail = document.getElementById('modalDetail');
        if (modalDetail) {
            modalDetail.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (!button) return;
                document.getElementById('det-nama').innerText = ': ' + button.getAttribute('data-nama');
                document.getElementById('det-tanggal').innerText = ': ' + button.getAttribute('data-tanggal');
                document.getElementById('det-jenis').innerText = ': ' + button.getAttribute('data-jenis');
                document.getElementById('det-capaian').innerText = ': Juz ' + button.getAttribute('data-juz') + ' (' + button.getAttribute('data-surah') + ' ayat ' + button.getAttribute('data-ayatmulai') + '-' + button.getAttribute('data-ayatselesai') + ')';
                document.getElementById('det-predikat').innerText = button.getAttribute('data-predikat');
                document.getElementById('det-keterangan').innerText = ': ' + button.getAttribute('data-keterangan');
            });
        }

        // Modal Edit Setoran & load surah lama
        const modalEdit = document.getElementById('modalEdit');
        if (modalEdit) {
            modalEdit.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (!button) return;

                const id = button.getAttribute('data-id');
                const idSantri = button.getAttribute('data-idsantri');
                const jenis = button.getAttribute('data-jenis');
                const juz = button.getAttribute('data-juz');
                const surah = button.getAttribute('data-surah');
                const ayatMulai = button.getAttribute('data-ayatmulai');
                const ayatSelesai = button.getAttribute('data-ayatselesai');
                const predikat = button.getAttribute('data-predikat');
                const keterangan = button.getAttribute('data-keterangan');

                // Set URL form action
                const form = document.getElementById('formEditHafalan');
                if (form) form.action = "<?= base_url('guru/hafalan/update/'); ?>" + id;

                // Masukkan nilai ke input form modal
                const setVal = (elId, val) => {
                    const el = document.getElementById(elId);
                    if (el) el.value = (val !== null && val !== 'null') ? val : '';
                };

                setVal('edit-id-santri', idSantri);
                setVal('edit-jenis', jenis);
                setVal('edit-juz', juz);
                setVal('edit-predikat', predikat);
                setVal('edit-keterangan', keterangan);

                // Load surah secara dinamis berdasarkan juz, pilih surah lama, dan set max/nilai ayatnya
                loadSurahByJuz(juz, 'edit-surah', surah, 'edit-ayat-mulai', 'edit-ayat-selesai', ayatMulai, ayatSelesai);
            });
        }
    });
</script>

<?= $this->endSection() ?>