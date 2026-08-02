<!DOCTYPE html>
<html lang="id">

<?php
/**
 * @var string $nama_guru
 * @var string $nama_kelas
 * @var array $santri
 */
?>

<head>
    <meta charset="UTF-8">
    <title>Laporan Data Santri Binaan - Kelas <?= esc($nama_kelas); ?></title>
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

        /* Bagian Judul Section */
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #212529;
            margin-bottom: 10px;
            text-transform: uppercase;
            border-left: 4px solid #198754;
            padding-left: 8px;
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

    <!-- KOP SURAT RESMI -->
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
                    <h3>Laporan Resmi Data Santri Binaan</h3>
                    <h3 style="color: #212529;">HUDFAL INFORMATION SYSTEM - KELAS <?= strtoupper(esc($nama_kelas)); ?></h3>
                    <p>Jl. Pendidikan / Pesantren Hudatul Falah • Website: https://hudfal-information.test</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Tabel Daftar Santri -->
    <div class="section-title">Daftar Santri Binaan (Kelas: <?= esc($nama_kelas); ?>)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="6%" class="text-center">No</th>
                <th width="20%">NIS</th>
                <th width="42%">Nama Santri</th>
                <th width="42%">Nama Wali</th>
                <th width="16%" class="text-center">Jenis Kelamin</th>
                <th width="16%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($santri)): ?>
                <?php $no = 1;
                foreach ($santri as $s): ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= esc($s['nis'] ?? '-'); ?></td>
                        <td><strong><?= esc($s['nama_santri'] ?? '-'); ?></strong></td>
                        <td><strong><?= esc($s['nama_wali'] ?? '-'); ?></strong></td>
                        <td class="text-center"><?= esc($s['jenis_kelamin'] ?? '-'); ?></td>
                        <td class="text-center"><?= esc($s['status'] ?? 'Aktif'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center" style="padding: 20px; color: #6c757d;">
                        <em>Tidak ada data santri binaan pada kelas ini.</em>
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