<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Print Data Buku</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #000;
        }

        /* HEADER */
        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }

        .header p {
            margin: 3px 0;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #eee;
            text-align: center;
        }

        td {
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 11px;
        }

        /* PRINT SAFETY */
        @media print {
            body {
                margin: 10px;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <!-- HEADER -->
    <div class="header">
        <h2>DATA BUKU</h2>
        <p>Sistem Peminjaman Buku</p>
        <p>------------------------------------------</p>
    </div>

    <!-- TABLE -->
    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th width="8%">Tahun</th>
                <th width="8%">Jumlah</th>
                <th width="8%">Tersedia</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($buku)): ?>
                <?php $no = 1; foreach ($buku as $b): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= $b['judul'] ?></td>
                        <td><?= $b['nama_kategori'] ?? '-' ?></td>
                        <td><?= $b['nama_penulis'] ?? '-' ?></td>
                        <td><?= $b['nama_penerbit'] ?? '-' ?></td>
                        <td class="text-center"><?= $b['tahun_terbit'] ?></td>
                        <td class="text-center"><?= $b['jumlah'] ?></td>
                        <td class="text-center"><?= $b['tersedia'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        Dicetak pada: <?= date('d-m-Y H:i') ?>
    </div>

</body>
</html>