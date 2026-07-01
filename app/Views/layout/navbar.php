<header class="navbar navbar-expand-lg bg-white shadow-sm px-4 py-2 border-bottom border-light">
    <div class="container-fluid">
        <h6 class="m-0 fw-bold" style="color: #091413;">
            <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
        </h6>

        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false"
                style="color: #a0de8a;">
                <div class="me-3 text-end d-none d-sm-block">
                    <div class="small fw-bold" style="color: #091413;"><?= session()->get('name') ?></div>
                </div>
                <img src="<?= session()->get('foto') ?>" alt="User" width="40" height="40" class="rounded-circle border border-2 border-white shadow-sm">
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2" aria-labelledby="dropdownUser" style="background-color: #a0de8a;">
                <li><a class="dropdown-item" style="font-size: 0.8rem; color: #091413;" href="<?= base_url('profile') ?>"><i class="fa-solid fa-user me-2"></i> Profile</a></li>
                <li><a class="dropdown-item" style="font-size: 0.8rem; color: #091413;" href="<?= base_url('settings') ?>"><i class="fa-solid fa-gear me-2"></i> Settings</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item text-danger" style="font-size: 0.8rem" href="<?= base_url('logout') ?>"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</header>