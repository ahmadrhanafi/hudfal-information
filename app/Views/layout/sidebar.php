<aside class="sidebar d-flex flex-column">
    <div class="d-flex align-items-center gap-3" style="padding: 25px;">
        <img src="<?= base_url('logo_hudfal.png') ?>" alt="Logo" style="width: 50px;">
        <div class="text-white">
            <h6 class="m-0 fw-bold" style="font-size: 1.8rem;">HUDFAL</h6>
            <small style="font-size: 0.9rem; font-weight: 1000; color: #8BAE66; letter-spacing: 1px;">INFORMATION</small>
        </div>
    </div>

    <!-- <div class="custom-divider"></div> -->

    <nav class="nav flex-column mt-3">
        <a href="<?= base_url('dashboard') ?>" class="nav-link <?= (url_is('dashboard')) ? 'active' : '' ?>">
            <i class="fa-solid fa-gauge-high me-3"></i> Dashboard
        </a>

        <?php $role = session()->get('role'); ?>

        <?php if ($role === 'admin'): ?>
            <a href="<?= base_url('admin/ustadz') ?>" class="nav-link"><i class="fa-solid fa-chalkboard-user me-2"></i> Data Ustadz</a>
            <a href="<?= base_url('admin/santri') ?>" class="nav-link"><i class="fa-solid fa-user-graduate me-2"></i> Data Santri</a>
            <a href="<?= base_url('admin/hafalan') ?>" class="nav-link"><i class="fa-solid fa-book-quran me-2"></i> Data Hafalan</a>
            <a href="<?= base_url('admin/statistik') ?>" class="nav-link"><i class="fa-solid fa-chart-line me-2"></i> Statistik Hafalan</a>
            <a href="<?= base_url('admin/administrasi') ?>" class="nav-link"><i class="fa-solid fa-file-invoice-dollar me-2"></i> Administrasi</a>
            <a href="<?= base_url('admin/sertifikat') ?>" class="nav-link"><i class="fa-solid fa-id-card me-2"></i> E-Sertifikat</a>
            <a href="<?= base_url('admin/kartu') ?>" class="nav-link"><i class="fa-solid fa-id-card me-2"></i> E-Kartu Santri</a>
        <?php endif; ?>

        <?php if ($role === 'ustadz'): ?>
            <a href="<?= base_url('ustadz/santri') ?>" class="nav-link"><i class="fa-solid fa-people-group me-2"></i> Data Santri</a>
            <a href="<?= base_url('ustadz/hafalan') ?>" class="nav-link"><i class="fa-solid fa-book-open me-2"></i> Data Hafalan</a>
            <a href="<?= base_url('ustadz/statistik') ?>" class="nav-link"><i class="fa-solid fa-chart-bar me-2"></i> Statistik Hafalan</a>
        <?php endif; ?>

        <?php if ($role === 'wali'): ?>
            <a href="<?= base_url('wali/hafalan') ?>" class="nav-link"><i class="fa-solid fa-history me-2"></i> Riwayat Hafalan</a>
            <a href="<?= base_url('wali/pembayaran') ?>" class="nav-link"><i class="fa-solid fa-receipt me-2"></i> Riwayat Pembayaran</a>
            <a href="<?= base_url('wali/kartu') ?>" class="nav-link"><i class="fa-solid fa-id-card me-2"></i> E-Kartu Santri</a>
            <a href="<?= base_url('wali/sertifikat') ?>" class="nav-link"><i class="fa-solid fa-id-card me-2"></i> E-Sertifikat</a>
        <?php endif; ?>
    </nav>

    <div class="nav flex-column mt-auto">
        <hr class="text-muted">
        <a href="<?= base_url('settings') ?>" class="nav-link text-white">
            <i class="fa-solid fa-gear me-3"></i> Settings
        </a>
        <a href="<?= base_url('logout') ?>" class="nav-link text-danger" onclick="return confirm('Apakah Anda yakin ingin mengakhiri sesi saat ini?');">
            <i class="fa-solid fa-right-from-bracket me-3"></i> Logout
        </a>
    </div>
</aside>