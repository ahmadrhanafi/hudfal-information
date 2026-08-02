<!DOCTYPE html>
<html lang="id">

<?php
/**
 * @var string $nama_kelas
 * @var string $periode
 * @var float|int $rata_setoran
 * @var array $juz_dominan
 * @var array $predikat_umum
 * @var array $capaian_juz
 * @var array $grafik_setoran
 */
?>

<head>
    <meta charset="UTF-8">
    <title>Laporan Statistik Hafalan Qur'an - Kelas <?= esc($nama_kelas); ?> (<?= strtoupper(str_replace('_', ' ', $periode)); ?>)</title>
    <link rel="shortcut icon" href="<?= base_url('logo_hudfal.png') ?>" type="image/png">

    <style>
        /* Pengaturan Dasar Dokumen Kertas A4 */
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            background-color: #ffffff;
            margin: 0;
            padding: 20px;
            font-size: 13px;
            line-height: 1.5;
        }

        /* Gaya Kop Surat Resmi */
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
            letter-spacing: 0.5px;
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

        /* Bagian Ringkasan Statistik (Cards Layout) */
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #212529;
            margin-bottom: 10px;
            text-transform: uppercase;
            border-left: 4px solid #198754;
            padding-left: 8px;
        }

        .summary-container {
            display: table;
            width: 100%;
            margin-bottom: 25px;
            table-layout: fixed;
        }

        .summary-card {
            display: table-cell;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 12px;
            text-align: center;
            width: 33.33%;
        }

        .summary-card+.summary-card {
            border-left: none;
            /* Supaya garis tidak menumpuk */
        }

        /* Teknik wrapper aman untuk jarak antar kolom di cetakan */
        .card-inner {
            padding: 0 5px;
        }

        .summary-card .label {
            font-size: 11px;
            color: #6c757d;
            text-transform: uppercase;
            margin-bottom: 4px;
            display: block;
        }

        .summary-card .value {
            font-size: 14px;
            font-weight: bold;
            color: #212529;
        }

        /* Tabel Rincian Data */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
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
            letter-spacing: 0.3px;
        }

        table.data-table tbody tr:nth-child(even) {
            background-color: #fcfcfc;
        }

        .text-center {
            text-align: center !important;
        }

        /* Tanda Tangan / Footer Dokumen */
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

        /* Pengaturan Khusus Media Print (Cetak Otomatis) */
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background-color: white;
                color: black;
                padding: 0;
            }

            @page {
                size: A4;
                margin: 1.5cm;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <?php
    /**
     * @var string $nama_guru
     * @var string $nama_kelas
     * @var string $periode
     * @var float|int $rata_setoran
     * @var array $juz_dominan
     * @var array $predikat_umum
     * @var array $detail_hafalan
     */
    ?>

    <!-- KOP SURAT RESMI -->
    <div class="kop-surat">
        <table class="kop-table">
            <tr>
                <td width="15%" class="text-center">
                    <?php
                    $pathLogo = FCPATH . 'logo_hudfal.png';
                    $typeLogo = pathinfo($pathLogo, PATHINFO_EXTENSION);
                    $dataLogo = file_get_contents($pathLogo);
                    $base64Logo = 'data:image/' . $typeLogo . ';base64,' . base64_encode($dataLogo);
                    ?>

                    <img src="<?= $base64Logo; ?>" alt="Logo" class="logo-instansi">
                </td>
                <td width="85%" class="instansi-info" style="text-align: left; padding-left: 10px;">
                    <h3>Laporan Resmi Perkembangan Hafalan Al-Qur'an</h3>
                    <h3 style="color: #212529;">HUDFAL INFORMATION SYSTEM - MONITORING HAFALAN</h3>
                    <p>Jl. Pendidikan / Pesantren Hudatul Falah • Website: https://hudfal-information.test</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Ringkasan Statistik Bentuk Kotak/Card -->
    <div class="section-title">Rincian Data Hafalan Santri</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="6%" class="text-center">No</th>
                <th width="18%">Tanggal</th>
                <th width="24%">Nama Santri</th>
                <th width="28%">Capaian Juz & Surat</th>
                <th width="12%">Ayat</th>
                <th width="12%">Predikat</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($detail_hafalan)): ?>
                <?php $no = 1;
                foreach ($detail_hafalan as $row): ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <?php
                        // Buat array kamus nama hari Indonesia
                        $namaHari = [
                            'Sun' => 'Minggu',
                            'Mon' => 'Senin',
                            'Tue' => 'Selasa',
                            'Wed' => 'Rabu',
                            'Thu' => 'Kamis',
                            'Fri' => 'Jumat',
                            'Sat' => 'Sabtu'
                        ];

                        $timestamp = strtotime($row['created_at'] ?? 'now');
                        $hariInggris = date('D', $timestamp);
                        $hariIndonesia = $namaHari[$hariInggris] ?? '';
                        $tanggalFormatted = date('d-m-Y', $timestamp); // Atau gunakan 'd F Y' jika ingin bulan huruf (contoh: 02 Agustus 2026)
                        ?>

                        <td><?= $hariIndonesia . ', ' . $tanggalFormatted; ?></td>
                        <td><strong><?= esc($row['nama_santri'] ?? '-'); ?></strong></td>
                        <td>Juz <?= esc($row['juz']); ?> (<?= esc($row['surah'] ?? $row['nama_surah'] ?? '-'); ?>)</td>
                        <td><?= esc($row['ayat_mulai']); ?> - <?= esc($row['ayat_selesai']); ?></td>
                        <td><?= esc($row['predikat']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px; color: #6c757d;">
                        <em>Tidak ada data riwayat hafalan pada periode ini.</em>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Tanda Tangan Pengajar -->
    <div class="footer-sign">
        <p>Mengetahui,</p>
        <p>Guru Pengampu Kelas</p>
        <div class="space"></div>
        <div class="name"><?= esc($nama_guru); ?></div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>