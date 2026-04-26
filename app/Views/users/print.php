<!DOCTYPE html>
<html>
<head>
    <title>Print Data Users</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            color: #000;
        }

        /* HEADER */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h3 {
            margin: 0;
        }

        .header small {
            color: #555;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 13px;
        }

        th {
            background: #f2f2f2;
            text-align: center;
        }

        td {
            vertical-align: middle;
        }

        /* FOOTER */
        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 12px;
        }

        /* PRINT SETTING */
        @media print {
            body {
                margin: 10mm;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <!-- HEADER -->
    <div class="header">
        <h3>Data Users</h3>
        <small>Sistem Peminjaman Buku</small>
    </div>

    <!-- TABLE -->
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Username</th>
                <th width="15%">Role</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($users)): ?>
                <?php $no = 1; ?>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td style="text-align:center;"><?= $no++ ?></td>
                        <td><?= $u['nama'] ?></td>
                        <td><?= $u['email'] ?></td>
                        <td><?= $u['username'] ?></td>
                        <td style="text-align:center;">
                            <?= ucfirst($u['role']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align:center;">
                        Tidak ada data
                    </td>
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