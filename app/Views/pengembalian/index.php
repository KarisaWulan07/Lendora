<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Data Pengembalian</h3>

<a href="<?= base_url('pengembalian/create') ?>">Tambah</a>

<form method="get">
    <input type="text" name="keyword" placeholder="Cari ID / Tanggal">
    <button type="submit">Search</button>
</form>

<table border="1" cellpadding="5">
    <tr>
        <th>No</th>
        <th>ID Peminjaman</th>
        <th>Tanggal Dikembalikan</th>
        <th>Denda</th>
        <th>Aksi</th>
    </tr>

    <?php $no = 1; ?>
    <?php foreach ($pengembalian as $p): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $p['id_peminjaman'] ?></td>
            <td><?= $p['tanggal_dikembalikan'] ?></td>

            <td>
                <?php if ($p['denda'] > 0): ?>
                    Rp <?= number_format($p['denda'], 0, ',', '.') ?>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>

            <td>
                <a href="<?= base_url('pengembalian/edit/' . $p['id_pengembalian']) ?>">Edit</a>
                <a href="<?= base_url('pengembalian/delete/' . $p['id_pengembalian']) ?>" onclick="return confirm('Hapus?')">Hapus</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?= $this->endSection() ?>