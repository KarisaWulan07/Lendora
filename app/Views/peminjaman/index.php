<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Data Peminjaman</h3>

<a href="<?= base_url('peminjaman/create') ?>">Tambah</a>

<table border="1" cellpadding="5">
    <tr>
        <th>No</th>
        <th>Anggota</th>
        <th>Petugas</th>
        <th>Tanggal Pinjam</th>
        <th>Tanggal Kembali</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    <?php $no = 1;
    foreach ($peminjaman as $p): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $p['nama_anggota'] ?></td>
            <td><?= $p['nama_petugas'] ?></td>
            <td><?= $p['tanggal_pinjam'] ?></td>
            <td><?= $p['tanggal_kembali'] ?></td>
            <td><?= $p['status'] ?></td>
            <td>
                
                <a href="<?= base_url('peminjaman/detail/' . $p['id_peminjaman']) ?>">Detail</a>
                <a href="<?= base_url('peminjaman/kembali/' . $p['id_peminjaman']) ?>">Kembali</a>
                <a href="<?= base_url('peminjaman/delete/' . $p['id_peminjaman']) ?>" onclick="return confirm('Hapus?')">Hapus</a>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<?= $this->endSection() ?>