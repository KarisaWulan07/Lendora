<h3 style="text-align:center;">Laporan Peminjaman</h3>
<p style="text-align:center;">
    Tanggal Cetak: <?= date('d-m-Y') ?>
</p>

<table border="1" width="100%" cellpadding="5" cellspacing="0">
    <tr>
        <th>No</th>
        <th>NIS</th>
        <th>No HP</th>
        <th>Petugas</th>
        <th>Buku</th> <!-- 🔥 TAMBAH -->
        <th>Tanggal Pinjam</th>
        <th>Tanggal Kembali</th>
        <th>Status</th>
    </tr>

    <?php $no = 1; ?>
    <?php foreach ($peminjaman as $p): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $p['nis'] ?></td>
        <td><?= $p['no_hp'] ?></td>
        <td><?= $p['nama_petugas'] ?></td>

        <!-- 🔥 BUKU -->
        <td>
            <?php 
                if (!empty($p['buku'])) {
                    $buku = explode(',', $p['buku']);
                    foreach ($buku as $b) {
                        echo "- " . trim($b) . "<br>";
                    }
                } else {
                    echo '-';
                }
            ?>
        </td>

        <td><?= date('d-m-Y', strtotime($p['tanggal_pinjam'])) ?></td>

        <td>
            <?= $p['tanggal_kembali'] 
                ? date('d-m-Y', strtotime($p['tanggal_kembali'])) 
                : '-' ?>
        </td>

        <!-- 🔥 STATUS -->
        <td>
            <?php if ($p['status'] == 'dipinjam') : ?>
                Dipinjam
            <?php elseif ($p['status'] == 'dikembalikan') : ?>
                Dikembalikan
            <?php elseif ($p['status'] == 'terlambat') : ?>
                Terlambat
            <?php else : ?>
                -
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<br><br>

<p style="text-align:right;">
    Mengetahui,<br><br><br>
    ____________________
</p>

<script>
    window.print();
</script>