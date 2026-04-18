<h3 style="text-align:center;">Laporan Peminjaman</h3>

<table border="1" width="100%" cellpadding="5">
    <tr>
        <th>NIS</th>
        <th>No HP</th>
        <th>Petugas</th>
        <th>Tanggal Pinjam</th>
        <th>Tanggal Kembali</th>
        <th>Status</th>
    </tr>

    <?php foreach ($peminjaman as $p): ?>
    <tr>
        <td><?= $p['nis'] ?></td>
        <td><?= $p['no_hp'] ?></td>
        <td><?= $p['nama_petugas'] ?></td>
        <td><?= $p['tanggal_pinjam'] ?></td>
        <td><?= $p['tanggal_kembali'] ?></td>
        <td><?= $p['status'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<script>
    window.print();
</script>