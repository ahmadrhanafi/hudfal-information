<!DOCTYPE html>
<html>

<head>
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
        // Redirect otomatis ke dashboard setelah 2.5 detik
        setTimeout(function() {
            window.location.href = "<?= base_url('dashboard') ?>";
        }, 2500);
    </script>
</body>

</html>