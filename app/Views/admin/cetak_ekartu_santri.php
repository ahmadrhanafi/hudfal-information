<?php
/**
 * @var array $santri
 */

// Load Gambar Bagian Depan
$pathImgDepan = FCPATH . 'assets/img/depan_kartu.png';
$base64ImgDepan = '';
if (file_exists($pathImgDepan)) {
    $type = pathinfo($pathImgDepan, PATHINFO_EXTENSION);
    $data = file_get_contents($pathImgDepan);
    $base64ImgDepan = 'data:image/' . $type . ';base64,' . base64_encode($data);
}

// Load Gambar Bagian Belakang
$pathImgBelakang = FCPATH . 'assets/img/belakang_kartu.png';
$base64ImgBelakang = '';
if (file_exists($pathImgBelakang)) {
    $type = pathinfo($pathImgBelakang, PATHINFO_EXTENSION);
    $data = file_get_contents($pathImgBelakang);
    $base64ImgBelakang = 'data:image/' . $type . ';base64,' . base64_encode($data);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>E-Kartu Santri - <?= esc($santri['nama_santri'] ?? ''); ?></title>
    <style>
        @page {
            size: 8.56cm 5.4cm;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }

        .card {
            width: 8.56cm;
            height: 5.4cm;
            position: relative;
            box-sizing: border-box;
            page-break-after: always;
            overflow: hidden;
        }

        .bg-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 8.56cm;
            height: 5.4cm;
            z-index: -1;
        }

        /* Area Foto Santri */
        .photo-box {
            position: absolute;
            left: 0.65cm;
            top: 1.55cm;
            width: 2.15cm;
            height: 2.9cm;
            background: #ffffff;
            overflow: hidden;
        }

        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .default-user {
            text-align: center;
            padding-top: 1cm;
            font-size: 20px;
            color: #94a3b8;
        }

        /* Posisi HANYA untuk Isi Datanya Saja */
        .val-text {
            position: absolute;
            left: 4.6cm;
            font-size: 7.5px;
            color: #0a2540;
            font-weight: bold;
        }

        .pos-nama {
            top: 2.38cm;
        }

        .pos-nis {
            top: 2.80cm;
        }

        .pos-ttl {
            top: 3.14cm;
        }

        .pos-hp {
            top: 3.54cm;
        }

        .pos-alamat {
            top: 3.94cm;
            width: 3.8cm;
            line-height: 1.1;
        }
    </style>
</head>

<body>

    <!-- ================= KARTU BAGIAN DEPAN ================= -->
    <div class="card">
        <?php if (!empty($base64ImgDepan)): ?>
            <img src="<?= $base64ImgDepan; ?>" class="bg-image">
        <?php endif; ?>

        <!-- Foto Santri (Jika ingin diaktifkan, hapus komentar) -->
        <!-- <div class="photo-box">
            <?php if (!empty($santri['foto']) && file_exists(FCPATH . 'uploads/santri/' . $santri['foto'])): ?>
                <img src="<?= base_url('uploads/santri/' . $santri['foto']); ?>" alt="Foto">
            <?php else: ?>
                <div class="default-user">👤</div>
            <?php endif; ?>
        </div> -->

        <div class="val-text pos-nama"><?= esc($santri['nama_santri'] ?? ''); ?></div>
        <div class="val-text pos-nis" style="font-family: monospace;"><?= esc($santri['nis'] ?? ''); ?></div>
        <div class="val-text pos-ttl">
            <?= esc(($santri['tempat_lahir'] ?? '-') . ', ' . ($santri['tgl_lahir'] ?? '-')); ?>
        </div>
        <div class="val-text pos-hp"><?= esc($santri['no_hp_wali'] ?? '-'); ?></div>
        <div class="val-text pos-alamat"><?= esc($santri['alamat_wali'] ?? '-'); ?></div>
    </div>


    <!-- ================= KARTU BAGIAN BELAKANG ================= -->
    <div class="card" style="page-break-after: avoid;">
        <?php if (!empty($base64ImgBelakang)): ?>
            <img src="<?= $base64ImgBelakang; ?>" class="bg-image">
        <?php endif; ?>

        <!-- Tambahkan teks atau elemen tambahan di bagian belakang di sini jika diperlukan -->
    </div>

</body>

</html>