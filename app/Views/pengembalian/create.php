<?= $this->extend('layouts/main') ?> 
<?= $this->section('content') ?>

<h2>Pengembalian Buku</h2>

<?php if (session()->getFlashdata('error')) : ?>
    <p style="color:red"><?= session()->getFlashdata('error') ?></p>
<?php endif; ?>

<form action="<?= base_url('pengembalian/store') ?>" method="post">

    <table cellpadding="8">

        <tr>
            <td>Peminjaman</td>
            <td>
                <input list="peminjaman_list" name="id_peminjaman" required placeholder="Ketik ID Peminjaman">

                <datalist id="peminjaman_list">
                    <?php foreach ($peminjaman as $p) : ?>
                        <option value="<?= $p['id_peminjaman'] ?>">
                            ID <?= $p['id_peminjaman'] ?> - <?= $p['tanggal_pinjam'] ?>
                        </option>
                    <?php endforeach; ?>
                </datalist>
            </td>
        </tr>

        <tr>
            <td>Tanggal Kembali</td>
            <td>
                <input type="date" name="tanggal_dikembalikan" value="<?= date('Y-m-d') ?>" readonly>
            </td>
        </tr>

        <tr>
            <td>Denda</td>
            <td>
                <!-- 🔥 tetap ada (optional / hanya tampilan) -->
                <input type="number" name="denda" value="0" readonly>
                <small>*Denda dihitung otomatis oleh sistem</small>
            </td>
        </tr>

        <!-- 🔥 TAMBAHAN METODE PEMBAYARAN -->
        <tr>
            <td>Metode Pembayaran</td>
            <td>
                <select name="metode_pembayaran">
                    <option value="">-- Bayar nanti --</option>
                    <option value="cash">Cash</option>
                    <option value="qris">QRIS / DANA</option>
                </select>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="submit">Simpan</button>
            </td>
        </tr>

    </table>

</form>

<?= $this->endSection() ?>