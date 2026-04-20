<<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Edit Pengembalian</h3>

<form action="<?= base_url('pengembalian/update/' . $kembali['id_pengembalian']) ?>" method="post">

    ID Peminjaman:
    <input type="text" name="id_peminjaman" value="<?= $kembali['id_peminjaman'] ?>"><br><br>

    Tanggal Dikembalikan:
    <input type="date" name="tanggal_dikembalikan" value="<?= $kembali['tanggal_dikembalikan'] ?>"><br><br>

    Denda:
    <input type="number" name="denda" value="<?= $kembali['denda'] ?>"><br><br>

    <button type="submit">Update</button>
</form>
<?= $this->endSection() ?>