<?php
$title = $title ?? 'Data Kelas';
$kelas = $kelas ?? [];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="shortcut icon" href="<?= base_url('logo_hudfal.png') ?>" type="image/png">
    <!-- Tailwind CSS CDN untuk styling cepat & modern -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800">

    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-xl shadow-md border border-slate-100">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-900">Daftar Kelas Pesantren</h1>
            <!-- Tombol Tambah (Nanti bisa diarahkan ke fungsi create) -->
            <a href="#" class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">
                + Tambah Kelas
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-200 text-slate-600 text-sm">
                        <th class="py-3 px-4 font-semibold">#</th>
                        <th class="py-3 px-4 font-semibold">Nama Kelas</th>
                        <th class="py-3 px-4 font-semibold">Dibuat Pada</th>
                        <th class="py-3 px-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    <?php if (!empty($kelas)): ?>
                        <?php $no = 1;
                        foreach ($kelas as $k): ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-3 px-4"><?= $no++; ?></td>
                                <td class="py-3 px-4 font-medium text-slate-900"><?= esc($k['nama_kelas']); ?></td>
                                <td class="py-3 px-4 text-slate-500"><?= esc($k['created_at']); ?></td>
                                <td class="py-3 px-4 text-center">
                                    <a href="#" class="text-blue-600 hover:underline mr-3">Edit</a>
                                    <a href="#" class="text-red-600 hover:underline">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="py-4 text-center text-slate-400">Belum ada data kelas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>