<h2>Tambah Detail Buku</h2>

<form action="<?= base_url('/peminjaman/saveDetail/' . $id) ?>" method="post">
    <?= csrf_field(); ?>

    <table border="1" cellpadding="10">
        <tr>
            <th>Pilih Buku</th>
            <th>Jumlah</th>
        </tr>

        <?php foreach ($buku as $b): ?>
        <tr>
            <td>
                <input type="checkbox" name="id_buku[]" value="<?= $b['id_buku']; ?>">
                <?= $b['judul']; ?>
            </td>
            <td>
                <input type="number" name="jumlah[]" value="1" min="1">
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <button type="submit">Simpan</button>
</form>