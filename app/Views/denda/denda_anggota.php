<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
:root {
    --dark: #0B2E59;
    --mid: #0F4C75;
    --primary: #1B7F9F;
}

/* CONTAINER */
.page-box {
    background: rgba(255,255,255,0.88);
    backdrop-filter: blur(12px);
    border-radius: 18px;
    padding: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

/* TITLE */
.page-title {
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 15px;
}

/* TABLE */
.table-modern {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.table-modern th {
    background: linear-gradient(135deg, var(--dark), var(--mid));
    color: #fff;
    padding: 10px;
    text-align: center;
}

.table-modern td {
    padding: 10px;
    border-bottom: 1px solid #eee;
    text-align: center;
    vertical-align: top;
}

.table-modern tr:hover {
    background: #f8fafc;
}

/* STATUS */
.badge-red { color: red; font-weight: 600; }
.badge-orange { color: orange; font-weight: 600; }
.badge-green { color: green; font-weight: 600; }

/* CARD QR */
.qr-box {
    margin-top: 10px;
}

.qr-box img {
    border-radius: 10px;
    margin-top: 5px;
}

/* BUTTON */
.btn-upload {
    margin-top: 10px;
    padding: 6px 10px;
    border: none;
    border-radius: 8px;
    background: linear-gradient(135deg, var(--dark), var(--mid));
    color: #fff;
    font-size: 13px;
}

.btn-upload:hover {
    opacity: 0.9;
}

/* LINK */
.link {
    color: var(--primary);
    text-decoration: none;
    font-size: 13px;
}

.link:hover {
    text-decoration: underline;
}
</style>

<div class="container py-3">

    <div class="page-box">

        <h3 class="page-title">
            <i class="bi bi-wallet2"></i> Data Denda Saya
        </h3>

        <!-- FLASH -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- TABLE -->
        <table class="table-modern">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Buku</th>
                    <th>Jumlah Denda</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

            <?php $no = 1; foreach ($denda as $d): ?>
            <tr>

                <td><?= $no++ ?></td>
                <td><?= $d['judul_buku'] ?? '-' ?></td>

                <td>
                    Rp <?= number_format($d['jumlah_denda'],0,',','.') ?>
                </td>

                <!-- STATUS -->
                <td>
                    <?php if ($d['status'] == 'belum'): ?>
                        <span class="badge-red">Belum Bayar</span>

                    <?php elseif ($d['status'] == 'menunggu'): ?>
                        <span class="badge-orange">Menunggu</span>

                    <?php elseif ($d['status'] == 'lunas'): ?>
                        <span class="badge-green">Lunas</span>

                    <?php elseif ($d['status'] == 'ditolak'): ?>
                        <span class="badge-red">Ditolak</span>
                    <?php endif; ?>
                </td>

                <!-- AKSI -->
                <td>

                    <?php if ($d['status'] == 'belum' || $d['status'] == 'ditolak'): ?>

                        <div class="qr-box">
                            <b>Bayar via QRIS</b><br>

                            <img src="<?= base_url('qr/qr_' . $d['id_denda'] . '.png') ?>"
                                 width="120">
                        </div>

                        <form action="<?= base_url('denda/konfirmasi') ?>"
                              method="post"
                              enctype="multipart/form-data">

                            <input type="hidden" name="id_denda"
                                   value="<?= $d['id_denda'] ?>">

                            <input type="file" name="bukti" class="form-control mt-2" required>

                            <button type="submit" class="btn-upload">
                                ✔ Kirim Bukti
                            </button>

                        </form>

                    <?php elseif ($d['status'] == 'menunggu'): ?>

                        <p>⏳ Menunggu verifikasi admin</p>

                        <?php if (!empty($d['bukti_pembayaran'])): ?>
                            <a class="link"
                               target="_blank"
                               href="<?= base_url('uploads/bukti/' . $d['bukti_pembayaran']) ?>">
                               Lihat Bukti
                            </a>
                        <?php endif; ?>

                    <?php elseif ($d['status'] == 'lunas'): ?>

                        <span class="badge-green">✔ Pembayaran selesai</span>

                    <?php endif; ?>

                </td>

            </tr>
            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<?= $this->endSection() ?>