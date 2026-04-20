<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Edit Penerbit</h2>

<form action="<?= base_url('penerbit/update/' . $penerbit['id_penerbit']) ?>" method="post">

    <label>Nama Penerbit</label><br>
    <input type="text" name="nama_penerbit" value="<?= $penerbit['nama_penerbit'] ?>" required>
    <br><br>

    <label>Alamat</label><br>
    <textarea name="alamat"><?= $penerbit['alamat'] ?></textarea>
    <br><br>

    <button type="submit">Update</button>

</form>

<?= $this->endSection() ?>