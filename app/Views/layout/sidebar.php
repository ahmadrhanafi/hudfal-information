<aside class="sidebar d-flex flex-column">
    <!-- Logo & Brand Header -->
    <div class="d-flex align-items-center gap-3 px-4 pt-4 pb-3">
        <img src="<?= base_url('logo_hudfal.png') ?>" alt="Logo Hudfal" style="width: 42px; height: auto;">
        <div class="text-white">
            <h5 class="m-0 fw-bold tracking-wide" style="font-size: 1.5rem; letter-spacing: 0.5px;">HUDFAL</h5>
            <small style="font-size: 0.75rem; font-weight: 700; color: #8BAE66; letter-spacing: 1.5px;">INFORMATION</small>
        </div>
    </div>

    <!-- Garis Pemisah Custom (Diaktifkan kembali dengan gaya minimalis) -->
    <div class="custom-divider"></div>

    <!-- Navigasi Menu Utama -->
    <nav class="nav flex-column my-2 flex-grow-1">
        <?php
        $role = session()->get('role');
        $dashboardUrl = base_url($role . '/dashboard');
        ?>

        <!-- Link Dashboard Umum (Aktif jika sesuai URL saat ini) -->
        <a href="<?= $dashboardUrl ?>" class="nav-link <?= (current_url() == $dashboardUrl) ? 'active' : '' ?>">
            <i class="fa-solid fa-gauge-high"></i> <span>Dashboard</span>
        </a>

        <!-- MENU KHUSUS ADMIN -->
        <?php if ($role === 'admin'): ?>
            <div class="text-uppercase small px-4 mt-3 mb-1" style="font-size: 0.65rem; color: #8BAE66; letter-spacing: 1px;">Menu Admin</div>
            <a href="<?= base_url('admin/ustadz') ?>" class="nav-link <?= (url_is('admin/ustadz*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-chalkboard-user"></i> <span>Data Ustadz</span>
            </a>
            <a href="<?= base_url('admin/santri') ?>" class="nav-link <?= (url_is('admin/santri*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-user-graduate"></i> <span>Data Santri</span>
            </a>
            <a href="<?= base_url('admin/hafalan') ?>" class="nav-link <?= (url_is('admin/hafalan*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-book-quran"></i> <span>Data Hafalan</span>
            </a>
            <a href="<?= base_url('admin/statistik') ?>" class="nav-link <?= (url_is('admin/statistik*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-chart-line"></i> <span>Statistik Hafalan</span>
            </a>
            <a href="<?= base_url('admin/administrasi') ?>" class="nav-link <?= (url_is('admin/administrasi*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-file-invoice-dollar"></i> <span>Administrasi</span>
            </a>
            <a href="<?= base_url('admin/esertifikat') ?>" class="nav-link <?= (url_is('admin/esertifikat*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-award"></i> <span>E-Sertifikat</span>
            </a>
            <a href="<?= base_url('admin/ekartu') ?>" class="nav-link <?= (url_is('admin/ekartu*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-id-card"></i> <span>E-Kartu Santri</span>
            </a>
        <?php endif; ?>

        <!-- MENU KHUSUS USTADZ -->
        <?php if ($role === 'ustadz'): ?>
            <div class="text-uppercase small px-4 mt-3 mb-1" style="font-size: 0.65rem; color: #8BAE66; letter-spacing: 1px;">Menu Ustadz</div>
            <a href="<?= base_url('ustadz/santri') ?>" class="nav-link <?= (url_is('ustadz/santri*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-people-group"></i> <span>Data Santri</span>
            </a>
            <a href="<?= base_url('ustadz/hafalan') ?>" class="nav-link <?= (url_is('ustadz/hafalan*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-book-open"></i> <span>Data Hafalan</span>
            </a>
            <a href="<?= base_url('ustadz/statistik') ?>" class="nav-link <?= (url_is('ustadz/statistik*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-chart-bar"></i> <span>Statistik Hafalan</span>
            </a>
        <?php endif; ?>

        <!-- MENU KHUSUS WALI SANTRI -->
        <?php if ($role === 'wali'): ?>
            <div class="text-uppercase small px-4 mt-3 mb-1" style="font-size: 0.65rem; color: #8BAE66; letter-spacing: 1px;">Menu Wali</div>
            <a href="<?= base_url('wali/riwayat-hafalan') ?>" class="nav-link <?= (url_is('wali/riwayat-hafalan*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-history"></i> <span>Riwayat Hafalan</span>
            </a>
            <a href="<?= base_url('wali/riwayat-pembayaran') ?>" class="nav-link <?= (url_is('wali/riwayat-pembayaran*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-receipt"></i> <span>Riwayat Pembayaran</span>
            </a>
            <a href="<?= base_url('wali/ekartu') ?>" class="nav-link <?= (url_is('wali/ekartu*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-id-card"></i> <span>E-Kartu Santri</span>
            </a>
            <a href="<?= base_url('wali/esertifikat') ?>" class="nav-link <?= (url_is('wali/esertifikat*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-award"></i> <span>E-Sertifikat</span>
            </a>
        <?php endif; ?>
    </nav>

    <!-- Menu Bagian Bawah (Settings & Logout) -->
    <div class="nav flex-column mt-auto pb-3">
        <div class="custom-divider mb-2"></div>
        <?php if ($role === 'admin'): ?>
            <a href="<?= base_url('admin/pengaturan') ?>" class="nav-link text-white <?= (url_is('settings*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-gear"></i> <span>Settings</span>
            </a>
        <?php elseif ($role === 'ustadz'): ?>
            <a href="<?= base_url('ustadz/pengaturan') ?>" class="nav-link text-white <?= (url_is('settings*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-gear"></i> <span>Settings</span>
            </a>
        <?php elseif ($role === 'wali'): ?>
            <a href="<?= base_url('wali/pengaturan') ?>" class="nav-link text-white <?= (url_is('settings*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-gear"></i> <span>Settings</span>
            </a>
        <?php endif; ?>

        <a href="<?= base_url('logout') ?>" class="nav-link text-danger" onclick="return confirm('Apakah Anda yakin ingin mengakhiri sesi saat ini?');">
            <i class="fa-solid fa-right-from-bracket"></i> <span>Logout</span>
        </a>
    </div>
</aside>