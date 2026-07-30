<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$santri = $santri ?? [];
?>


<div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
    <!-- Header Ringkas Identitas Santri -->
    <div class="card-header bg-white border-0 p-4 pb-2">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-dark mb-1"><?= esc($santri['nama_santri']); ?></h5>
                <p class="text-muted small mb-0">NIS: <?= esc($santri['nis']); ?> &bull; Kelas: <?= esc($santri['nama_kelas'] ?? 'Belum Ada Kelas'); ?></p>
            </div>
            <a href="<?= base_url('guru/riwayat-hafalan'); ?>" class="btn btn-sm btn-light text-secondary border rounded-3 px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                    <tr>
                        <th class="py-3 ps-4" style="width: 5%;">No</th>
                        <th class="py-3" style="width: 25%;">Tanggal Setoran</th>
                        <th class="py-3" style="width: 20%;">Jenis & Target</th>
                        <th class="py-3" style="width: 20%;">Capaian (Juz / Surah)</th>
                        <th class="py-3 text-center" style="width: 15%;">Predikat</th>
                        <th class="py-3 text-end pe-4" style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($riwayat) && is_array($riwayat)): ?>
                        <?php $no = 1;
                        foreach ($riwayat as $row): ?>
                            <tr>
                                <td class="ps-4 fw-medium text-muted"><?= $no++; ?></td>
                                <td>
                                    <small class="text-muted" style="font-size: 0.8rem;"><i class="fa-regular fa-calendar me-1"></i> <?= date('d M Y, H:i', strtotime($row['created_at'])); ?> WIB</small>
                                </td>
                                <td>
                                    <?php if (strtolower($row['jenis']) == 'ziyadah'): ?>
                                        <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill small fw-semibold">Ziyadah</span>
                                    <?php else: ?>
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded-pill small fw-semibold">Murojaah</span>
                                    <?php endif; ?>
                                    <small class="text-muted d-block mt-1">Juz <?= esc($row['juz']); ?></small>
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark d-block">Surah <?= esc($row['surah']); ?></span>
                                    <small class="text-muted">Ayat <?= esc($row['ayat_mulai'] ?? '-'); ?> - <?= esc($row['ayat_selesai'] ?? '-'); ?></small>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $predikat = strtolower($row['predikat']);
                                    $badgeClass = 'bg-success text-white';
                                    if ($predikat == 'jayyid jiddan') $badgeClass = 'bg-primary text-white';
                                    elseif ($predikat == 'jayyid') $badgeClass = 'bg-warning text-dark';
                                    ?>
                                    <span class="badge <?= $badgeClass; ?> px-3 py-1 rounded-pill small fw-semibold"><?= esc($row['predikat']); ?></span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="<?= base_url('guru/hafalan/edit/' . $row['id']) ?>" class="btn btn-sm btn-light text-success border-0 rounded-2" title="Edit Detail">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="<?= base_url('guru/hafalan/hapus/' . $row['id']) ?>" class="btn btn-sm btn-light text-danger border-0 rounded-2" title="Hapus Log" onclick="return confirm('Hapus riwayat setoran ini?')">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted small">Belum ada data riwayat setoran hafalan untuk santri ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>