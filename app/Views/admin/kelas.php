<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark-mode mb-1" style="text-transform: none !important;">Manajemen Kelas</h3>
            <p class="text-secondary mb-0 small" style="text-transform: none !important;">Kelola penambahan dan update data kelas.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-success btn-sm px-3 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="fa-solid fa-plus me-1"></i> Tambah Kelas
            </button>
        </div>
    </div>

    <!-- Flash Message -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
            <?= session()->getFlashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Filter & Search Toolbar Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-body p-3">
            <div class="row g-3 align-items-center">
                <div class="col-lg-12">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-0 ps-3 text-muted">
                            <i class="fa-solid fa-search"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control bg-light border-0 py-2" placeholder="Cari berdasarkan nama kelas...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="py-3 ps-4">No</th>
                            <th class="py-3">Nama Kelas</th>
                            <th class="py-3">Guru Pengampu</th>
                            <th class="py-3 text-center" style="width: 20%;">Jumlah Santri</th>
                            <th class="py-3">Dibuat Pada</th>
                            <th class="py-3 text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBodyKelas">
                        <?php if (!empty($kelas)): ?>
                            <?php $no = 1;
                            foreach ($kelas as $k): ?>
                                <tr class="kelas-row">
                                    <td class="ps-4"><?= $no++; ?></td>
                                    <td class="fw-semibold text-secondary small">
                                        <div>
                                            <h6 class="mb-0 text-secondary small" style="font-size: 0.65rem;">Kelas:</h6>
                                            <small class="fw-semibold text-dark-mode" style="font-size: 0.9rem;"><i class=" fa-solid fa-school text-secondary me-1"></i><?= esc($k['nama_kelas']); ?></small>
                                        </div>
                                    </td>
                                    <td class="text-secondary small">
                                        <?php if (!empty($k['nama_guru'])): ?>
                                            <div>
                                                <h6 class="mb-0 fw-semibold text-dark-mode" style="font-size: 0.9rem;"><?= esc($k['nama_guru']); ?></h6>
                                                <small class="text-secondary"><i class="fa-solid fa-id-card text-secondary me-1"></i> NIP: <?= esc($k['nip']); ?></small>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-warning small">Belum ada guru pengampu</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-semibold">
                                            <i class="fa-solid fa-users me-1"></i> <?= $k['total_santri']; ?> Santri
                                        </span>
                                    </td>
                                    <td class="text-muted small"><?= esc($k['created_at']); ?></td>
                                    <td class="text-center pe-4">
                                        <!-- Tombol Trigger Modal Edit -->
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
    </div>
</div>

<!-- ================= MODAL TAMBAH ================= -->
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

<!-- ================= MODAL EDIT ================= -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Data Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
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

<!-- ================= JAVASCRIPT ================= -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Script untuk lempar data ke Modal Edit
        const modalEdit = document.getElementById('modalEdit');
        if (modalEdit) {
            modalEdit.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const namaKelas = button.getAttribute('data-namakelas');

                const inputNama = modalEdit.querySelector('#editNamaKelas');
                const formEdit = modalEdit.querySelector('#formEdit');

                inputNama.value = namaKelas;
                formEdit.action = '<?= base_url('admin/kelas/update/'); ?>' + id;
            });
        }

        // Script untuk Live Search Table Kelas
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('#tableBodyKelas .kelas-row');

        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const searchTerm = searchInput.value.toLowerCase();

                tableRows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    if (rowText.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });
</script>

<?= $this->endSection() ?>