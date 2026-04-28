<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-3">

<!-- HEADER -->
<div class="mb-3">
    <h3>Dashboard Perpustakaan</h3>
</div>

<!-- STAT -->
<div class="row g-3">

    <div class="col-md-3">
        <div class="card bg-primary text-white p-3">
            <h6>Buku</h6>
            <h3><?= $total_buku ?? 0 ?></h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-success text-white p-3">
            <h6>Rak</h6>
            <h3><?= $total_rak ?? 0 ?></h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning text-white p-3">
            <h6>Dipinjam</h6>
            <h3><?= $dipinjam ?? 0 ?></h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-danger text-white p-3">
            <h6>Terlambat</h6>
            <h3><?= $terlambat ?? 0 ?></h3>
        </div>
    </div>

</div>

<!-- DENDA -->
<div class="mt-3">
    <div class="card p-3">
        <h5>Total Denda</h5>
        <h3>Rp <?= number_format($total_denda ?? 0, 0, ',', '.') ?></h3>
    </div>
</div>

<!-- ========================= -->
<!-- AKTIVITAS PEMINJAMAN BARU -->
<!-- ========================= -->
<div class="mt-4">
    <div class="card p-3">
        <h5>📌 Aktivitas Peminjaman Terbaru</h5>

        <?php if (!empty($aktivitas_pinjam)): ?>
            <?php foreach ($aktivitas_pinjam as $a): ?>
                <div class="d-flex align-items-center border-bottom py-2">

                    <div class="me-3">
                        <i class="bi bi-person-circle fs-3 text-primary"></i>
                    </div>

                    <div>
                        <b><?= $a['nama'] ?? 'Anggota' ?></b><br>
                        <small>
                            Meminjam buku: <b><?= $a['judul'] ?? '-' ?></b>
                        </small><br>
                        <small class="text-muted">
                            <?= $a['tanggal_pinjam'] ?? '' ?>
                        </small>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">Belum ada aktivitas peminjaman</p>
        <?php endif; ?>

    </div>
</div>

<!-- OVERDUE -->
<div class="mt-4">
    <div class="card p-3">
        <h5>⚠️ Overdue</h5>

        <?php if (!empty($overdue)): ?>
            <?php foreach ($overdue as $o): ?>
                <div class="border-bottom py-2">
                    <b>ID #<?= $o['id_peminjaman'] ?></b><br>
                    <small>Terlambat sejak: <?= $o['tanggal_kembali'] ?></small>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-success">Tidak ada keterlambatan</p>
        <?php endif; ?>

    </div>
</div>

</div>

<?= $this->endSection() ?>