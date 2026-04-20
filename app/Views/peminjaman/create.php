<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Tambah Peminjaman</h2>

<p><?= session()->get('nama') ?></p>

<!-- ✅ HANYA 1 FORM -->
<form action="<?= base_url('peminjaman/store') ?>" method="post">

<input type="hidden" name="id_anggota" value="<?= session()->get('id_user') ?>">

<label>Petugas</label>
<select name="id_petugas" required>
    <option value="">-- pilih petugas --</option>
    <?php foreach($petugas as $p): ?>
        <option value="<?= $p['id'] ?>">
            <?= $p['nama'] ?>
        </option>
    <?php endforeach ?>
</select>

<hr>

<h3>Cari Kategori</h3>

<input type="text" name="search" 
       placeholder="Cari kategori..." 
       value="<?= $search ?? '' ?>">

<button type="submit" formaction="<?= base_url('peminjaman/create') ?>" formmethod="get">
    Cari
</button>

<hr>

<h3>Pilih Buku</h3>

<div style="display:flex;gap:10px;flex-wrap:wrap">

<?php foreach($buku as $b): ?>
<div style="border:1px solid #ccc;padding:10px;width:180px">
    
    <img src="<?= base_url('uploads/buku/'.$b['cover']) ?>" width="100%">
    
    <p><b><?= $b['judul'] ?></b></p>
    <p>Penulis: <?= $b['nama_penulis'] ?? '-' ?></p>
    <p>Stok: <?= $b['tersedia'] ?></p>

    <a href="<?= base_url('buku/detail/'.$b['id_buku']) ?>">Detail</a><br>

    <a href="<?= base_url('peminjaman/addCart/'.$b['id_buku']) ?>">Pinjam</a>

</div>
<?php endforeach ?>

</div>

<hr>

<h3>Buku dipilih</h3>

<?php if(!empty($cart)): ?>
    <?php foreach($cart as $b): ?>
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
            <p><?= $b['judul'] ?> (<?= $b['qty'] ?>)</p>
            <a href="<?= base_url('peminjaman/removeCart/'.$b['id_buku']) ?>">Hapus</a>
        </div>
    <?php endforeach ?>
<?php else: ?>
    <p>Belum ada buku dipilih</p>
<?php endif; ?>

<br>

<button type="submit">Simpan</button>

</form>

<?= $this->endSection() ?>