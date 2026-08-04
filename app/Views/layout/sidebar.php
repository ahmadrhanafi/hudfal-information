<aside class="sidebar d-flex flex-column transition-base" id="mainSidebar">
    <!-- Logo & Brand Header -->
    <div class="d-flex align-items-center gap-3 px-4 pt-4 pb-3">
        <img src="<?= base_url('logo_hudfal.png') ?>" alt="Logo Hudfal" style="width: 40px; height: auto;">
        <div>
            <h5 class="m-0 fw-bold tracking-wide text-white" style="font-size: 1.4rem; letter-spacing: 0.5px;">HUDFAL</h5>
            <small style="font-size: 0.7rem; font-weight: 700; color: #8BAE66; letter-spacing: 1.5px;">INFORMATION</small>
        </div>
    </div>

    <!-- Garis Pemisah Custom -->
    <div class="custom-divider mx-3 my-1"></div>

    <!-- Navigasi Menu Utama -->
    <nav class="nav flex-column my-2 flex-grow-1 px-2">
        <?php
        $role = session()->get('role');
        $dashboardUrl = base_url($role . '/dashboard');
        ?>

        <!-- Link Dashboard Umum -->
        <div class="text-uppercase small px-3 mt-3 mb-1 text-sidebar-label" style="font-size: 0.65rem; color: #8BAE66; letter-spacing: 1px;">Overview</div>
        <a href="<?= $dashboardUrl ?>" class="nav-link px-3 py-2 rounded-3 mb-1 <?= (current_url() == $dashboardUrl) ? 'active' : '' ?>">
            <i class="fa-solid fa-gauge-high fa-fw me-2"></i> <span>Dashboard</span>
        </a>

        <!-- MENU KHUSUS ADMIN -->
        <?php if ($role === 'admin'): ?>
            <div class="text-uppercase small px-3 mt-3 mb-1 text-sidebar-label" style="font-size: 0.65rem; color: #8BAE66; letter-spacing: 1px;">Menu Admin</div>
            <a href="<?= base_url('admin/kelas') ?>" class="nav-link px-3 py-2 rounded-3 mb-1 <?= (url_is('admin/kelas*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-school fa-fw me-2"></i> <span>Data Kelas</span>
            </a>
            <a href="<?= base_url('admin/santri') ?>" class="nav-link px-3 py-2 rounded-3 mb-1 <?= (url_is('admin/santri*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-user-graduate fa-fw me-2"></i> <span>Data Santri</span>
            </a>
            <a href="<?= base_url('admin/ustadz') ?>" class="nav-link px-3 py-2 rounded-3 mb-1 <?= (url_is('admin/ustadz*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-chalkboard-user fa-fw me-2"></i> <span>Data Ustadz</span>
            </a>
            <a href="<?= base_url('admin/wali-santri') ?>" class="nav-link px-3 py-2 rounded-3 mb-1 <?= (url_is('admin/wali-santri*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-users fa-fw me-2"></i> <span>Data Wali Santri</span>
            </a>
            <a href="<?= base_url('admin/hafalan') ?>" class="nav-link px-3 py-2 rounded-3 mb-1 <?= (url_is('admin/hafalan*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-book-quran fa-fw me-2"></i> <span>Data Hafalan</span>
            </a>
            <a href="<?= base_url('admin/statistik-hafalan') ?>" class="nav-link px-3 py-2 rounded-3 mb-1 <?= (url_is('admin/statistik-hafalan*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-chart-line fa-fw me-2"></i> <span>Statistik Hafalan</span>
            </a>
            <a href="<?= base_url('admin/administrasi') ?>" class="nav-link px-3 py-2 rounded-3 mb-1 <?= (url_is('admin/administrasi*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-file-invoice-dollar fa-fw me-2"></i> <span>Administrasi</span>
            </a>
            <!-- <a href="<?= base_url('admin/esertifikat') ?>" class="nav-link px-3 py-2 rounded-3 mb-1 <?= (url_is('admin/esertifikat*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-award fa-fw me-2"></i> <span>E-Sertifikat</span>
            </a> -->
        <?php endif; ?>

        <!-- MENU KHUSUS GURU/PENGAJAR -->
        <?php if ($role === 'guru'): ?>
            <div class="text-uppercase small px-3 mt-3 mb-1 text-sidebar-label" style="font-size: 0.65rem; color: #8BAE66; letter-spacing: 1px;">Menu Pengajar</div>
            <a href="<?= base_url('guru/santri') ?>" class="nav-link px-3 py-2 rounded-3 mb-1 <?= (url_is('guru/santri*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-people-group fa-fw me-2"></i> <span>Data Santri</span>
            </a>
            <a href="<?= base_url('guru/hafalan') ?>" class="nav-link px-3 py-2 rounded-3 mb-1 <?= (url_is('guru/hafalan*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-book-open fa-fw me-2"></i> <span>Data Hafalan</span>
            </a>
            <a href="<?= base_url('guru/statistik-hafalan') ?>" class="nav-link px-3 py-2 rounded-3 mb-1 <?= (url_is('guru/statistik-hafalan*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-chart-bar fa-fw me-2"></i> <span>Statistik Hafalan</span>
            </a>
            <a href="<?= base_url('guru/riwayat-hafalan') ?>" class="nav-link px-3 py-2 rounded-3 mb-1 <?= (url_is('guru/riwayat-hafalan*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-history fa-fw me-2"></i> <span>Riwayat Hafalan</span>
            </a>
        <?php endif; ?>

        <!-- MENU KHUSUS WALI SANTRI -->
        <?php if ($role === 'wali'): ?>
            <div class="text-uppercase small px-3 mt-3 mb-1 text-sidebar-label" style="font-size: 0.65rem; color: #8BAE66; letter-spacing: 1px;">Menu Wali</div>
            <a href="<?= base_url('wali/statistik-hafalan') ?>" class="nav-link px-3 py-2 rounded-3 mb-1 <?= (url_is('wali/statistik-hafalan*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-chart-bar fa-fw me-2"></i> <span>Statistik Hafalan</span>
            </a>
            <a href="<?= base_url('wali/riwayat-hafalan') ?>" class="nav-link px-3 py-2 rounded-3 mb-1 <?= (url_is('wali/riwayat-hafalan*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-history fa-fw me-2"></i> <span>Riwayat Hafalan</span>
            </a>
            <a href="<?= base_url('wali/riwayat-tagihan') ?>" class="nav-link px-3 py-2 rounded-3 mb-1 <?= (url_is('wali/riwayat-tagihan*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-receipt fa-fw me-2"></i> <span>Riwayat Tagihan</span>
            </a>
            <!-- <a href="<?= base_url('wali/esertifikat') ?>" class="nav-link px-3 py-2 rounded-3 mb-1 <?= (url_is('wali/esertifikat*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-award fa-fw me-2"></i> <span>E-Sertifikat</span>
            </a> -->
        <?php endif; ?>
    </nav>

    <!-- Menu Bagian Bawah (Settings & Logout) -->
    <div class="nav flex-column mt-auto pb-3 px-2">
        <div class="custom-divider mx-3 mb-2"></div>

        <?php if ($role === 'admin'): ?>
            <a href="<?= base_url('admin/pengaturan') ?>" class="nav-link px-3 py-2 rounded-3 mb-1 text-white <?= (url_is('pengaturan*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-gear fa-fw me-2"></i> <span>Settings</span>
            </a>
        <?php elseif ($role === 'guru'): ?>
            <a href="<?= base_url('guru/pengaturan') ?>" class="nav-link px-3 py-2 rounded-3 mb-1 text-white <?= (url_is('settings*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-gear fa-fw me-2"></i> <span>Settings</span>
            </a>
        <?php elseif ($role === 'wali'): ?>
            <a href="<?= base_url('wali/pengaturan') ?>" class="nav-link px-3 py-2 rounded-3 mb-1 text-white <?= (url_is('settings*')) ? 'active' : '' ?>">
                <i class="fa-solid fa-gear fa-fw me-2"></i> <span>Settings</span>
            </a>
        <?php endif; ?>

        <a href="<?= base_url('logout') ?>" class="nav-link px-3 py-2 rounded-3 text-danger hover-danger-bg" onclick="return confirm('Apakah Anda yakin ingin mengakhiri sesi saat ini?');">
            <i class="fa-solid fa-right-from-bracket fa-fw me-2"></i> <span>Logout</span>
        </a>
    </div>
</aside>