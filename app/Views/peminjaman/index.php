<h2>Data Peminjaman</h2>

<form method="get">
    <input type="text" name="keyword" placeholder="Search">
    <button>Cari</button>
</form>

<a href="/peminjaman/create">Tambah</a>

<table border="1">
<tr>
    <th>ID</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

<?php foreach ($peminjaman as $p): ?>
<tr>
    <td><?= $p['id_peminjaman'] ?></td>
    <td><?= $p['status'] ?></td>
    <td>
        <a href="/peminjaman/detail/<?= $p['id_peminjaman'] ?>">Detail</a>
        <a href="/peminjaman/edit/<?= $p['id_peminjaman'] ?>">Edit</a>
        <a href="/peminjaman/delete/<?= $p['id_peminjaman'] ?>">Hapus</a>
    </td>
</tr>
<?php endforeach; ?>
</table>