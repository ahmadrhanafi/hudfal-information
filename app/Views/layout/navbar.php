<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4 py-2 border-bottom sticky-top transition-base"
    id="mainNavbar">
    <?php
    $role = session()->get('role');
    $dashboardUrl = base_url($role . '/dashboard');
    ?>
    <div class="container-fluid">
        <!-- Brand / Title -->
        <div class="d-flex align-items-center gap-2">
            <!-- Tombol Burger Mobile (Hanya muncul di HP) -->
            <button class="btn btn-link text-dark-mode p-0 d-lg-none" id="sidebarToggle" type="button">
                <i class="fa-solid fa-bars fa-lg"></i>
            </button>

            <div class="d-none d-md-flex align-items-center gap-2">
                <div class="bg-success text-white p-2 rounded-3 d-flex align-items-center justify-content-center"
                    style="width: 30px; height: 30px; font-size: 16px;">
                    <i class="<?= $icon ?? 'fa-solid fa-gauge-high' ?>"></i>
                </div>
                <h5 class="m-0 fw-bold text-dark-mode" style="font-size: 16px;"><?= $title ?? 'Dashboard' ?></h5>
            </div>
        </div>

        <!-- Right Side: Dark Mode Toggle & User Dropdown -->
        <div class="d-flex align-items-center gap-3">
            <!-- User Dropdown Menu -->
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle-no-caret"
                    id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="me-3 text-end d-none d-sm-block">
                        <div class="small fw-bold text-dark-mode" style="font-size: 12px;"><?= session()->get('name') ?>
                        </div>
                        <?php if (session()->get('role') == 'guru'): ?>
                            <div class="ket-user">
                                <span class="text-dark-mode" style="font-size: 8px;">Pengampu: </span>
                                <span
                                    class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2"
                                    style="font-size: 8px;">
                                    Kelas <?= session()->get('nama_kelas') ?>
                                </span>
                            </div>
                        <?php else: ?>
                            <span class="text-dark-mode small"
                                style="font-size: 10px;"><?= ucfirst(session()->get('role') ?? 'Wali Santri') ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="position-relative">
                        <?php
                        $fotoUser = session()->get('foto');

                        $pathFile = FCPATH . 'uploads/profile/' . $fotoUser;
                        $urlFoto = '';

                        if (!empty($fotoUser) && file_exists($pathFile)) {
                            $urlFoto = base_url('uploads/profile/' . $fotoUser);
                        } else {
                            $urlFoto = base_url('uploads/profile/default.png');
                        }
                        ?>

                        <img src="<?= $urlFoto; ?>" alt="User" width="38" height="38"
                            class="rounded-circle border border-2 border-white shadow-sm object-fit-cover">
                        <!-- <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-light rounded-circle"
                            style="width: 14px; height: 14px;"></span> -->
                    </div>
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 p-2 rounded-4 animate-fade-in"
                    aria-labelledby="dropdownUser" style="min-width: 220px;">
                    <li class="px-3 py-2 d-sm-none border-bottom mb-2">
                        <div class="fw-bold text-dark"><?= session()->get('name') ?></div>
                        <small
                            class="text-muted"><?= session()->get('role') == 'guru' ? 'Pengampu: ' . session()->get('nama_kelas') : (session()->get('role') == 'wali' ? 'Wali Santri' : 'User') ?></small>
                    </li>
                    <li>
                        <?php if ($role === 'admin'): ?>
                            <a class="dropdown-item rounded-3 py-2 px-3 d-flex align-items-center gap-2 text-dark hover-bg-light transition-base"
                                href="<?= base_url('admin/profile') ?>">
                                <i class="fa-solid fa-user text-success"></i> <span class="small fw-medium">Profile
                                    Saya</span>
                            </a>
                        <?php elseif ($role === 'guru'): ?>
                            <a class="dropdown-item rounded-3 py-2 px-3 d-flex align-items-center gap-2 text-dark hover-bg-light transition-base"
                                href="<?= base_url('guru/profile') ?>">
                                <i class="fa-solid fa-user text-success"></i> <span class="small fw-medium">Profile
                                    Saya</span>
                            </a>
                        <?php elseif ($role === 'wali'): ?>
                            <a class="dropdown-item rounded-3 py-2 px-3 d-flex align-items-center gap-2 text-dark hover-bg-light transition-base"
                                href="<?= base_url('wali/profile') ?>">
                                <i class="fa-solid fa-user text-success"></i> <span class="small fw-medium">Profile
                                    Saya</span>
                            </a>
                        <?php endif; ?>
                    </li>
                    <li>
                        <?php if ($role === 'admin'): ?>
                            <a class="dropdown-item rounded-3 py-2 px-3 d-flex align-items-center gap-2 text-dark hover-bg-light transition-base"
                                href="<?= base_url('admin/pengaturan') ?>">
                                <i class="fa-solid fa-gear text-secondary"></i> <span
                                    class="small fw-medium">Pengaturan</span>
                            </a>
                        <?php elseif ($role === 'guru'): ?>
                            <a class="dropdown-item rounded-3 py-2 px-3 d-flex align-items-center gap-2 text-dark hover-bg-light transition-base"
                                href="<?= base_url('guru/pengaturan') ?>">
                                <i class="fa-solid fa-gear text-secondary"></i> <span
                                    class="small fw-medium">Pengaturan</span>
                            </a>
                        <?php elseif ($role === 'wali'): ?>
                            <a class="dropdown-item rounded-3 py-2 px-3 d-flex align-items-center gap-2 text-dark hover-bg-light transition-base"
                                href="<?= base_url('wali/pengaturan') ?>">
                                <i class="fa-solid fa-gear text-secondary"></i> <span
                                    class="small fw-medium">Pengaturan</span>
                            </a>
                        <?php endif; ?>
                    </li>
                    <!-- Tombol Toggle Dark Mode Pindah ke Sini -->
                    <li>
                        <button
                            class="dropdown-item rounded-3 py-2 px-3 d-flex align-items-center gap-2 text-dark hover-bg-light transition-base w-100 border-0 bg-transparent"
                            id="darkModeToggle" type="button">
                            <i class="fa-solid fa-moon text-warning" id="darkModeIcon"></i> <span
                                class="small fw-medium">Ubah Tema</span>
                        </button>
                    </li>
                    <li>
                        <hr class="dropdown-divider my-2">
                    </li>
                    <li>
                        <a class="dropdown-item rounded-3 py-2 px-3 d-flex align-items-center gap-2 text-danger custom-logout-hover transition-base"
                            href="<?= base_url('logout') ?>">
                            <i class="fa-solid fa-right-from-bracket"></i> <span class="small fw-semibold">Keluar
                                Akun</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<script>
    $(document).ready(function () {
        // Buat elemen backdrop secara otomatis jika belum ada di HTML
        if ($('.sidebar-backdrop').length === 0) {
            $('body').append('<div class="sidebar-backdrop"></div>');
        }

        // Ketika tombol burger menu diklik
        $('#sidebarToggle').on('click', function (e) {
            e.stopPropagation();
            $('#mainSidebar').toggleClass('active');
            $('.sidebar-backdrop').toggleClass('active');
        });

        // Ketika area gelap (backdrop) di luar sidebar diklik, tutup sidebar
        $('.sidebar-backdrop').on('click', function () {
            $('#mainSidebar').removeClass('active');
            $('.sidebar-backdrop').removeClass('active');
        });

        // Opsional: Tutup sidebar otomatis ketika salah satu menu di dalam sidebar diklik (khusus mobile)
        $('#mainSidebar .nav-link').on('click', function () {
            if (window.innerWidth <= 992) {
                $('#mainSidebar').removeClass('active');
                $('.sidebar-backdrop').removeClass('active');
            }
        });
    });

    // toggle dark mode
    document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.getElementById('darkModeToggle');
        const darkModeIcon = document.getElementById('darkModeIcon');
        const body = document.body;

        // Cek localStorage apakah sebelumnya sudah aktif mode gelap
        if (localStorage.getItem('theme') === 'dark') {
            body.classList.add('dark-mode');
            darkModeIcon.classList.remove('fa-moon', 'text-secondary');
            darkModeIcon.classList.add('fa-sun', 'text-warning');
        }

        // Event listener saat tombol dark mode diklik
        toggleBtn.addEventListener('click', function () {
            body.classList.toggle('dark-mode');

            if (body.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark');
                darkModeIcon.classList.remove('fa-moon', 'text-secondary');
                darkModeIcon.classList.add('fa-sun', 'text-warning');
            } else {
                localStorage.setItem('theme', 'light');
                darkModeIcon.classList.remove('fa-sun', 'text-warning');
                darkModeIcon.classList.add('fa-moon', 'text-secondary');
            }
        });
    });
</script>