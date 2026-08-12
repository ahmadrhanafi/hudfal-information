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
                                $fotoWali = !empty($w['foto']) && $w['foto'] !== 'null' && $w['foto'] !== 'undefined';
                                ?>
                                <?php
                                $words = explode(' ', $w['nama_wali'] ?? '');
                                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                                ?>
                                <tr class="wali-row">
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td class="fw-semibold text-dark">
                                        <div class="d-flex align-items-center gap-3">
                                            <?php if ($fotoWali): ?>
                                                <img src="<?= base_url('uploads/profile/' . $w['foto']); ?>"
                                                    class="rounded-circle shadow-sm border border-2 border-white flex-shrink-0"
                                                    style="width: 38px; height: 38px; object-fit: cover;" alt="Foto Wali">
                                            <?php else: ?>
                                                <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                                                    style="width: 38px; height: 38px; font-size: 0.9rem;">
                                                    <?= $initials; ?>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <h6 class="mb-0 fw-semibold text-dark-mode" style="font-size: 0.9rem;">
                                                    <?= esc($w['nama_wali']); ?>
                                                </h6>
                                                <small class="text-secondary"><i
                                                        class="fa-solid fa-phone-volume text-secondary me-1"></i>
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
                                        <!-- detail -->
                                        <button type="button" class="btn btn-sm btn-light text-primary border-0 rounded-2"
                                            title="Detail" data-bs-toggle="modal" data-bs-target="#modalDetail"
                                            data-nama="<?= esc($w['nama_wali']); ?>" data-nohp="<?= esc($w['no_hp'] ?? ''); ?>"
                                            data-alamat="<?= esc($w['alamat']); ?>" data-foto="<?= $w['foto']; ?>"
                                            data-santri='<?= json_encode($w['santri'] ?? []); ?>'>
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        <!-- edit -->
                                        <button type="button"
                                            class="btn btn-sm btn-light text-warning border-0 rounded-2 btn-edit" title="Edit"
                                            data-bs-toggle="modal" data-bs-target="#modalEdit" data-id="<?= $w['id']; ?>"
                                            data-nama="<?= esc($w['nama_wali']); ?>" data-nohp="<?= esc($w['no_hp'] ?? ''); ?>"
                                            data-alamat="<?= esc($w['alamat']); ?>">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        <!-- hapus -->
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
                <form action="<?= base_url('admin/wali-santri/store'); ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="modal-body py-4">
                        <div class="mb-3">
                            <label class="form-label fw-medium small text-muted">Foto Profil</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>
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
                <form id="formEdit" action="" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="modal-body py-4">
                        <div class="mb-3">
                            <label class="form-label fw-medium small text-muted">Ganti Foto Profil (Biarkan jika tidak
                                ingin diganti)</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>
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
                    <div class="p-4 rounded-4 border bg-white shadow-sm mb-4 position-relative overflow-hidden pt-5">
                        <!-- Aksen garis hijau di atas -->
                        <div class="position-absolute start-0 top-0 end-0 bg-success" style="height: 5px;"></div>

                        <div class="ps-2">
                            <!-- Bagian Header (Foto di Kiri, Nama & Badge di Kanan) -->
                            <div class="d-flex align-items-center mb-3">
                                <!-- FOTO / INISIAL DI KIRI -->
                                <div class="me-3 flex-shrink-0">
                                    <img id="detailFotoWali" src=""
                                        class="rounded-circle shadow-sm border border-2 border-white"
                                        style="width: 75px; height: 75px; object-fit: cover;" alt="Foto Wali">
                                    <div id="detailInisialWali"
                                        class="bg-success bg-opacity-10 text-success rounded-circle align-items-center justify-content-center fw-bold"
                                        style="width: 75px; height: 75px; font-size: 1.5rem;">
                                        -
                                    </div>
                                </div>

                                <!-- BADGE & NAMA DI KANAN -->
                                <div>
                                    <span
                                        class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill small fw-semibold mb-1">
                                        <i class="fa-solid fa-id-card me-1"></i> Profil Wali Santri
                                    </span>
                                    <h5 class="fw-bold text-dark mb-0" id="detailNamaWali">-</h5>
                                </div>
                            </div>

                            <!-- Bagian Kontak (No HP & Alamat) -->
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
                        <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill small"
                            id="badgeTotalAnak">0 Anak</span>
                    </div>

                    <div id="listAnakSantri" class="d-flex flex-column gap-2"
                        style="max-height: 280px; overflow-y: auto;">
                        <!-- Data anaknya masing-masing dimasukkan otomatis lewat JavaScript -->
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
                const fotoWali = button.getAttribute('data-foto');

                // Parse data JSON santri/anak
                let listSantri = [];
                try {
                    listSantri = JSON.parse(button.getAttribute('data-santri'));
                } catch (e) {
                    listSantri = [];
                }

                modalDetail.querySelector('#detailNamaWali').textContent = namaWali || '-';
                modalDetail.querySelector('#detailNoHp').textContent = noHp || '-';
                modalDetail.querySelector('#detailAlamat').textContent = alamat || '-';

                // --- HANDLE TAMPILAN FOTO / INISIAL WALI ---
                const imgEl = modalDetail.querySelector('#detailFotoWali');
                const inisialEl = modalDetail.querySelector('#detailInisialWali');

                if (fotoWali && fotoWali !== '' && fotoWali !== 'null' && fotoWali !== 'undefined') {
                    imgEl.src = "<?= base_url('uploads/profile/'); ?>/" + fotoWali;
                    imgEl.style.display = 'block';
                    inisialEl.style.display = 'none';
                } else {
                    imgEl.style.display = 'none';
                    inisialEl.style.display = 'flex';

                    // Logika 2 huruf
                    if (namaWali) {
                        const kata = namaWali.trim().split(/\s+/);
                        let inisial = '';

                        if (kata.length >= 2) {
                            inisial = kata[0].charAt(0) + kata[1].charAt(0);
                        } else if (kata[0].length >= 2) {
                            inisial = kata[0].substring(0, 2);
                        } else {
                            inisial = kata[0].charAt(0);
                        }

                        inisialEl.textContent = inisial.toUpperCase();
                    } else {
                        inisialEl.textContent = '-';
                    }
                }
                // ---------------------------------

                const containerAnak = modalDetail.querySelector('#listAnakSantri');
                containerAnak.innerHTML = '';

                if (listSantri.length > 0) {
                    // Update badge jumlah anak di sebelah kanan header
                    const badgeTotal = modalDetail.querySelector('#badgeTotalAnak');
                    if (badgeTotal) badgeTotal.textContent = listSantri.length + ' Anak';

                    listSantri.forEach((anak, index) => {
                        const isLaki = anak.jenis_kelamin === 'L' || anak.jenis_kelamin === 'Laki-laki';

                        // Cek apakah ada field foto santri (sesuaikan 'anak.foto' dengan nama field di database kamu)
                        const punyaFoto = anak.foto && anak.foto !== '' && anak.foto !== 'null' && anak.foto !== 'undefined';

                        let avatarHtml = '';
                        if (punyaFoto) {
                            avatarHtml = `<img src="<?= base_url('uploads/santri/'); ?>/${anak.foto}" 
                class="rounded-circle shadow-sm border border-2 border-white flex-shrink-0" 
                style="width: 45px; height: 45px; object-fit: cover;" 
                alt="Foto Santri">`;
                        } else {
                            let namaSantri = anak.nama_santri ?? 'No Name';
                            const kata = namaSantri.trim().split(/\s+/);
                            let inisial = '';

                            if (kata.length >= 2) {
                                inisial = kata[0].charAt(0) + kata[1].charAt(0);
                            } else if (kata[0].length >= 2) {
                                inisial = kata[0].substring(0, 2);
                            } else {
                                inisial = kata[0].charAt(0);
                            }
                            inisial = inisial.toUpperCase();

                            const bgClass = isLaki ? 'bg-primary bg-opacity-10 text-primary' : 'bg-danger bg-opacity-10 text-danger';

                            avatarHtml = `<div class="rounded-circle ${bgClass} d-flex align-items-center justify-content-center fw-bold flex-shrink-0 shadow-sm" style="width: 45px; height: 45px; font-size: 1rem;">
                ${inisial}
            </div>`;
                        }

                        // Desain Card per Santri
                        let cardItem = `
        <div class="p-3 rounded-4 border bg-white shadow-sm d-flex align-items-center justify-content-between transition-hover">
            <div class="d-flex align-items-center gap-3">
                <!-- Avatar (Foto / Inisial) -->
                ${avatarHtml}
                
                <!-- Detail Teks -->
                <div>
                    <h6 class="fw-bold text-dark mb-1">${anak.nama_santri ?? '-'}</h6>
                    <div class="d-flex align-items-center gap-2 text-muted small">
                        <span><i class="fa-solid fa-id-badge me-1"></i>NIS: <strong class="text-dark">${anak.nis ?? '-'}</strong></span>
                        <span>•</span>
                        <span class="${isLaki ? 'text-primary' : 'text-danger'} fw-semibold">
                            <i class="fa-solid ${isLaki ? 'fa-mars' : 'fa-venus'} me-1"></i>${isLaki ? 'Laki-laki' : 'Perempuan'}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Badge Kelas di Kanan -->
            <div>
                <span class="badge bg-success-subtle text-success px-3 py-2 mt-5 rounded-pill fw-semibold">
                    <i class="fa-solid fa-school me-1"></i> ${anak.nama_kelas ?? 'Belum ada kelas'}
                </span>
            </div>
        </div>`;

                        containerAnak.insertAdjacentHTML('beforeend', cardItem);
                    });
                } else {
                    const badgeTotal = modalDetail.querySelector('#badgeTotalAnak');
                    if (badgeTotal) badgeTotal.textContent = '0 Anak';

                    containerAnak.innerHTML = `
    <div class="text-center text-muted py-4 border rounded-4 bg-light">
        <i class="fa-solid fa-face-smile fa-2x mb-2 opacity-50"></i>
        <p class="mb-0 small">Wali ini belum memiliki data anak/santri yang terdaftar.</p>
    </div>`;
                }
            });
        }
    </script>

    <?= $this->endSection() ?>