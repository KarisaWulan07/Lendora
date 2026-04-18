

<h3>Data Penerbit</h3>

<a href="<?= base_url('penerbit/create') ?>">+ Tambah</a>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Nama Penerbit</th>
        <th>Alamat</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($penerbit as $p): ?>
    <tr>
        <td><?= $p['id_penerbit'] ?></td>
        <td><?= $p['nama_penerbit'] ?></td>
        <td><?= $p['alamat'] ?></td>
        <td>
            <a href="<?= base_url('penerbit/edit/'.$p['id_penerbit']) ?>">Edit</a>
            <a href="<?= base_url('penerbit/delete/'.$p['id_penerbit']) ?>" onclick="return confirm('Hapus data?')">Hapus</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>