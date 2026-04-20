<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Data Peminjaman</h2>

<a href="<?= base_url('peminjaman/create') ?>">+ Tambah</a>

<table border="1" width="100%">
<tr>
    <th>ID</th>
    <th>Petugas</th>
    <th>Buku</th>
    <th>Tanggal</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

<?php foreach($peminjaman as $p): ?>
<tr>
    <td><?= $p['id_peminjaman'] ?></td>
    <td><?= $p['nama_petugas'] ?></td>
    <td><?= $p['buku'] ?></td>
    <td><?= $p['tanggal_pinjam'] ?></td>
    <td><?= $p['status'] ?></td>
    <td>
        <a href="<?= base_url('peminjaman/detail/'.$p['id_peminjaman']) ?>">Detail</a>
    </td>
</tr>
<?php endforeach ?>
</table>

<?= $this->endSection() ?>