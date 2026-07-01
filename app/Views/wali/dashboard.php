<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-body p-4">
        <h3 class="fw-bold">Selamat Datang, <?php echo session()->get('name'); ?>!</h3>
        <p>Silakan pantau riwayat hafalan anak Anda di sini.</p>
    </div>
</div>
<?= $this->endSection() ?>