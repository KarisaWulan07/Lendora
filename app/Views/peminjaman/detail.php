<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$today = date('Y-m-d');
$isTelat = false;

if (
    ($peminjaman['status'] ?? '') == 'dipinjam' &&
    !empty($peminjaman['tanggal_kembali']) &&
    $today > $peminjaman['tanggal_kembali']
) {
    $isTelat = true;
}
?>

<h2>Detail Peminjaman</h2>

<p>Anggota: <?= $peminjaman['nama_anggota'] ?></p>
<p>Petugas: <?= $peminjaman['nama_petugas'] ?></p>
<p>Tgl Pinjam: <?= $peminjaman['tanggal_pinjam'] ?></p>
<p>Tgl Kembali: <?= $peminjaman['tanggal_kembali'] ?></p>

<!-- 🔥 STATUS SUDAH DINAMIS -->
<p>
Status: 
<?php if (($peminjaman['status'] ?? '') == 'dipinjam' && $isTelat): ?>
    <span style="color:red;font-weight:bold;">TELAT</span>

<?php elseif (($peminjaman['status'] ?? '') == 'dipinjam'): ?>
    <span style="color:blue;">Dipinjam</span>

<?php else: ?>
    <span style="color:green;">Dikembalikan</span>
<?php endif; ?>
</p>

<hr>

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