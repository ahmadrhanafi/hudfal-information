<?= $this->include('layout/header') ?>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <?= $this->include('layout/sidebar') ?>

        <!-- Content Wrapper (Membungkus Navbar, Main, dan Footer sekaligus) -->
        <div class="flex-grow-1 d-flex flex-column min-vh-100">
            <!-- Navbar / Header -->
            <?= $this->include('layout/navbar') ?>

            <!-- Page Main Content -->
            <main class="flex-grow-1">
                <?= $this->renderSection('content') ?>
            </main>

            <!-- Footer Pindah ke Sini (Di dalam pembungkus sebelah kanan) -->
            <?= $this->include('layout/footer') ?>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>