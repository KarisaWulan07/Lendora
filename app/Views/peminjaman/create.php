<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Tambah Peminjaman</h3>

<form action="<?= base_url('peminjaman/store') ?>" method="post">

    <label>Anggota</label><br>
    <select name="id_anggota" required>
        <option value="">-- Pilih Anggota --</option>
        <?php foreach ($anggota as $a): ?>
            <option value="<?= $a['id'] ?>"><?= $a['nama'] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Petugas</label><br>
    <select name="id_petugas" required>
        <option value="">-- Pilih Petugas --</option>
        <?php foreach ($petugas as $p): ?>
            <option value="<?= $p['id'] ?>"><?= $p['nama'] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Tanggal Pinjam</label><br>
    <input type="date" name="tanggal_pinjam" required><br><br>

    <label>Tanggal Kembali</label><br>
    <input type="date" name="tanggal_kembali"><br><br>

    <button type="submit">Simpan</button>

</form>

<?= $this->endSection() ?>