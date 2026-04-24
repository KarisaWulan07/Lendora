<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Tambah Penerbit</h2>

<form action="<?= base_url('penerbit/store') ?>" method="post">

    <label>Nama Penerbit</label><br>
    <input type="text" name="nama_penerbit" required>
    <br><br>


    <button type="submit">Simpan</button>

</form>

<?= $this->endSection() ?>
