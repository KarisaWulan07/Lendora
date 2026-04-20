<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Detail Peminjaman</h2>

<p>Anggota: <?= $peminjaman['nama'] ?></p>
<p>Tgl Pinjam: <?= $peminjaman['tanggal_pinjam'] ?></p>
<p>Tgl Kembali: <?= $peminjaman['tanggal_kembali'] ?></p>

<table border="1" width="100%">
<tr>
    <th>Buku</th>
    <th>Jumlah</th>
</tr>

<?php foreach($detail as $d): ?>
<tr>
    <td><?= $d['judul'] ?></td>
    <td><?= $d['jumlah'] ?></td>
</tr>
<?php endforeach ?>
</table>

<?= $this->endSection() ?>