<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Detail Buku</h3>

<table border="1" cellpadding="5">

    <tr>
        <td>Cover</td>
        <td>
            <?php if ($buku['cover']): ?>
                <img src="<?= base_url('uploads/buku/' . $buku['cover']) ?>" width="120">
            <?php else: ?>
                -
            <?php endif; ?>
        </td>
    </tr>

    <tr>
        <td>Judul</td>
        <td><?= $buku['judul'] ?></td>
    </tr>

    <tr>
        <td>ISBN</td>
        <td><?= $buku['isbn'] ?></td>
    </tr>

    <tr>
        <td>Kategori</td>
        <td><?= $buku['nama_kategori'] ?? '-' ?></td>
    </tr>

    <tr>
        <td>Penulis</td>
        <td><?= $buku['nama_penulis'] ?? '-' ?></td>
    </tr>

    <tr>
        <td>Penerbit</td>
        <td><?= $buku['nama_penerbit'] ?? '-' ?></td>
    </tr>

    <tr>
        <td>Rak</td>
        <td><?= $buku['nama_rak'] ?> - <?= $buku['lokasi'] ?></td>
    </tr>

<tr>
    <td>Lokasi</td>
    <td><?= $buku['lokasi'] ?? '-' ?></td>
</tr>

    <tr>
        <td>Tahun Terbit</td>
        <td><?= $buku['tahun_terbit'] ?></td>
    </tr>

    <tr>
        <td>Jumlah</td>
        <td><?= $buku['jumlah'] ?></td>
    </tr>

    <tr>
        <td>Tersedia</td>
        <td><?= $buku['tersedia'] ?></td>
    </tr>

    <tr>
        <td>Deskripsi</td>
        <td><?= $buku['deskripsi'] ?></td>
    </tr>

    <tr>
        <td>Dibuat</td>
        <td><?= $buku['created_at'] ?></td>
    </tr>

</table>

<br>

<a href="<?= base_url('buku') ?>">Kembali</a>
<a href="<?= base_url('buku/wa/' . $buku['id_buku']) ?>" target="_blank">Kirim WA</a>

<?= $this->endSection() ?>