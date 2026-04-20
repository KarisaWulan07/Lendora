<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>


<h3>Data Rak</h3>

<form method="get">
    <input type="text" name="keyword" placeholder="Cari rak/lokasi">
    <button type="submit">Cari</button>
    <a href="<?= base_url('rak') ?>">Reset</a>
</form>

<br>

<a href="<?= base_url('rak/create') ?>">+ Tambah Rak</a>

<br><br>

<table border="1" cellpadding="5">
<tr>
    <th>No</th>
    <th>Nama Rak</th>
    <th>Lokasi</th>
    <th>Aksi</th>
</tr>

<?php $no=1; foreach($rak as $r): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $r['nama_rak'] ?></td>
    <td><?= $r['lokasi'] ?></td>
    <td>
        <a href="<?= base_url('rak/edit/'.$r['id_rak']) ?>">Edit</a>
        <a href="<?= base_url('rak/delete/'.$r['id_rak']) ?>" onclick="return confirm('Hapus?')">Hapus</a>
    </td>
</tr>
<?php endforeach; ?>

</table>
<?= $this->endSection() ?>