<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Data Denda</h2>

<form method="get">
    <input type="text" name="search" placeholder="Cari nama / ID..."
           value="<?= esc($search ?? '') ?>">
    <button type="submit">Search</button>
</form>

<br>

<table border="1" cellpadding="8" width="100%">

<tr>
    <th>ID</th>
    <th>ID Peminjaman</th>
    <th>Nama</th>
    <th>Jumlah</th>
    <th>Status</th>
    <th>Metode</th>
    <th>Bukti</th>
    <th>Petugas Verifikasi</th>
    <th>Aksi</th>
</tr>

<?php if (!empty($denda)) : ?>
<?php foreach ($denda as $d): ?>

<?php
$status = $d['status_denda'] ?? 'belum';
$role = session()->get('role');
?>

<tr>

    <td><?= $d['id_denda'] ?></td>
    <td><?= $d['id_peminjaman'] ?? '-' ?></td>
    <td><?= $d['nama_anggota'] ?? '-' ?></td>

    <!-- JUMLAH DENDA -->
    <td>
        <?php if (!empty($d['jumlah_denda']) && $d['jumlah_denda'] > 0): ?>
            <span style="color:red;">
                Rp <?= number_format($d['jumlah_denda'] ?? 0,0,',','.') ?>
            </span>
        <?php else: ?>
            -
        <?php endif; ?>
    </td>

    <!-- STATUS -->
    <td>
        <?php if ($status == 'belum'): ?>
            <span style="color:red;">Belum Bayar</span>

        <?php elseif ($status == 'menunggu'): ?>
            <span style="color:orange;">Menunggu Verifikasi</span>

        <?php elseif ($status == 'lunas'): ?>
            <span style="color:green;">Lunas</span>

        <?php elseif ($status == 'ditolak'): ?>
            <span style="color:red;">Ditolak</span>
        <?php endif; ?>
    </td>

    <td><?= $d['metode_pembayaran'] ?? '-' ?></td>

    <td>
        <?php if (!empty($d['bukti_pembayaran'])): ?>
            <a href="<?= base_url('uploads/bukti/' . $d['bukti_pembayaran']) ?>" target="_blank">
                Lihat Bukti
            </a>
        <?php else: ?>
            -
        <?php endif; ?>
    </td>

    <!-- 🔥 PETUGAS VERIFIKASI (FIX AMAN) -->
    <td>
        <?= $d['nama_petugas_verif'] ?? '-' ?>
    </td>

    <!-- AKSI -->
    <td>

<?php if ($status == 'belum'): ?>

    <a href="<?= base_url('denda/bayar/'.$d['id_denda']) ?>">
    Bayar
</a>

</td>

        <?php elseif ($status == 'menunggu'): ?>

            <?php if (in_array($role, ['admin','petugas'])): ?>

                <a href="<?= base_url('denda/approve/'.$d['id_denda']) ?>" style="color:green;">
                    ✔ Approve
                </a>
                |
                <a href="<?= base_url('denda/tolak/'.$d['id_denda']) ?>" style="color:red;">
                    ✖ Tolak
                </a>

                |
                <a href="<?= base_url('denda/verifikasi/'.$d['id_denda']) ?>" style="color:blue;">
                    ✔ Verifikasi
                </a>

            <?php else: ?>
                <span style="color:orange;">Menunggu Verifikasi</span>
            <?php endif; ?>

        <?php elseif ($status == 'lunas'): ?>
            <span style="color:green;">✔ Selesai</span>

        <?php elseif ($status == 'ditolak'): ?>

            <?php if ($role == 'anggota'): ?>
                <a href="<?= base_url('denda/bayar/'.$d['id_denda']) ?>">Bayar Ulang</a>
            <?php else: ?>
                <span style="color:red;">Ditolak</span>
            <?php endif; ?>

        <?php endif; ?>

    </td>

</tr>

<?php endforeach; ?>
<?php else: ?>
<tr>
    <td colspan="9" style="text-align:center;">
        Tidak ada data denda
    </td>
</tr>
<?php endif; ?>

</table>
<!-- 🔥 INI TEMPATNYA SCRIPT -->
<script>
function bayarQris(id) {
    alert("Kamu akan diarahkan ke halaman QRIS");
    window.location.href = "<?= base_url('denda/qris/') ?>" + id;
}
</script>

<?= $this->endSection() ?>
