<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>


<h3>Detail Peminjaman</h3>

<table border="1">
    <tr>
        <td>ID Peminjaman</td>
        <td><?= $peminjaman['id_peminjaman'] ?></td>
    </tr>

    <tr>
        <td>ID Anggota</td>
        <td><?= $peminjaman['id_anggota'] ?></td>
    </tr>

    <tr>
        <td>ID Petugas</td>
        <td><?= $peminjaman['id_petugas'] ?></td>
    </tr>

    <tr>
        <td>Tanggal Pinjam</td>
        <td><?= $peminjaman['tanggal_pinjam'] ?></td>
    </tr>

    <tr>
        <td>Tanggal Kembali</td>
        <td><?= $peminjaman['tanggal_kembali'] ?></td>
    </tr>

    <tr>
        <td>Status</td>
        <td><?= $peminjaman['status'] ?></td>
    </tr>
</table>

<br>

<a href="<?= base_url('peminjaman') ?>">Kembali</a>

<?= $this->endSection() ?>