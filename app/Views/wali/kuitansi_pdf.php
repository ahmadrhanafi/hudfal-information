<?php

/**
 * @var array{
 *     id: int,
 *     tanggal: string,
 *     tanggal_konfirmasi?: string,
 *     jenis_pembayaran: string,
 *     jumlah: float|int,
 *     status: string,
 *     bank_tujuan?: string,
 *     keterangan?: string,
 *     nama_santri?: string,
 *     nama_kelas?: string
 * } $tagihan
 */
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kuitansi Pembayaran - TRX-<?= $tagihan['id']; ?></title>
    <link rel="shortcut icon" href="<?= base_url('logo_hudfal.png') ?>" type="image/png">

    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            font-size: 12px;
            line-height: 1.4;
            -webkit-print-color-adjust: exact;
        }

        /* Container Utama dengan margin otomatis agar persis di tengah */
        .page-container {
            width: 180mm;
            margin: 0 auto;
            padding: 5mm 0;
            box-sizing: border-box;
            position: relative;
        }

        /* Kop Surat Resmi */
        .kop-surat {
            width: 100%;
            border-bottom: 3px double #198754;
            padding-bottom: 8px;
            margin-bottom: 15px;
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
            width: 55px;
            height: auto;
        }

        .instansi-info h3 {
            margin: 0;
            color: #198754;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .instansi-info h2 {
            margin: 2px 0;
            color: #212529;
            font-size: 15px;
            text-transform: uppercase;
        }

        .instansi-info p {
            margin: 0;
            font-size: 10px;
            color: #6c757d;
        }

        /* Watermark (Sudah dibersihkan dari typo) */
        .watermark {
            position: fixed;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-25deg);
            font-size: 6rem;
            color: rgba(25, 135, 84, 0.04);
            font-weight: 900;
            z-index: -1;
            pointer-events: none;
            letter-spacing: 10px;
            text-transform: uppercase;
        }

        /* Section Title */
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #212529;
            margin-bottom: 6px;
            margin-top: 12px;
            text-transform: uppercase;
            border-left: 3px solid #198754;
            padding-left: 6px;
        }

        /* Tabel Rincian Data */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table.data-table th,
        table.data-table td {
            border: 1px solid #dee2e6;
            padding: 6px 8px;
            text-align: left;
            font-size: 11px;
            vertical-align: middle;
        }

        table.data-table th {
            background-color: #198754;
            color: white;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.3px;
        }

        /* Box Nominal */
        .box-nominal {
            background-color: #f8f9fa;
            border: 2px dashed #198754;
            padding: 6px 12px;
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
            font-size: 1rem;
            color: #198754;
            display: inline-block;
            border-radius: 4px;
        }

        .text-center {
            text-align: center !important;
        }

        .text-end {
            text-align: right !important;
        }

        /* Footer & Tanda Tangan */
        .footer-container {
            width: 100%;
            border-top: 1px solid #dee2e6;
            padding-top: 12px;
            margin-top: 15px;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td {
            border: none !important;
            padding: 0;
            vertical-align: top;
        }

        .note-box {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            padding: 8px 10px;
            border-radius: 4px;
            font-size: 10px;
            color: #495057;
            line-height: 1.3;
        }

        .footer-sign {
            text-align: center;
            width: 180px;
            margin-left: auto;
        }

        .footer-sign .space {
            height: 45px;
        }

        .footer-sign .name {
            font-weight: bold;
            text-decoration: underline;
            color: #212529;
            font-size: 11px;
        }

        @media print {
            body {
                background-color: white;
                color: black;
            }

            .page-container {
                width: 100%;
            }

            @page {
                size: A4;
                margin: 15mm;
            }
        }
    </style>
</head>

<body>

    <div class="page-container">

        <!-- WATERMARK STATUS -->
        <?php if (strtolower($tagihan['status']) == 'lunas'): ?>
            <div class="watermark">LUNAS</div>
        <?php endif; ?>

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
                        <h3>Yayasan Pendidikan Islam Hudfal</h3>
                        <h2 style="color: #212529;">Bukti Pembayaran Keuangan Resmi</h2>
                        <p>Jl. Pendidikan No. 123, Telp: (021) 555-0199, Jawa Barat • Website: https://hudfal-information.test</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- INFORMASI TRANSAKSI -->
        <div class="section-title" style="margin-top: 0;">Informasi Transaksi (#TRX-<?= date('Ym', strtotime($tagihan['tanggal'])); ?>-0<?= $tagihan['id']; ?>)</div>

        <div style="background-color: #fcfdfd; border: 1px solid #e2e8f0; padding: 10px 12px; margin-bottom: 12px;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 22%; padding: 4px 0; color: #64748b; font-size: 11px; font-weight: 600; border: none;">Sudah Terima Dari</td>
                    <td style="width: 78%; padding: 4px 0; color: #1e293b; font-size: 11px; border: none;" colspan="3">
                        <strong style="color: #0f172a;">Wali Santri / Orang Tua Murid</strong>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 4px 0; color: #64748b; font-size: 11px; font-weight: 600; border: none;">Nama Santri</td>
                    <td style="padding: 4px 0; color: #1e293b; font-size: 11px; border: none;">
                        <strong style="color: #198754; font-size: 12px;"><?= esc($tagihan['nama_santri'] ?? '-'); ?></strong>
                    </td>
                    <td style="width: 18%; padding: 4px 0; color: #64748b; font-size: 11px; font-weight: 600; border: none;">Kelas</td>
                    <td style="width: 25%; padding: 4px 0; color: #1e293b; font-size: 11px; border: none;">
                        <span style="background-color: #e2e8f0; color: #334155; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: bold;"><?= esc($tagihan['nama_kelas'] ?? '-'); ?></span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 4px 0; color: #64748b; font-size: 11px; font-weight: 600; border: none;">Tanggal Transaksi</td>
                    <td style="padding: 4px 0; color: #1e293b; font-size: 11px; border: none;">
                        <?= !empty($tagihan['tanggal_konfirmasi']) ? date('d-m-Y H:i', strtotime($tagihan['tanggal_konfirmasi'])) : date('d-m-Y', strtotime($tagihan['tanggal'])); ?> WIB
                    </td>
                    <td style="padding: 4px 0; color: #64748b; font-size: 11px; font-weight: 600; border: none;">Rekening Tujuan</td>
                    <td style="padding: 4px 0; color: #1e293b; font-size: 11px; border: none;">
                        <span style="color: #0f172a; font-weight: bold;"><?= esc($tagihan['bank_tujuan'] ?? 'Kas Tunai'); ?></span>
                    </td>
                </tr>
            </table>
        </div>

        <!-- RINCIAN BIAYA -->
        <div class="section-title">Rincian Pembayaran</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th width="6%" class="text-center">No</th>
                    <th width="64%">Jenis Pembayaran & Keterangan</th>
                    <th width="30%" class="text-end">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>
                        <strong><?= esc($tagihan['jenis_pembayaran']); ?></strong>
                        <?php if (!empty($tagihan['keterangan'])): ?>
                            <div style="font-size: 10px; color: #6c757d; margin-top: 1px;">Catatan: <?= esc($tagihan['keterangan']); ?></div>
                        <?php endif; ?>
                    </td>
                    <td class="text-end font-monospace">Rp <?= number_format($tagihan['jumlah'], 0, ',', '.'); ?></td>
                </tr>
            </tbody>
        </table>

        <!-- TOTAL & STATUS -->
        <table style="width: 100%; margin-top: 5px; border-collapse: collapse;">
            <tr>
                <td style="vertical-align: middle; border: none !important; padding: 0;">
                    <span style="font-size: 11px; font-weight: bold; color: #198754; text-transform: uppercase;">Status : [ <?= strtoupper(esc($tagihan['status'])); ?> ]</span>
                </td>
                <td class="text-end" style="border: none !important; padding: 0;">
                    <div class="box-nominal">
                        Total: Rp <?= number_format($tagihan['jumlah'], 0, ',', '.'); ?>,-
                    </div>
                </td>
            </tr>
        </table>

        <!-- BAGIAN BAWAH: CATATAN & TANDA TANGAN -->
        <div class="footer-container">
            <table class="footer-table">
                <tr>
                    <td width="55%">
                        <div class="note-box">
                            <strong>Perhatian:</strong><br>
                            1. Kuitansi ini dicetak otomatis oleh sistem administrasi Yayasan Hudfal dan sah tanpa stempel basah.<br>
                            2. Simpan bukti pembayaran ini sewaktu-waktu diperlukan untuk pengecekan ulang administrasi.
                        </div>
                    </td>
                    <td width="5%"></td>
                    <td width="40%">
                        <div class="footer-sign">
                            <div style="font-size: 10px; color: #495057;">Bekasi, <?= date('d F Y'); ?></div>
                            <div style="font-size: 10px; font-weight: bold; color: #212529; margin-bottom: 2px;">Bagian Administrasi & Keuangan</div>
                            <div class="space"></div>
                            <div class="name">( Ustadz / Admin Keuangan )</div>
                            <div style="font-size: 9px; color: #6c757d; font-family: monospace;">YPI Hudfal Bekasi</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

    </div>

</body>

</html>