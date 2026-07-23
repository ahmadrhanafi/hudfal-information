<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hudfal Information | <?= $title ?? 'Dashboard' ?></title>
    <link rel="shortcut icon" href="<?= base_url('logo_hudfal.png') ?>" type="image/png">

    <!-- Bootstrap 5.3 & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-bg: #0b1917;
            --main-bg: #f4f7f6;
            --accent-green: #8BAE66;
            --dark-card: #ffffff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--main-bg);
            color: #334155;
            overflow-x: hidden;
        }

        /* --- Sidebar Styling Profesional --- */
        .sidebar {
            background: var(--sidebar-bg);
            min-height: 100vh;
            width: 270px;
            transition: all 0.3s ease-in-out;
            z-index: 1050;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.05);
        }

        .sidebar .logo-box {
            padding: 24px 20px 16px 20px;
        }

        .nav-link {
            color: #94a3b8 !important;
            padding: 12px 18px;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            border-radius: 10px;
            margin: 4px 12px;
            transition: all 0.2s ease;
        }

        /* --- Pengaturan Ikon FontAwesome agar Lebih Mantap --- */
        .nav-link i {
            font-size: 1.1rem;
            width: 28px;
            /* Memberikan ruang tetap agar teks menu sejajar rapi */
            text-align: center;
            margin-right: 12px;
            /* Jarak pas antara ikon dan teks */
            transition: transform 0.2s ease, color 0.2s ease;
            color: #8BAE66;
            /* Memberikan warna aksen hijau khas pada ikon */
        }

        .nav-link:hover {
            background: rgba(139, 174, 102, 0.1);
            color: var(--accent-green) !important;
        }

        .nav-link:hover i {
            transform: scale(1.15) translateX(2px);
            /* Efek membesar sedikit saat di-hover */
            color: #ffffff;
        }

        .nav-link.active {
            background: var(--accent-green);
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(139, 174, 102, 0.3);
        }

        /* Ikon pada menu yang sedang aktif otomatis berubah jadi putih */
        .nav-link.active i {
            color: #ffffff !important;
        }

        .custom-divider {
            width: 75%;
            height: 2px;
            background: rgba(139, 174, 102, 0.3);
            margin: 12px auto;
            border-radius: 2px;
        }

        /* --- Navbar Atas (Header) --- */
        .navbar-main {
            background: #ffffff !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            height: 70px;
            padding: 0 24px;
        }

        /* --- Main Content Area --- */
        main {
            padding: 28px;
            min-height: calc(100vh - 70px);
        }

        /* Responsive Mobile Handling */
        @media (max-width: 992px) {
            .sidebar {
                position: fixed;
                left: -270px;
            }

            .sidebar.active {
                left: 0;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <?= $this->include('layout/sidebar') ?>

        <!-- Content Wrapper -->
        <div class="flex-grow-1 d-flex flex-column">
            <!-- Navbar / Header -->
            <?= $this->include('layout/navbar') ?>

            <!-- Page Main Content -->
            <main>
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>