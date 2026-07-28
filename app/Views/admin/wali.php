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
                <i class="fa-solid fa-plus me-1"></i> Tambah Wali
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
                    <th class="py-3">Nama Wali</th>
                    <th class="py-3">No. HP / WhatsApp</th>
                    <th class="py-3">Alamat</th>
                    <th class="py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($wali)): ?>
                    <?php $no = 1;
                    foreach ($wali as $w): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td class="fw-semibold text-dark"><?= esc($w['nama']); ?></td>
                            <td><span class="badge bg-light text-dark border"><?= esc($w['no_hp']); ?></span></td>
                            <td class="text-muted small"><?= esc($w['alamat']); ?></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-outline-primary me-2 btn-edit"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit"
                                    data-id="<?= $w['id']; ?>"
                                    data-nama="<?= esc($w['nama']); ?>"
                                    data-nohp="<?= esc($w['no_hp']); ?>"
                                    data-alamat="<?= esc($w['alamat']); ?>">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>
                                <a href="<?= base_url('admin/wali-santri/delete/' . $w['id']); ?>" onclick="return confirm('Yakin ingin menghapus data wali ini?')" class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada data wali santri.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ================= MODAL TAMBAH ================= -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Data Wali Santri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/wali-santri/store'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Nama Wali</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Bpk. Ahmad" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">No. HP / WhatsApp</label>
                        <input type="text" name="no_hp" class="form-control" placeholder="Contoh: 081234567890" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap..." required></textarea>
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

<!-- ================= MODAL EDIT ================= -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Data Wali Santri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEdit" action="" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Nama Wali</label>
                        <input type="text" name="nama" id="editNama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">No. HP / WhatsApp</label>
                        <input type="text" name="no_hp" id="editNoHp" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">Alamat</label>
                        <textarea name="alamat" id="editAlamat" class="form-control" rows="3" required></textarea>
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
        const nama = button.getAttribute('data-nama');
        const noHp = button.getAttribute('data-nohp');
        const alamat = button.getAttribute('data-alamat');

        modalEdit.querySelector('#editNama').value = nama;
        modalEdit.querySelector('#editNoHp').value = noHp;
        modalEdit.querySelector('#editAlamat').value = alamat;

        modalEdit.querySelector('#formEdit').action = '<?= base_url('admin/wali-santri/update/'); ?>' + id;
    });
</script>

<?= $this->endSection() ?>