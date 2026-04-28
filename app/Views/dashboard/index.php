<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
:root {
    --dark: #0B2E59;
    --primary: #1B7F9F;
}

/* BACKGROUND */
body {
    background: linear-gradient(135deg, #f4f8fb, #eaf2f7);
}

/* HEADER */
.dashboard-header {
    background: linear-gradient(135deg, var(--dark), var(--primary));
    color: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

/* STAT CARD */
.stat-card {
    background: linear-gradient(135deg, var(--dark), var(--primary));
    padding: 18px;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    transition: .3s;
    color: white;
}
.stat-card:hover {
    transform: translateY(-5px);
}

.stat-title {
    font-size: 14px;
    color: rgba(255,255,255,0.8);
}

.stat-value {
    font-size: 26px;
    font-weight: bold;
}

/* ICON */
.stat-icon {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    background: rgba(255,255,255,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
}

/* BADGE CUSTOM (INI YANG DIPERBAIKI) */
.badge-custom {
    background: linear-gradient(135deg, var(--dark), var(--primary));
    color: white;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
}

/* BOX */
.box {
    background: white;
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}
</style>

<div class="container-fluid py-3">

<!-- HEADER -->
<div class="dashboard-header mb-4">
    <h4 class="mb-2">Dashboard Perpustakaan</h4>
    <small>Monitoring data perpustakaan</small>
</div>

<!-- STAT -->
<div class="row g-3">

    <div class="col">
        <div class="stat-card d-flex justify-content-between align-items-center">
            <div>
                <div class="stat-title">Buku</div>
                <div class="stat-value"><?= $total_buku ?></div>
            </div>
            <div class="stat-icon"><i class="bi bi-book"></i></div>
        </div>
    </div>

    <div class="col">
        <div class="stat-card d-flex justify-content-between align-items-center">
            <div>
                <div class="stat-title">Rak</div>
                <div class="stat-value"><?= $total_rak ?></div>
            </div>
            <div class="stat-icon"><i class="bi bi-archive"></i></div>
        </div>
    </div>

    <div class="col">
        <div class="stat-card d-flex justify-content-between align-items-center">
            <div>
                <div class="stat-title">Dipinjam</div>
                <div class="stat-value"><?= $dipinjam ?></div>
            </div>
            <div class="stat-icon"><i class="bi bi-journal"></i></div>
        </div>
    </div>

    <div class="col">
        <div class="stat-card d-flex justify-content-between align-items-center">
            <div>
                <div class="stat-title">Terlambat</div>
                <div class="stat-value"><?= $terlambat ?></div>
            </div>
            <div class="stat-icon"><i class="bi bi-exclamation-triangle"></i></div>
        </div>
    </div>

    <div class="col">
        <div class="stat-card d-flex justify-content-between align-items-center">
            <div>
                <div class="stat-title">Denda</div>
                <div class="stat-value">
                    Rp <?= number_format($total_denda,0,',','.') ?>
                </div>
            </div>
            <div class="stat-icon"><i class="bi bi-cash"></i></div>
        </div>
    </div>

</div>

<!-- AKTIVITAS -->
<div class="mt-4 box">
    <h5 class="mb-3">📌 Aktivitas Peminjaman</h5>

    <?php foreach ($aktivitas_pinjam as $a): ?>
        <div class="d-flex justify-content-between border-bottom py-2">
            <div>
                <b>Anggota ID: <?= $a['id_anggota'] ?></b><br>
                <small>Tanggal Pinjam: <?= $a['tanggal_pinjam'] ?></small>
            </div>
            <span class="badge-custom">Aktif</span>
        </div>
    <?php endforeach; ?>
</div>

<br>

<div class="row mt-4 g-3">

    <!-- SHORTCUT -->
    <div class="col-lg-3">
        <div class="box h-100">
            <h6>Shortcut</h6>

            <div class="d-grid gap-2">
                <a href="<?= base_url('buku') ?>" class="btn btn-light text-start">
                    <i class="bi bi-book text-primary"></i> Buku
                </a>

                <a href="<?= base_url('rak') ?>" class="btn btn-light text-start">
                    <i class="bi bi-archive text-primary"></i> Rak
                </a>

                <a href="<?= base_url('peminjaman') ?>" class="btn btn-light text-start">
                    <i class="bi bi-journal text-primary"></i> Peminjaman
                </a>

                <a href="<?= base_url('denda') ?>" class="btn btn-light text-start">
                    <i class="bi bi-cash text-primary"></i> Denda
                </a>
            </div>
        </div>
    </div>

    <!-- OVERDUE -->
    <div class="col-lg-3">
        <div class="box h-100">
            <h6>⚠️ Overdue</h6>

            <div style="max-height: 250px; overflow-y: auto;">

                <?php if (!empty($overdue)): ?>
                    <?php foreach ($overdue as $o): ?>
                        <div class="border-bottom py-2">
                            <b>ID #<?= $o['id_peminjaman'] ?></b><br>
                            <small>Tenggat: <?= $o['tanggal_kembali'] ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-success">Tidak ada keterlambatan</p>
                <?php endif; ?>

            </div>
        </div>
    </div>

</div>

</div>

<?= $this->endSection() ?>