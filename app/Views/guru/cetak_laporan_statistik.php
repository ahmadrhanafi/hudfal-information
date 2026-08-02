<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Statistik Hafalan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h2,
        .header h4 {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
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

    <div class="header">
        <h2>LAPORAN PROGRES HAFALAN AL-QUR'AN</h2>
        <h4>Kelas Binaan: <?= esc($nama_kelas); ?> (Pengajar: <?= esc($nama_guru); ?>)</h4>
        <p>Periode Filter: <strong><?= strtoupper(str_replace('_', ' ', $periode)); ?></strong></p>
    </div>

    <h3>Ringkasan Statistik</h3>
    <ul>
        <li>Rata-rata Setoran: <strong><?= $rata_setoran; ?> Ayat/Hari</strong></li>
        <!-- PERBAIKAN DI SINI: Akses indeks ['nama'] dan ['persentase'] secara spesifik -->
        <li>Juz Dominan: <strong><?= esc($juz_dominan['nama'] ?? '-'); ?> (<?= esc($juz_dominan['persentase'] ?? 0); ?>%)</strong></li>
        <li>Predikat Terbanyak: <strong><?= esc($predikat_umum['predikat'] ?? '-'); ?></strong></li>
    </ul>

    <h3>Rincian Data Hafalan</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Capaian Juz & Surat</th>
                <th>Ayat</th>
                <th>Predikat</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($detail_hafalan)): ?>
                <?php $no = 1;
                foreach ($detail_hafalan as $row): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= date('d-m-Y', strtotime($row['created_at'])); ?></td>
                        <td>Juz <?= esc($row['juz']); ?> (<?= esc($row['surah']); ?>)</td>
                        <td><?= esc($row['ayat_mulai']); ?> - <?= esc($row['ayat_selesai']); ?></td>
                        <td><?= esc($row['predikat']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data pada periode ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>