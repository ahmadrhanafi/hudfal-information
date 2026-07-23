<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hudfal Information | Web Monitoring Hafalan Santri</title>
    <link rel="shortcut icon" href="<?= base_url('logo_hudfal.png') ?>" type="image/png">

    <style>
        body {
            margin: 0;
            background: #D9E9CF;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .logo-load {
            width: 150px;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.9);
                opacity: 0.7;
            }

            50% {
                transform: scale(1.1);
                opacity: 1;
            }

            100% {
                transform: scale(0.9);
                opacity: 0.7;
            }
        }
    </style>
</head>

<body>
    <img src="<?= base_url('logo_hudfal.png') ?>" class="logo-load" alt="Logo">

    <script>
        const userRole = "<?= session()->get('role') ?>";

        let targetUrl = "<?= base_url('admin/dashboard') ?>";

        if (userRole === 'ustadz') {
            targetUrl = "<?= base_url('ustadz/dashboard') ?>";
        } else if (userRole === 'wali') {
            targetUrl = "<?= base_url('wali/dashboard') ?>";
        }

        // Redirect otomatis ke dashboard setelah 2.5 detik
        setTimeout(function() {
            window.location.href = "<?= base_url('dashboard') ?>";
        }, 2500);
    </script>
</body>

</html>