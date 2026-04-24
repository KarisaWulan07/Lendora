<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Manajemen Denda (Admin)</h2>

<?php if (session()->getFlashdata('success')) : ?>
    <p style="color:green;"><?= session()->getFlashdata('success') ?></p>
<?php endif; ?>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Nama Anggota</th>
        <th>Buku</th>
        <th>Jumlah</th>
        <th>Status</th>
        <th>Bukti</th>
        <th>Aksi</th>
    </tr>

    <?php $no = 1; foreach ($denda as $d): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $d['nama_anggota'] ?? '-' ?></td>
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

        <!-- BUKTI PEMBAYARAN -->
        <td>
            <?php if (!empty($d['bukti_pembayaran'])) : ?>
               <img src="<?= base_url('uploads/bukti/' . $d['bukti_pembayaran']) ?>" width="80">
            <?php else : ?>
                -
            <?php endif; ?>
        </td>

        <!-- AKSI ADMIN -->
        <td>
            <?php if ($d['status'] == 'menunggu') : ?>

                <a href="<?= base_url('denda/lunas/' . $d['id_denda']) ?>">
                    ✔ Verifikasi Lunas
                </a>
                |
                <a href="<?= base_url('denda/tolak/' . $d['id_denda']) ?>">
                    ❌ Tolak
                </a>

            <?php elseif ($d['status'] == 'belum') : ?>
                <p>Belum ada pembayaran</p>

            <?php elseif ($d['status'] == 'lunas') : ?>
                <p>✔ Sudah Lunas</p>

            <?php elseif ($d['status'] == 'ditolak') : ?>
                <p style="color:red;">Pembayaran ditolak</p>

            <?php endif; ?>
        </td>

    </tr>
    <?php endforeach; ?>
</table>

<?= $this->endSection() ?>