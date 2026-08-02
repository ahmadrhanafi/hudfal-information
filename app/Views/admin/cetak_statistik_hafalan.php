<!DOCTYPE html>
<html lang="id">

<?php
/**
 * @var array $capaian_juz
 * @var string $nama_kelas
 * @var string $periode
 * @var float|int $rata_setoran
 * @var array{juz: string|int, persen: int|float} $juz_dominan
 * @var string $predikat_umum
 * @var array $grafik_setoran
 */
?>

<head>
    <meta charset="UTF-8">
    <title>Laporan Statistik Global Hafalan Qur'an (<?= strtoupper(str_replace('_', ' ', $periode)); ?>)</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            background: #fff;
            margin: 0;
            padding: 20px;
            font-size: 13px;
            line-height: 1.5;
        }

        .kop-surat {
            width: 100%;
            border-bottom: 3px double #198754;
            padding-bottom: 12px;
            margin-bottom: 25px;
            text-align: center;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-table td {
            vertical-align: middle;
            border: none !important;
            padding: 0;
        }

        .logo-instansi {
            width: 70px;
            height: auto;
        }

        .instansi-info h3 {
            margin: 0;
            color: #198754;
            font-size: 16px;
            text-transform: uppercase;
        }

        .instansi-info h2 {
            margin: 3px 0;
            color: #212529;
            font-size: 18px;
            text-transform: uppercase;
        }

        .instansi-info p {
            margin: 0;
            font-size: 11px;
            color: #6c757d;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #212529;
            margin-bottom: 10px;
            text-transform: uppercase;
            border-left: 4px solid #198754;
            padding-left: 8px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            margin-bottom: 25px;
        }

        table.data-table th,
        table.data-table td {
            border: 1px solid #dee2e6;
            padding: 8px 10px;
            text-align: left;
            font-size: 12px;
        }

        table.data-table th {
            background-color: #198754;
            color: white;
            text-transform: uppercase;
            font-size: 11px;
        }

        .text-center {
            text-align: center !important;
        }

        .footer-sign {
            margin-top: 40px;
            float: right;
            text-align: center;
            width: 200px;
        }

        .footer-sign .space {
            height: 60px;
        }

        .footer-sign .name {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>

<body onload="window.print()">

    <div class="kop-surat">
        <table class="kop-table">
            <tr>
                <td width="15%" class="text-center">
                    <?php
                    $pathLogo = FCPATH . 'logo_hudfal.png';
                    if (file_exists($pathLogo)) {
                        $typeLogo = pathinfo($pathLogo, PATHINFO_EXTENSION);
                        $dataLogo = file_get_contents($pathLogo);
                        $base64Logo = 'data:image/' . $typeLogo . ';base64,' . base64_encode($dataLogo);
                    } else {
                        $base64Logo = '';
                    }
                    ?>
                    <?php if (!empty($base64Logo)): ?>
                        <img src="<?= $base64Logo; ?>" alt="Logo" class="logo-instansi">
                    <?php endif; ?>
                </td>
                <td width="85%" class="instansi-info" style="text-align: left; padding-left: 10px;">
                    <h3>Laporan Analitik & Statistik Global Hafalan Al-Qur'an</h3>
                    <h3 style="color: #212529;">HUDFAL INFORMATION SYSTEM - PERIODE: <?= strtoupper(str_replace('_', ' ', $periode)); ?></h3>
                    <p>Pesantren Hudatul Falah • Website: https://hudfal-information.test</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">Ringkasan Eksekutif Statistik Global</div>
    <table class="data-table">
        <tr>
            <th width="40%">Metrik Analitik</th>
            <th width="60%">Hasil Kalkulasi Keseluruhan</th>
        </tr>
        <tr>
            <td>Rata-rata Setoran Harian</td>
            <td><strong><?= esc((string) $rata_setoran); ?> Ayat / Hari</strong></td>
        </tr>
        <tr>
            <td>Juz Paling Banyak Disetor</td>
            <td><strong>Juz <?= esc((string) ($juz_dominan['juz'] ?? '-')); ?> (<?= esc((string) ($juz_dominan['persen'] ?? 0)); ?>%)</strong></td>
        </tr>
        <tr>
            <td>Predikat Terdominasi</td>
            <td><strong><?= esc((string) $predikat_umum); ?></strong></td>
        </tr>
    </table>

    <div class="section-title">Akumulasi Capaian per Juz</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="10%" class="text-center">No</th>
                <th width="65%">Kategori / Juz</th>
                <th width="25%" class="text-center">Persentase Capaian</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($capaian_juz)): ?>
                <?php $no = 1;
                foreach ($capaian_juz as $juz): ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= esc((string) ($juz['nama'] ?? '')); ?></td>
                        <td class="text-center"><strong><?= esc((string) ($juz['persen'] ?? 0)); ?>%</strong></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer-sign">
        <p>Mengetahui,</p>
        <p>Administrator / Pimpinan</p>
        <div class="space"></div>
        <div class="name">Admin Sistem</div>
    </div>

</body>

</html>