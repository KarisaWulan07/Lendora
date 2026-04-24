<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Data Peminjaman</h2>

<?php if (session()->get('role') == 'anggota') : ?>
    <a href="<?= base_url('peminjaman/create') ?>">+ Tambah Peminjaman</a>
<?php endif; ?>

<br><br>

<?php if (session()->getFlashdata('success')) : ?>
    <p style="color:green">
        <?= session()->getFlashdata('success') ?>
    </p>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <p style="color:red">
        <?= session()->getFlashdata('error') ?>
    </p>
<?php endif; ?>

<form method="get">
    <input type="text" name="keyword" placeholder="Cari..."
           value="<?= esc($keyword ?? '') ?>">
    <button type="submit">Search</button>
</form>

<br>

<table border="1" cellpadding="10" cellspacing="0">

<thead>
<tr>
    <th>ID</th>
    <th>No</th>
    <th>Anggota</th>
    <th>Petugas</th>
    <th>Buku</th>
    <th>Tgl Pinjam</th>
    <th>Tgl Kembali</th>
    <th>Status</th>
    <th>Denda</th>
    <th>Status Denda</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>

<?php if (!empty($peminjaman)) : ?>
<?php $no = 1; ?>

<?php foreach ($peminjaman as $row) : ?>

<?php
$today = date('Y-m-d');
$isTelat = false;
$denda = 0;

// 🔥 CEK TELAT
if (
    ($row['status'] ?? '') == 'dipinjam' &&
    !empty($row['tanggal_kembali']) &&
    $today > $row['tanggal_kembali']
) {
    $isTelat = true;

    $selisih = (strtotime($today) - strtotime($row['tanggal_kembali'])) / 86400;
    $denda = $selisih * 1000;
}
?>

<tr style="<?= $isTelat ? 'background-color:#ffe6e6' : '' ?>">

    <td><?= $row['id_peminjaman'] ?? '-' ?></td>
    <td><?= $no++ ?></td>

    <td><?= $row['nama_anggota'] ?? '-' ?></td>
    <td><?= $row['nama_petugas'] ?? '-' ?></td>
    <td><?= $row['buku'] ?? '-' ?></td>

    <td><?= $row['tanggal_pinjam'] ?? '-' ?></td>
    <td><?= $row['tanggal_kembali'] ?? '-' ?></td>

    <!-- 🔥 STATUS PINJAM + TELAT -->
    <td>
        <?php if (($row['status'] ?? '') == 'dipinjam' && $isTelat): ?>
            <span style="color:red;font-weight:bold;">TELAT</span>

        <?php elseif (($row['status'] ?? '') == 'dipinjam'): ?>
            <span style="color:blue;">Dipinjam</span>

        <?php else: ?>
            <span style="color:green;">Dikembalikan</span>
        <?php endif; ?>
    </td>

    <!-- DENDA -->
    <td>
        <?php if ($denda > 0): ?>
            <span style="color:red">
                Rp <?= number_format($denda, 0, ',', '.') ?>
            </span>
        <?php else: ?>
            -
        <?php endif; ?>
    </td>

    <!-- STATUS DENDA -->
    <td>
        <?php if (($row['status_denda'] ?? '') == 'belum') : ?>
            <span style="color:red;">Belum Bayar</span>

        <?php elseif (($row['status_denda'] ?? '') == 'menunggu') : ?>
            <span style="color:orange;">Menunggu</span>

        <?php elseif (($row['status_denda'] ?? '') == 'lunas') : ?>
            <span style="color:green;">Lunas</span>

        <?php else : ?>
            -
        <?php endif; ?>
    </td>

    <!-- AKSI -->
    <td>
        <a href="<?= base_url('peminjaman/detail/' . $row['id_peminjaman']) ?>">Detail</a>

        <?php if (in_array(session()->get('role'), ['admin','petugas'])) : ?>
            | <a href="<?= base_url('peminjaman/perpanjang/' . $row['id_peminjaman']) ?>">Perpanjang</a>
        <?php endif; ?>

        | <a href="<?= base_url('peminjaman/print/' . $row['id_peminjaman']) ?>" target="_blank">Print</a>

        <?php if (in_array(session()->get('role'), ['admin','petugas'])) : ?>
            | <a href="<?= base_url('peminjaman/delete/' . $row['id_peminjaman']) ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
        <?php endif; ?>

        | <a href="<?= base_url('peminjaman/wa/' . $row['id_peminjaman']) ?>" target="_blank">Kirim WA</a>
    </td>

</tr>

<?php endforeach; ?>
<?php else: ?>
<tr>
    <td colspan="11" style="text-align:center;">
        Tidak ada data peminjaman
    </td>
</tr>
<?php endif; ?>

</tbody>
</table>

<?= $this->endSection() ?>