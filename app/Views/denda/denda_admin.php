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

/* HEADER */
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
}

.table-modern tr:hover {
    background: #f8fafc;
}

/* STATUS BADGE */
.badge-red { color: red; font-weight: 600; }
.badge-orange { color: orange; font-weight: 600; }
.badge-green { color: green; font-weight: 600; }

/* ACTION */
.action a {
    text-decoration: none;
    margin: 0 5px;
    font-size: 13px;
}

.action a:hover {
    text-decoration: underline;
}

.action .approve { color: green; }
.action .reject { color: red; }

</style>

<div class="container py-3">

    <div class="page-box">

        <!-- TITLE -->
        <h3 class="page-title">
            <i class="bi bi-cash-stack"></i> Manajemen Denda (Admin)
        </h3>

        <!-- SUCCESS -->
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <!-- TABLE -->
        <table class="table-modern">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Bukti</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

            <?php $no = 1; foreach ($denda as $d): ?>
            <tr>

                <td><?= $no++ ?></td>
                <td><?= $d['nama_anggota'] ?? '-' ?></td>
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

                <!-- BUKTI -->
                <td>
                    <?php if (!empty($d['bukti_pembayaran'])): ?>
                        <img src="<?= base_url('uploads/bukti/' . $d['bukti_pembayaran']) ?>"
                             width="70"
                             style="border-radius:8px;">
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>

                <!-- ACTION -->
                <td class="action">

                    <?php if ($d['status'] == 'menunggu'): ?>
                        <a class="approve"
                           href="<?= base_url('denda/lunas/' . $d['id_denda']) ?>">
                           ✔ Lunas
                        </a>

                        |
                        <a class="reject"
                           href="<?= base_url('denda/tolak/' . $d['id_denda']) ?>">
                           ❌ Tolak
                        </a>

                    <?php elseif ($d['status'] == 'belum'): ?>
                        <span>Belum bayar</span>

                    <?php elseif ($d['status'] == 'lunas'): ?>
                        <span class="badge-green">✔ Selesai</span>

                    <?php elseif ($d['status'] == 'ditolak'): ?>
                        <span class="badge-red">Ditolak</span>
                    <?php endif; ?>

                </td>

            </tr>
            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<?= $this->endSection() ?>