<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Data Denda Saya</h2>

<?php if (session()->getFlashdata('success')) : ?>
    <p style="color:green;"><?= session()->getFlashdata('success') ?></p>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <p style="color:red;"><?= session()->getFlashdata('error') ?></p>
<?php endif; ?>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Buku</th>
        <th>Jumlah Denda</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    <?php $no = 1; foreach ($denda as $d): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $d['judul_buku'] ?? '-' ?></td>
        <td>Rp <?= number_format($d['jumlah_denda']) ?></td>

        <!-- STATUS -->
        <td>
            <?php if ($d['status'] == 'belum') : ?>
                <span style="color:red;">Belum Bayar</span>

            <?php elseif ($d['status'] == 'menunggu') : ?>
                <span style="color:orange;">Menunggu Verifikasi</span>

            <?php elseif ($d['status'] == 'lunas') : ?>
                <span style="color:green;">Lunas</span>

            <?php elseif ($d['status'] == 'ditolak') : ?>
                <span style="color:red;">Ditolak</span>
            <?php endif; ?>
        </td>

        <!-- AKSI -->
        <td>
            <?php if ($d['status'] == 'belum' || $d['status'] == 'ditolak') : ?>
                
                <p><b>Bayar via QRIS</b></p>

                <!-- QR AUTO -->
                <img src="<?= base_url('qr/qr_' . $d['id_denda'] . '.png') ?>" width="120">

                <!-- FORM UPLOAD -->
                <form action="<?= base_url('denda/konfirmasi') ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_denda" value="<?= $d['id_denda'] ?>">

                    <p>Upload Bukti:</p>
                    <input type="file" name="bukti" required>

                    <br><br>
                    <button type="submit">✔ Kirim Bukti</button>
                </form>

            <?php elseif ($d['status'] == 'menunggu') : ?>

                <p>⏳ Menunggu verifikasi admin</p>

                <?php if (!empty($d['bukti_pembayaran'])) : ?>
                    <a href="<?= base_url('uploads/bukti/' . $d['bukti_pembayaran']) ?>" target="_blank">
                        Lihat Bukti
                    </a>
                <?php endif; ?>

            <?php elseif ($d['status'] == 'lunas') : ?>

                <p>✔ Pembayaran selesai</p>

            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?= $this->endSection() ?>