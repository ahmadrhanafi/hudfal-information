<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
/** @var \CodeIgniter\Pager\Pager $pager */
?>

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
                        <span class="text-secondary small" style="font-size: 12px;">
                            <?= session()->getFlashdata('success'); ?>
                        </span>
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
                        <span class="text-secondary small" style="font-size: 12px;">
                            <?= session()->getFlashdata('error'); ?>
                        </span>
                    </div>
                </div>
                <button type="button" class="btn-close position-absolute top-0 end-0 mt-2 me-2 shadow-none"
                    style="font-size: 8px; width: 16px; height: 16px;" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Page Header & Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark-mode mb-1" style="text-transform: none !important;">Manajemen Wali Santri</h3>
            <p class="text-secondary mb-0 small" style="text-transform: none !important;">Kelola penambahan dan update
                data wali santri.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-success btn-sm px-3 rounded-pill shadow-sm" data-bs-toggle="modal"
                data-bs-target="#modalTambah">
                <i class="fa-solid fa-plus me-1"></i> Tambah Wali
            </button>
        </div>
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
                        <input type="text" id="searchInput" class="form-control bg-light border-0 py-2"
                            placeholder="Cari berdasarkan nama, nomor hp, atau alamat wali santri...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light text-muted small text-uppercase"
                        style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="py-3 text-center">No</th>
                            <th class="py-3">Nama Wali</th>
                            <th class="py-3">Chat WhatsApp</th>
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
                                <?php
                                $words = explode(' ', $w['nama_wali'] ?? '');
                                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                                ?>
                                <tr class="wali-row">
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td class="fw-semibold text-dark">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                                style="width: 38px; height: 38px; font-size: 0.9rem;">
                                                <?= $initials; ?>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold text-dark-mode" style="font-size: 0.9rem;">
                                                    <?= esc($w['nama_wali']); ?>
                                                </h6>
                                                <small class="text-secondary"><i
                                                        class="fa-solid fa-phone-volume text-secondary me-1"></i>:
                                                    <?= esc($w['no_hp'] ?? 'Tidak ada data'); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="https://wa.me/<?= esc($w['no_hp'] ?? ''); ?>" target="_blank"
                                            rel="noopener noreferrer">
                                            <span class="badge bg-success text-light border">
                                                <i class="fa-brands fa-whatsapp text-light me-1"></i> Click to Chat
                                            </span>
                                        </a>
                                    </td>
                                    <td class="text-muted small"><?= esc($w['alamat']); ?></td>
                                    <td class="text-center">
                                        <!-- Tombol Detail Baru -->
                                        <button type="button" class="btn btn-sm btn-light text-primary border-0 rounded-2"
                                            title="Detail" data-bs-toggle="modal" data-bs-target="#modalDetail"
                                            data-nama="<?= esc($w['nama_wali']); ?>" data-nohp="<?= esc($w['no_hp'] ?? ''); ?>"
                                            data-alamat="<?= esc($w['alamat']); ?>"
                                            data-santri='<?= json_encode($w['santri'] ?? []); ?>'>
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        <button type="button"
                                            class="btn btn-sm btn-light text-warning border-0 rounded-2 btn-edit" title="Edit"
                                            data-bs-toggle="modal" data-bs-target="#modalEdit" data-id="<?= $w['id']; ?>"
                                            data-nama="<?= esc($w['nama_wali']); ?>" data-nohp="<?= esc($w['no_hp'] ?? ''); ?>"
                                            data-alamat="<?= esc($w['alamat']); ?>">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <a href="<?= base_url('admin/wali-santri/delete/' . $w['id']); ?>"
                                            onclick="return confirm('Yakin ingin menghapus data wali ini?')"
                                            class="btn btn-sm btn-light text-danger border-0 rounded-2" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
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
        <!-- Card Footer / Pagination -->
        <div
            class="card card-footer bg-white border-0 px-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <span class="text-secondary small mb-2">
                <?php
                $currentPage = $pager->getCurrentPage('wali');
                $perPage = $pager->getPerPage('wali');
                $total = $pager->getTotal('wali');

                $start = $total > 0 ? (($currentPage - 1) * $perPage) + 1 : 0;
                $end = min($currentPage * $perPage, $total);
                ?>
                Menampilkan <?= $start; ?> hingga <?= $end; ?> dari total <?= $total; ?> data wali
            </span>

            <?php if (!empty($pager) && $total > $perPage): ?>
                <?= $pager->links('wali', 'hafalan_pagination'); ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- ================= MODAL TAMBAH ================= -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-dark">Tambah Data Wali Santri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('admin/wali-santri/store'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body py-4">
                        <div class="mb-3">
                            <label class="form-label fw-medium small text-muted">Nama Wali</label>
                            <input type="text" name="nama_wali" class="form-control" placeholder="Contoh: Bpk. Abdul"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium small text-muted">No. HP / WhatsApp</label>
                            <input type="text" name="no_hp" class="form-control" placeholder="Contoh: 081234567890"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium small text-muted">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap..."
                                required></textarea>
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
                    <h5 class="modal-title fw-bold text-dark">Edit Data Wali Santri</h5>
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
            <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">

                <!-- Header Modal Modern -->
                <div class="modal-header bg-light border-0 px-4 pt-4 pb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success bg-opacity-10 text-success p-3 rounded-4">
                            <i class="fa-solid fa-user-shield fa-xl"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold text-dark mb-1">Informasi Detail Wali & Santri</h5>
                            <p class="text-muted small mb-0">Profil wali santri beserta daftar anak asuh di pesantren.
                            </p>
                        </div>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">

                    <!-- Card Informasi Singkat Wali (Lebih Estetik) -->
                    <div class="p-4 rounded-4 border bg-white shadow-sm mb-4 position-relative overflow-hidden">
                        <!-- Aksen garis hijau di kiri -->
                        <div class="position-absolute start-0 top-0 bottom-0 bg-success" style="width: 5px;"></div>

                        <div class="ps-2">
                            <span
                                class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill small fw-semibold mb-2">
                                <i class="fa-solid fa-id-card me-1"></i> Profil Wali Santri
                            </span>
                            <h5 class="fw-bold text-dark mb-3" id="detailNamaWali">-</h5>

                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center text-secondary small">
                                        <div class="bg-light p-2 rounded-3 me-2 text-success">
                                            <i class="fa-solid fa-phone"></i>
                                        </div>
                                        <span id="detailNoHp">-</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center text-secondary small">
                                        <div class="bg-light p-2 rounded-3 me-2 text-success">
                                            <i class="fa-solid fa-location-dot"></i>
                                        </div>
                                        <span id="detailAlamat">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Anak / Santri -->
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="fw-bold text-dark m-0">
                            <i class="fa-solid fa-children text-success me-2"></i>Daftar Anak / Santri Asuhan
                        </h6>
                    </div>

                    <div class="table-responsive rounded-4 border overflow-hidden">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase"
                                style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                <tr>
                                    <th class="text-center py-3" width="8%">#</th>
                                    <th class="py-3">NIS</th>
                                    <th class="py-3">Nama Santri</th>
                                    <th class="py-3">Jenis Kelamin</th>
                                    <th class="py-3">Kelas</th>
                                </tr>
                            </thead>
                            <tbody id="listAnakSantri" class="border-top-0">
                                <!-- Data anak akan dimasukkan otomatis lewat JavaScript -->
                            </tbody>
                        </table>
                    </div>

                </div>

                <!-- Footer Modal -->
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-light border px-4 rounded-pill fw-semibold text-secondary"
                        data-bs-dismiss="modal">Tutup</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Pencarian data
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('#tableBodyWali .wali-row');

            if (searchInput) {
                searchInput.addEventListener('keyup', function () {
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
        modalEdit.addEventListener('show.bs.modal', function (event) {
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
            modalDetail.addEventListener('show.bs.modal', function (event) {
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