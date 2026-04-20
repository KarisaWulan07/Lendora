<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Tambah Peminjaman</h2>

<p><?= session()->get('nama') ?></p>

<form action="<?= base_url('peminjaman/store') ?>" method="post">

<label>Petugas</label>
<select name="id_petugas" required>
    <option value="">-- pilih petugas --</option>
    <?php foreach($petugas as $p): ?>
        <option value="<?= $p['id'] ?>">
            <?= $p['nama'] ?>
        </option>
    <?php endforeach ?>
</select>

<input type="date" name="tanggal_pinjam">
<input type="date" name="tanggal_kembali">

<hr>

<h3>Pilih Buku</h3>

<div style="display:flex;gap:10px;flex-wrap:wrap">

<?php foreach($buku as $b): ?>
<div style="border:1px solid #ccc;padding:10px;width:180px">
    <img src="<?= base_url('uploads/buku/'.$b['cover']) ?>" width="100%">
    <p><?= $b['judul'] ?></p>
    <p>Stok: <?= $b['tersedia'] ?></p>
    <a href="<?= base_url('peminjaman/addCart/'.$b['id_buku']) ?>">
        <button type="button">Pinjam</button>
    </a>
</div>
<?php endforeach ?>

</div>

<hr>

<h3>Buku dipilih</h3>

<?php foreach($cart as $id=>$qty): ?>
<p>
ID Buku: <?= $id ?> | Qty: <?= $qty ?>
<a href="<?= base_url('peminjaman/removeCart/'.$id) ?>">hapus</a>
</p>
<?php endforeach ?>

<button type="submit">Simpan</button>

</form>

<?= $this->endSection() ?>