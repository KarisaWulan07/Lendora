<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Data Penerbit</h2>

<a href="<?= base_url('penerbit/create') ?>">+ Tambah Penerbit</a>

<br><br>

<form method="get" action="<?= base_url('penerbit') ?>">
    <input type="text" name="keyword" placeholder="Cari penerbit..." value="<?= $_GET['keyword'] ?? '' ?>">
    <button type="submit">Cari</button>
       <a href="<?= base_url('penulis') ?>">Reset</a>
</form>

<br>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Nama Penerbit</th>
        <th>Aksi</th>
    </tr>

    <?php $no = 1; foreach ($penerbit as $row): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $row['nama_penerbit'] ?></td>
    
        <td>
            <a href="<?= base_url('penerbit/edit/' . $row['id_penerbit']) ?>">Edit</a>
            |
            <a href="<?= base_url('penerbit/delete/' . $row['id_penerbit']) ?>"
               onclick="return confirm('Yakin hapus data?')">
               Hapus
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?= $this->endSection() ?>