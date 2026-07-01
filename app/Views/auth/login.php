<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Hudfal Information</title>
    <link rel="shortcut icon" href="<?= base_url('logo_hudfal.png') ?>" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e970e 0%, #aabda8 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 40px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .btn-custom {
            background-color: #1e970e;
            color: white;
            font-weight: 600;
            padding: 12px;
            border-radius: 10px;
            transition: 0.3s;
        }

        .btn-custom:hover {
            background-color: #156d0a;
            color: white;
            transform: translateY(-2px);
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #ddd;
        }

        .form-control:focus {
            border-color: #1e970e;
            box-shadow: 0 0 0 0.25rem rgba(30, 151, 14, 0.25);
        }

        .input-group .btn {
            border-left: none;
            background: white;
            color: #6c757d;
        }

        .input-group .btn:hover {
            background: #f8f9fa;
            color: #1e970e;
        }

        .input-group .form-control:focus+.btn {
            border-color: #1e970e;
        }

        .text-green {
            color: #1e970e !important;
        }

        .text-muted-gray {
            color: #6c757d !important;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="login-card">
            <div class="text-center mb-4">
                <h3 class="fw-bold" style="color: #1e970e;">Selamat Datang</h3>
                <p class="text-muted">Silahkan Login ke Hudfal Information</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div id="flash-alert" class="alert alert-danger border-0 rounded-3 text-center">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/process') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label fw-bold" style="font-size: 0.8rem; color: #1e970e;">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold" style="font-size: 0.8rem; color: #1e970e;">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword" style="border-color: #ddd;">
                            <i class="fa-solid fa-eye text-muted-gray" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn btn-custom w-100 shadow-sm">Login Sekarang</button>
            </form>
        </div>
    </div>

    <script>
        // Alert Duration
        window.setTimeout(function() {
            const alertElement = document.getElementById('flash-alert');
            if (alertElement) {
                // Kita pakai fade out transisi dulu biar mulus
                alertElement.style.transition = "opacity 0.5s ease";
                alertElement.style.opacity = "0";

                // Setelah transisi selesai, hapus elemennya dari halaman
                window.setTimeout(function() {
                    alertElement.remove();
                }, 500);
            }
        }, 3000);

        // Toogle Eye Icon
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function(e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');

            if (type === 'text') {
                eyeIcon.classList.remove('text-muted-gray');
                eyeIcon.classList.add('text-green');
            } else {
                eyeIcon.classList.remove('text-green');
                eyeIcon.classList.add('text-muted-gray');
            }
        });
    </script>
</body>

</html>