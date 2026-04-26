<!DOCTYPE html>
<html>
<head>
    <title>Struk Peminjaman</title>

    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            padding: 20px;
            color: #000;
        }

        .container {
            max-width: 700px;
            margin: auto;
        }

        .title {
            text-align: center;
            margin-bottom: 10px;
        }

        .title h3 {
            margin: 0;
        }

        .line {
            border-top: 2px dashed #000;
            margin: 10px 0;
        }

        .info p {
            margin: 3px 0;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th, table td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 13px;
        }

        table th {
            background: #eee;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 13px;
        }

        /* PRINT OPTIMIZE */
        @media print {
            body {
                padding: 0;
            }

            .container {
                width: 100%;
            }
        }
    </style>
</head>

<body onload="window.print()">

<div class="container">

    <!-- HEADER -->
    <div class="title">
        <h3>📚 STRUK PEMINJAMAN</h3>
        <small>Lendora App</small>
    </div>

    <div class="line"></div>

    <!-- INFO -->
    <div class="info">
        <p><b>ID:</b> <?= $peminjaman['id_peminjaman'] ?></p>
        <p><b>Nama:</b> <?= $peminjaman['nama_anggota'] ?></p>
        <p><b>Petugas:</b> <?= $peminjaman['nama_petugas'] ?></p>
        <p><b>Tgl Pinjam:</b> <?= $peminjaman['tanggal_pinjam'] ?></p>
        <p><b>Tgl Kembali:</b> <?= $peminjaman['tanggal_kembali'] ?></p>

        <p>
            <b>Status:</b>
            <?php if ($peminjaman['status'] == 'dipinjam'): ?>
                Dipinjam
            <?php elseif ($peminjaman['status'] == 'dikembalikan'): ?>
                Selesai
            <?php else: ?>
                Menunggu
            <?php endif; ?>
        </p>
    </div>

    <div class="line"></div>

    <!-- DETAIL -->
    <h4>Detail Buku</h4>

    <table>
        <thead>
            <tr>
                <th width="10%">No</th>
                <th>Judul</th>
                <th width="15%">Jumlah</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($detail)): ?>
                <?php $no = 1; foreach($detail as $d): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $d['judul'] ?></td>
                    <td><?= $d['jumlah'] ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="text-align:center;">
                        Tidak ada data
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="line"></div>

    <!-- FOOTER -->
    <div class="footer">
        <p>Terima kasih telah menggunakan layanan kami 🙏</p>
    </div>

</div>

</body>
</html>