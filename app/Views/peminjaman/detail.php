<h2>Detail Peminjaman</h2>

<p>ID: <?= $peminjaman['id_peminjaman'] ?></p>
<p>Status: <?= $peminjaman['status'] ?></p>

<a href="/peminjaman/tambahDetail/<?= $peminjaman['id_peminjaman'] ?>">
Tambah Buku
</a>

<table border="1">
<tr>
    <th>Judul Buku</th>
    <th>Jumlah</th>
</tr>

<?php foreach ($detail as $d): ?>
<tr>
    <td><?= $d['judul'] ?></td>
    <td><?= $d['jumlah'] ?></td>
</tr>
<?php endforeach; ?>
</table>