<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$today = date('Y-m-d');
$isTelat = false;

if (
    ($peminjaman['status'] ?? '') == 'dipinjam' &&
    !empty($peminjaman['tanggal_kembali']) &&
    $today > $peminjaman['tanggal_kembali']
) {
    $isTelat = true;
}
?>

<style>
/* BOX */
.box {
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(12px);
    padding: 20px;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

/* LABEL */
.label {
    font-size: 13px;
    color: #666;
}

/* VALUE */
.value {
    font-weight: 600;
}

/* TABLE */
.table-custom thead {
    background: #0B2E59;
    color: #fff;
}
</style>

<div class="container-fluid py-3">

    <!-- TITLE -->
    <h4 class="fw-bold mb-3">
        <i class="bi bi-journal-text"></i> Detail Peminjaman
    </h4>

    <!-- INFO -->
    <div class="box mb-3">

        <div class="row g-3">

            <div class="col-md-3">
                <div class="label">Anggota</div>
                <div class="value"><?= $peminjaman['nama_anggota'] ?></div>
            </div>

            <div class="col-md-3">
                <div class="label">Petugas</div>
                <div class="value"><?= $peminjaman['nama_petugas'] ?></div>
            </div>

            <div class="col-md-3">
                <div class="label">Tanggal Pinjam</div>
                <div class="value"><?= $peminjaman['tanggal_pinjam'] ?></div>
            </div>

            <div class="col-md-3">
                <div class="label">Tanggal Kembali</div>
                <div class="value"><?= $peminjaman['tanggal_kembali'] ?></div>
            </div>

        </div>

        <hr>

        <!-- STATUS -->
        <div>
            <span class="label">Status:</span>

            <?php if (($peminjaman['status'] ?? '') == 'dipinjam' && $isTelat): ?>
                <span class="badge bg-danger">TELAT</span>

            <?php elseif (($peminjaman['status'] ?? '') == 'dipinjam'): ?>
                <span class="badge bg-primary">Dipinjam</span>

            <?php else: ?>
                <span class="badge bg-success">Dikembalikan</span>
            <?php endif; ?>
        </div>

    </div>

    <!-- DETAIL BUKU -->
    <div class="box">

        <h6 class="fw-semibold mb-3">Daftar Buku</h6>

        <div class="table-responsive">
            <table class="table table-hover align-middle table-custom">

                <thead>
                    <tr>
                        <th>Buku</th>
                        <th width="15%">Jumlah</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($detail)): ?>
                        <?php foreach($detail as $d): ?>
                            <tr>
                                <td><?= $d['judul'] ?></td>
                                <td><?= $d['jumlah'] ?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" class="text-center text-muted">
                                Tidak ada data buku
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>

    </div>

    <!-- BACK -->
    <div class="mt-3">
        <a href="<?= base_url('peminjaman') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

</div>

<?= $this->endSection() ?>