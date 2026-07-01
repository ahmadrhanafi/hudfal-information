<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hudfal Information | <?= $title ?? 'Dashboard' ?></title>
    <link rel="shortcut icon" href="<?= base_url('logo_hudfal.png') ?>" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-bg: #091413;
            --text-muted: #8BAE66;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #D9E9CF;
        }

        /* Sidebar Styling */
        .sidebar {
            background: var(--primary-bg);
            min-height: 100vh;
            width: 280px;
            transition: 0.3s;
        }

        .nav-link {
            color: var(--text-muted) !important;
            padding: 12px 20px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
        }

        .nav-link:hover,
        .nav-link.active {
            background: #8BAE66;
            color: #fff !important;
            border-radius: 8px;
            margin: 0 10px;
        }

        .custom-divider {
            width: 80%;
            height: 3px;
            background: #8BAE66;
            margin: 3px auto;
            border-radius: 2px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -280px;
                z-index: 1000;
            }

            .sidebar.active {
                left: 0;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <?= $this->include('layout/sidebar') ?>

        <div class="flex-grow-1">
            <?= $this->include('layout/navbar') ?>

            <main class="p-4">
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>