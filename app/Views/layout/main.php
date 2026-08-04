        <?= $this->include('layout/header') ?>

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