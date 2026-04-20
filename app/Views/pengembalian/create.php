<<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Tambah Pengembalian</h3>

<form action="<?= base_url('pengembalian/store') ?>" method="post">

    ID Peminjaman:
    <input type="text" name="id_peminjaman" required><br><br>

    <button type="submit">Simpan</button>
</form>
<?= $this->endSection() ?>