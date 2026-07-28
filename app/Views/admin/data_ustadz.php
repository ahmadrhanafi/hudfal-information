<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$guru  = $guru ?? [];
$kelas = $kelas ?? [];
?>

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
            <h3 class="fw-bold text-dark mb-1" style="text-transform: none !important;">Manajemen Data Ustadz</h3>
            <p class="text-muted mb-0 small" style="text-transform: none !important;">Kelola informasi pengajar, penugasan kelas, dan data ustadz di lingkungan pesantren.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-secondary btn-sm px-3 rounded-pill bg-white shadow-sm" style="text-transform: none !important;">
                <i class="fa-solid fa-file-excel text-success me-1"></i> Ekspor Data
            </button>
            <button type="button" class="btn btn-success btn-sm px-3 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah" style="text-transform: none !important;">
                <i class="fa-solid fa-plus me-1"></i> Tambah Ustadz
            </button>
        </div>
    </div>

    <!-- Filter & Search Toolbar Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-body p-3">
            <div class="row g-3 align-items-center">
                <div class="col-lg-8">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-0 ps-3 text-muted">
                            <i class="fa-solid fa-search"></i>
                        </span>
                        <input type="text" class="form-control bg-light border-0 py-2" placeholder="Cari berdasarkan nama ustadz, NIP, atau kelas...">
                    </div>
                </div>
                <div class="col-lg-4">
                    <select class="form-select form-select-sm bg-light border-0 py-2">
                        <option selected>Status: Semua</option>
                        <option value="aktif">Aktif Mengajar</option>
                        <option value="nonaktif">Non-Aktif</option>
                    </select>
                </div>
            </div>
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
                            <th class="py-3" style="width: 30%;">NIP & Nama Ustadz</th>
                            <th class="py-3" style="width: 15%;">Jenis Kelamin</th>
                            <th class="py-3" style="width: 25%;">Kelas Diampu</th>
                            <th class="py-3 text-end pe-4" style="width: 25%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($guru)): ?>
                            <?php $no = 1;
                            foreach ($guru as $g): ?>
                                <?php
                                // Inisial nama buat avatar estetik ala template lu
                                $words = explode(' ', $g['nama']);
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
                                                <h6 class="mb-0 fw-semibold text-dark" style="font-size: 0.9rem;"><?= esc($g['nama']); ?></h6>
                                                <small class="text-muted"><i class="fa-solid fa-id-card text-secondary me-1"></i> NIP: <?= esc($g['nip']); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-secondary small fw-medium">
                                            <?= ($g['jenis_kelamin'] == 'L') ? 'Laki-laki' : 'Perempuan'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                            <?= esc($g['nama_kelas'] ?? 'Belum Ditentukan'); ?>
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-1">
                                            <button type="button" class="btn btn-sm btn-light text-warning border-0 rounded-2 btn-edit"
                                                title="Edit"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEdit"
                                                data-id="<?= $g['id']; ?>"
                                                data-nip="<?= esc($g['nip']); ?>"
                                                data-nama="<?= esc($g['nama']); ?>"
                                                data-jeniskelamin="<?= esc($g['jenis_kelamin']); ?>"
                                                data-idkelas="<?= esc($g['id_kelas_diampu']); ?>">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <a href="<?= base_url('admin/ustadz/delete/' . $g['id']); ?>" class="btn btn-sm btn-light text-danger border-0 rounded-2" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ustadz ini?')">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada data ustadz.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Card Footer / Pagination -->
        <div class="card-footer bg-white border-0 py-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <span class="text-muted small">Menampilkan total <?= count($guru); ?> data ustadz</span>
        </div>
    </div>

</div>

<!-- ================= MODAL TAMBAH ================= -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Data Ustadz</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/ustadz/store'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">NIP</label>
                        <input type="text" name="nip" class="form-control" placeholder="Contoh: 198501012023..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Nama Ustadz</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Ustadz Ahmad, S.Pd." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Kelas Diampu</label>
                        <select name="id_kelas_diampu" class="form-select" required>
                            <option value="">-- Pilih Kelas --</option>
                            <?php foreach ($kelas as $k): ?>
                                <option value="<?= $k['id']; ?>"><?= esc($k['nama_kelas']); ?></option>
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
                <h5 class="modal-title fw-bold">Edit Data Ustadz</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEdit" action="" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">NIP</label>
                        <input type="text" name="nip" id="editNip" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Nama Ustadz</label>
                        <input type="text" name="nama" id="editNama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="editJenisKelamin" class="form-select" required>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Kelas Diampu</label>
                        <select name="id_kelas_diampu" id="editIdKelas" class="form-select" required>
                            <option value="">-- Pilih Kelas --</option>
                            <?php foreach ($kelas as $k): ?>
                                <option value="<?= $k['id']; ?>"><?= esc($k['nama_kelas']); ?></option>
                            <?php endforeach; ?>
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
        const modalEdit = document.getElementById('modalEdit');
        if (modalEdit) {
            modalEdit.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                const id = button.getAttribute('data-id');
                const nip = button.getAttribute('data-nip');
                const nama = button.getAttribute('data-nama');
                const jenisKelamin = button.getAttribute('data-jeniskelamin');
                const idKelas = button.getAttribute('data-idkelas');

                modalEdit.querySelector('#editNip').value = nip;
                modalEdit.querySelector('#editNama').value = nama;
                modalEdit.querySelector('#editJenisKelamin').value = jenisKelamin;
                modalEdit.querySelector('#editIdKelas').value = idKelas;

                modalEdit.querySelector('#formEdit').action = '<?= base_url('admin/ustadz/update/'); ?>' + id;
            });
        }
    });
</script>

<?= $this->endSection() ?>