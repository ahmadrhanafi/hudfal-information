<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1" style="text-transform: none !important;">Manajemen Kelas</h3>
            <p class="text-muted mb-0 small" style="text-transform: none !important;">Kelola penambahan dan update data kelas.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-success px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="fa-solid fa-plus me-1"></i> Tambah Kelas
            </button>
        </div>

        <!-- Flash Message -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th class="py-3">#</th>
                    <th class="py-3">Nama Kelas</th>
                    <th class="py-3">Dibuat Pada</th>
                    <th class="py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($kelas)): ?>
                    <?php $no = 1;
                    foreach ($kelas as $k): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td class="fw-semibold text-dark"><?= esc($k['nama_kelas']); ?></td>
                            <td class="text-muted small"><?= esc($k['created_at']); ?></td>
                            <td class="text-center">
                                <!-- Tombol Trigger Modal Edit dengan mengirim data lewat data-* attributes -->
                                <button type="button" class="btn btn-sm btn-outline-primary me-2 btn-edit"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit"
                                    data-id="<?= $k['id']; ?>"
                                    data-namakelas="<?= esc($k['nama_kelas']); ?>">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>
                                <a href="<?= base_url('admin/kelas/delete/' . $k['id']); ?>" onclick="return confirm('Yakin ingin menghapus kelas ini?')" class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">Belum ada data kelas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ================= MODAL TAMBAH (BOOTSTRAP) ================= -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Data Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/kelas/store'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="form-control" placeholder="Contoh: Kelas 1 Ula" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= MODAL EDIT (BOOTSTRAP) ================= -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Data Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Action form di-set dinamis lewat script JavaScript di bawah -->
            <form id="formEdit" action="" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Nama Kelas</label>
                        <input type="text" name="nama_kelas" id="editNamaKelas" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success px-4">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const modalEdit = document.getElementById('modalEdit');
    modalEdit.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;

        const id = button.getAttribute('data-id');
        const namaKelas = button.getAttribute('data-namakelas');

        const inputNama = modalEdit.querySelector('#editNamaKelas');
        const formEdit = modalEdit.querySelector('#formEdit');

        inputNama.value = namaKelas;
        formEdit.action = '<?= base_url('admin/kelas/update/'); ?>' + id;
    });
</script>

<?= $this->endSection() ?>