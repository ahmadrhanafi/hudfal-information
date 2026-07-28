<?php
$santri = $santri ?? [];
$kelas  = $kelas ?? [];
$wali   = $wali ?? [];
?>
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Flash Message -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i><?= session()->getFlashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-circle-exclamation me-2"></i><?= session()->getFlashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1" style="text-transform: none !important;">Manajemen Data Santri</h3>
            <p class="text-muted mb-0 small" style="text-transform: none !important;">Kelola data induk, status keaktifan, dan informasi akademik seluruh santri pesantren.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm" style="text-transform: none !important;">
                <i class="fa-solid fa-file-excel text-success me-1"></i> Ekspor Data
            </button>
            <button type="button" class="btn btn-success btn-sm px-3 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah" style="text-transform: none !important;">
                <i class="fa-solid fa-plus me-1"></i> Tambah Santri
            </button>
        </div>
    </div>

    <!-- Filter & Search Toolbar Card -->
    <form action="" method="get">
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
            <div class="card-body p-3">
                <div class="row g-3 align-items-center">
                    <!-- Input Search -->
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-0 ps-3 text-muted">
                                <i class="fa-solid fa-search"></i>
                            </span>
                            <input type="text" name="keyword" value="<?= esc($keyword ?? ''); ?>" class="form-control bg-light border-0 py-2" placeholder="Cari berdasarkan nama santri atau nomor induk...">
                        </div>
                    </div>

                    <!-- Filter Kelas -->
                    <div class="col-lg-3 col-md-6">
                        <select name="id_kelas" class="form-select form-select-sm bg-light border-0 py-2" onchange="this.form.submit()">
                            <option value="">Semua Kelas / Angkatan</option>
                            <?php foreach ($kelas as $k): ?>
                                <option value="<?= $k['id']; ?>" <?= (isset($selectedKelas) && $selectedKelas == $k['id']) ? 'selected' : ''; ?>>
                                    <?= esc($k['nama_kelas']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <select name="status" class="form-select form-select-sm bg-light border-0 py-2" onchange="this.form.submit()">
                            <option value="">Status</option>
                            <option value="Aktif" <?= (isset($selectedStatus) && $selectedStatus == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                            <option value="Lulus" <?= (isset($selectedStatus) && $selectedStatus == 'Lulus') ? 'selected' : ''; ?>>Lulus</option>
                            <option value="Keluar" <?= (isset($selectedStatus) && $selectedStatus == 'Keluar') ? 'selected' : ''; ?>>Keluar</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Main Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="py-3 ps-4" style="width: 5%;">No</th>
                            <th class="py-3" style="width: 25%;">Nama Santri</th>
                            <th class="py-3" style="width: 15%;">Nomor Induk</th>
                            <th class="py-3" style="width: 15%;">Kelas</th>
                            <th class="py-3 text-center" style="width: 15%;">Status</th>
                            <th class="py-3 text-end pe-4" style="width: 25%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($santri)): ?>
                            <?php $no = 1;
                            foreach ($santri as $s): ?>
                                <?php
                                $words = explode(' ', $s['nama_santri']);
                                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                                ?>
                                <tr>
                                    <td class="ps-4 fw-medium text-muted"><?= $no++; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.9rem;">
                                                <?= $initials; ?>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold text-dark" style="font-size: 0.9rem;"><?= esc($s['nama_santri']); ?></h6>
                                                <small class="text-muted">Wali: <?= esc($s['nama_wali'] ?? 'Tidak ada data'); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="font-monospace text-secondary small"><?= esc($s['nis']); ?></span></td>
                                    <td><span class="badge bg-light text-dark border px-2 py-1"><?= esc($s['nama_kelas'] ?? 'Belum Ditentukan'); ?></span></td>
                                    <td class="text-center">
                                        <?php if ($s['status_aktif'] == 'Aktif'): ?>
                                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill small fw-semibold">Aktif</span>
                                        <?php elseif ($s['status_aktif'] == 'Lulus'): ?>
                                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill small fw-semibold">Lulus</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-1 rounded-pill small fw-semibold">Keluar</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="<?= base_url('admin/santri-detail/' . $s['id']) ?>" class="btn btn-sm btn-light text-primary border-0 rounded-2" title="Detail">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-light text-warning border-0 rounded-2 btn-edit"
                                                title="Edit"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEdit"
                                                data-id="<?= $s['id']; ?>"
                                                data-nis="<?= esc($s['nis'], 'attr'); ?>"
                                                data-namasantri="<?= esc($s['nama_santri'], 'attr'); ?>"
                                                data-jeniskelamin="<?= esc($s['jenis_kelamin'], 'attr'); ?>"
                                                data-idkelas="<?= esc($s['id_kelas'], 'attr'); ?>"
                                                data-idwali="<?= esc($s['id_wali'], 'attr'); ?>"
                                                data-status="<?= esc($s['status_aktif'], 'attr'); ?>">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <a href="<?= base_url('admin/santri/delete/' . $s['id']) ?>" class="btn btn-sm btn-light text-danger border-0 rounded-2" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada data santri yang tersimpan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Card Footer / Pagination -->
        <div class="card-footer bg-white border-0 py-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <span class="text-muted small">Menampilkan total <?= count($santri); ?> data santri</span>
        </div>
    </div>

</div>

<!-- ================= MODAL TAMBAH ================= -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Data Santri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/santri/store'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">NIS (Nomor Induk Santri)</label>
                        <input type="text" name="nis" class="form-control" placeholder="Contoh: 2026001" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Nama Lengkap Santri</label>
                        <input type="text" name="nama_santri" class="form-control" placeholder="Contoh: Ahmad Zaki Al-Faruq" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Kelas</label>
                        <select name="id_kelas" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Kelas --</option>
                            <?php foreach ($kelas as $k): ?>
                                <option value="<?= $k['id']; ?>"><?= esc($k['nama_kelas']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Wali Santri (Orang Tua)</label>
                        <select name="id_wali" id="selectWaliTambah" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Wali Santri --</option>
                            <?php foreach ($wali as $w): ?>
                                <option value="<?= $w['id']; ?>"><?= esc($w['nama_wali']); ?> (<?= esc($w['no_hp']); ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= MODAL EDIT ================= -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Data Santri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- PERBAIKAN: Berikan nilai default action agar tidak kosong jika JS gagal -->
            <form id="formEdit" action="<?= base_url('admin/santri/update'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">NIS</label>
                        <input type="text" name="nis" id="editNis" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Nama Lengkap Santri</label>
                        <input type="text" name="nama_santri" id="editNamaSantri" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="editJenisKelamin" class="form-select" required>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Kelas</label>
                        <select name="id_kelas" id="editIdKelas" class="form-select" required>
                            <?php foreach ($kelas as $k): ?>
                                <option value="<?= $k['id']; ?>"><?= esc($k['nama_kelas']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Wali Santri</label>
                        <select name="id_wali" id="selectWaliEdit" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Wali Santri --</option>
                            <?php foreach ($wali as $w): ?>
                                <option value="<?= $w['id']; ?>"><?= esc($w['nama_wali']); ?> (<?= esc($w['no_hp']); ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Status Santri</label>
                        <select name="status_aktif" id="editStatus" class="form-select" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Lulus">Lulus</option>
                            <option value="Keluar">Keluar</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript untuk Lempar Data ke Modal Edit -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Select2
        $(document).ready(function() {
            $('#selectWaliTambah').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#modalTambah')
            });

            $('#selectWaliEdit').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#modalEdit')
            });
        });

        // Handle Modal Edit
        const modalEdit = document.getElementById('modalEdit');
        if (modalEdit) {
            modalEdit.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                const id = button.getAttribute('data-id');
                const nis = button.getAttribute('data-nis');
                const namaSantri = button.getAttribute('data-namasantri');
                const jenisKelamin = button.getAttribute('data-jeniskelamin');
                const idKelas = button.getAttribute('data-idkelas');
                const idWali = button.getAttribute('data-idwali');
                const status = button.getAttribute('data-status');

                modalEdit.querySelector('#editNis').value = nis;
                modalEdit.querySelector('#editNamaSantri').value = namaSantri;
                modalEdit.querySelector('#editJenisKelamin').value = jenisKelamin;
                modalEdit.querySelector('#editIdKelas').value = idKelas;
                modalEdit.querySelector('#editStatus').value = status;

                // Set value untuk Select2 Wali dan trigger change supaya tampilannya ikut berubah
                const selectWaliEdit = modalEdit.querySelector('#selectWaliEdit');
                selectWaliEdit.value = idWali;
                $(selectWaliEdit).trigger('change');

                // PERBAIKAN: Memastikan slash '/' aman dalam pembentukan URL update
                modalEdit.querySelector('#formEdit').action = '<?= base_url('admin/santri/update'); ?>/' + id;
            });
        }
    });
</script>

<?= $this->endSection() ?>