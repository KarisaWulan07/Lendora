<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Data Pengembalian</h2>

<br>
<a href="<?= base_url('pengembalian/create') ?>">+ Tambah Pengembalian</a>

<form method="get">
    <input type="text" name="search" placeholder="Cari..." value="<?= esc($_GET['search'] ?? '') ?>">
    <button type="submit">Search</button>
</form>

<br>

<table border="1" width="100%" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>ID Peminjaman</th>
        <th>Tanggal</th>
        <th>Denda</th>
        <th>Status Denda</th>
        <th>Aksi</th>
    </tr>

    <?php if (!empty($pengembalian)) : ?>
        <?php foreach($pengembalian as $p): ?>
        <tr>
            <td><?= $p['id_pengembalian'] ?></td>
            <td><?= $p['id_peminjaman'] ?></td>
            <td><?= $p['tanggal_dikembalikan'] ?></td>

            <!-- 💰 DENDA -->
            <td>
                <?php if (($p['jumlah_denda'] ?? 0) > 0): ?>
                    <span style="color:red">
                        Rp <?= number_format($p['jumlah_denda'], 0, ',', '.') ?>
                    </span>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>

            <!-- 🔥 STATUS DENDA -->
            <td>
                <?php if (($p['jumlah_denda'] ?? 0) > 0): ?>

                    <?php if (($p['status_denda'] ?? '') == 'belum') : ?>
                        <span style="color:red;">Belum Bayar</span>

                    <?php elseif (($p['status_denda'] ?? '') == 'menunggu') : ?>
                        <span style="color:orange;">Menunggu Verifikasi</span>

                    <?php elseif (($p['status_denda'] ?? '') == 'lunas') : ?>
                        <span style="color:green;">Lunas</span>

                    <?php elseif (($p['status_denda'] ?? '') == 'ditolak') : ?>
                        <span style="color:red;">Ditolak</span>

                    <?php else : ?>
                        -
                    <?php endif; ?>

                <?php else: ?>
                    -
                <?php endif; ?>
            </td>

            <!-- ⚙️ AKSI -->
            <td>
                <a href="<?= base_url('pengembalian/edit/'.$p['id_pengembalian']) ?>">Edit</a> |
                <a href="<?= base_url('pengembalian/delete/'.$p['id_pengembalian']) ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6" style="text-align:center;">Tidak ada data</td>
        </tr>
    <?php endif; ?>
</table>

<?= $this->endSection() ?>