<!DOCTYPE html>
<html>
<head>
    <title>Struk Peminjaman</title>
</head>
<body onload="window.print()">

<h3>📚 STRUK PEMINJAMAN</h3>
<hr>

<p>ID: <?= $peminjaman['id_peminjaman'] ?></p>
<p>Nama: <?= $peminjaman['nama_anggota'] ?></p>
<p>Petugas: <?= $peminjaman['nama_petugas'] ?></p>
<p>Tanggal Pinjam: <?= $peminjaman['tanggal_pinjam'] ?></p>
<p>Tanggal Kembali: <?= $peminjaman['tanggal_kembali'] ?></p>
<p>Status: <?= $peminjaman['status'] ?></p>

<hr>

<h4>Detail Buku</h4>

<table border="1" cellpadding="5" cellspacing="0">
<tr>
    <th>No</th>
    <th>Judul</th>
    <th>Jumlah</th>
</tr>

<?php $no=1; foreach($detail as $d): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $d['judul'] ?></td>
    <td><?= $d['jumlah'] ?></td>
</tr>
<?php endforeach; ?>

</table>

<br>
<p>Terima kasih 🙏</p>

</body>
</html>