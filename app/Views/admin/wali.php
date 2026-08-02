<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">
    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1" style="text-transform: none !important;">Manajemen Wali Santri</h3>
            <p class="text-muted mb-0 small" style="text-transform: none !important;">Kelola penambahan dan update data wali santri.</p>
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

    <!-- Filter & Search Toolbar Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-body p-3">
            <div class="row g-3 align-items-center">
                <div class="col-lg-12">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-0 ps-3 text-muted">
                            <i class="fa-solid fa-search"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control bg-light border-0 py-2" placeholder="Cari berdasarkan nama, nomor hp, atau alamat wali santri...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="bg-light text-muted small text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                <tr>
                    <th class="py-3">No</th>
                    <th class="py-3">Nama Wali</th>
                    <th class="py-3">No. HP / WhatsApp</th>
                    <th class="py-3">Alamat</th>
                    <th class="py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBodyWali">
                <?php if (!empty($wali) && is_array($wali)): ?>
                    <?php
                    // Hitung nomor urut kontinu jika menggunakan pager, default ke 1 jika tidak ada
                    $currentPage = isset($pager) ? ($pager->getCurrentPage('wali') ?? 1) : 1;
                    $perPage = isset($pager) ? ($pager->getPerPage('wali') ?? 10) : 10;
                    $no = ($currentPage - 1) * $perPage + 1;

                    foreach ($wali as $w):
                    ?>
                        <tr class="wali-row">
                            <td><?= $no++; ?></td>
                            <td class="fw-semibold text-dark"><?= esc($w['nama_wali']); ?></td>
                            <td><span class="badge bg-light text-dark border"><?= esc($w['no_hp'] ?? '-'); ?></span></td>
                            <td class="text-muted small"><?= esc($w['alamat']); ?></td>
                            <td class="text-center">
                                <!-- Tombol Detail Baru -->
                                <button type="button" class="btn btn-sm btn-outline-info me-2 btn-detail"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalDetail"
                                    data-nama="<?= esc($w['nama_wali']); ?>"
                                    data-nohp="<?= esc($w['no_hp'] ?? ''); ?>"
                                    data-alamat="<?= esc($w['alamat']); ?>"
                                    data-santri='<?= json_encode($w['santri'] ?? []); ?>'>
                                    <i class="fa-solid fa-eye"></i> Detail
                                </button>

                                <button type="button" class="btn btn-sm btn-outline-primary me-2 btn-edit"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit"
                                    data-id="<?= $w['id']; ?>"
                                    data-nama="<?= esc($w['nama_wali']); ?>"
                                    data-nohp="<?= esc($w['no_hp'] ?? ''); ?>"
                                    data-alamat="<?= esc($w['alamat']); ?>">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>
                                <a href="<?= base_url('admin/wali-santri/delete/' . $w['id']); ?>" onclick="return confirm('Yakin ingin menghapus data wali ini?')" class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- Baris Kosong Jika Data Tidak Ditemukan -->
                <tr id="emptyRowWali" class="<?= !empty($wali) ? 'd-none' : ''; ?>">
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="fa-solid fa-folder-open me-1"></i> Belum ada data wali santri.
                    </td>
                </tr>
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
                        <input type="text" name="nama_wali" class="form-control" placeholder="Contoh: Bpk. Ahmad" required>
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
                        <input type="text" name="nama_wali" id="editNama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-muted">No. WhatsApp</label>
                        <input type="number" name="no_hp" id="editNoHp" class="form-control" required>
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

<!-- ================= MODAL DETAIL ================= -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Informasi Detail Wali & Santri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <!-- Informasi Singkat Wali -->
                <div class="bg-light p-3 rounded-3 mb-4">
                    <h6 class="fw-bold text-dark mb-2" id="detailNamaWali">-</h6>
                    <p class="mb-1 small text-muted"><i class="fa-solid fa-phone me-2"></i><span id="detailNoHp">-</span></p>
                    <p class="mb-0 small text-muted"><i class="fa-solid fa-location-dot me-2"></i><span id="detailAlamat">-</span></p>
                </div>

                <!-- Daftar Anak / Santri -->
                <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-child me-2"></i>Daftar Anak / Santri Asuhan:</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="5%">#</th>
                                <th>NIS</th>
                                <th>Nama Santri</th>
                                <th>Jenis Kelamin</th>
                                <th>Kelas</th>
                            </tr>
                        </thead>
                        <tbody id="listAnakSantri">
                            <!-- Data anak akan dimasukkan otomatis lewat JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Pencarian data
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('#tableBodyWali .wali-row');

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

    // Buat buka modal
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

    // Script untuk Modal Detail Anak/Santri
    const modalDetail = document.getElementById('modalDetail');
    if (modalDetail) {
        modalDetail.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;

            // Ambil data dari atribut tombol
            const namaWali = button.getAttribute('data-nama');
            const noHp = button.getAttribute('data-nohp');
            const alamat = button.getAttribute('data-alamat');

            // Parse data JSON santri/anak
            let listSantri = [];
            try {
                listSantri = JSON.parse(button.getAttribute('data-santri'));
            } catch (e) {
                listSantri = [];
            }

            // Masukkan data ke dalam elemen modal
            modalDetail.querySelector('#detailNamaWali').textContent = namaWali;
            modalDetail.querySelector('#detailNoHp').textContent = noHp;
            modalDetail.querySelector('#detailAlamat').textContent = alamat;

            const tbodyAnak = modalDetail.querySelector('#listAnakSantri');
            tbodyAnak.innerHTML = ''; // Kosongkan dulu

            if (listSantri.length > 0) {
                listSantri.forEach((anak, index) => {
                    let row = `<tr>
                        <td class="text-center">${index + 1}</td>
                        <td>${anak.nis ?? '-'}</td>
                        <td class="fw-semibold">${anak.nama_santri ?? '-'}</td>
                        <td>${anak.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'}</td>
                        <td><span class="badge bg-success-subtle text-success">${anak.nama_kelas ?? 'Belum ada kelas'}</span></td>
                    </tr>`;
                    tbodyAnak.insertAdjacentHTML('beforeend', row);
                });
            } else {
                tbodyAnak.innerHTML = `<tr><td colspan="5" class="text-center text-muted py-3">Wali ini belum memiliki data anak/santri yang terdaftar.</td></tr>`;
            }
        });
    }
</script>

<?= $this->endSection() ?>