<?= $this->extend('layouts/main') ?> 
<?= $this->section('content') ?>

<style>
:root {
    --dark: #0B2E59;
    --mid: #0F4C75;
    --primary: #1B7F9F;
    --soft: #7FB3C8;
    --light: #C7DDE5;
}

/* BACKGROUND */
body {
    background: linear-gradient(135deg, #f4f8fb, #eaf2f7);
}

/* HEADER */
.dash-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.user-box {
    display: flex;
    align-items: center;
    background: rgba(255,255,255,0.8);
    backdrop-filter: blur(10px);
    padding: 10px 15px;
    border-radius: 14px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.05);
}

/* STAT CARD */
.stat-card {
    padding: 18px;
    border-radius: 18px;
    color: #fff;
    box-shadow: 0 12px 25px rgba(0,0,0,0.08);
    transition: 0.3s;
}

.stat-card:hover {
    transform: translateY(-6px);
}

.stat-card i {
    font-size: 18px;
    background: rgba(255,255,255,0.2);
    padding: 10px;
    border-radius: 10px;
}

.stat-card h4 {
    margin-top: 10px;
    font-weight: 700;
}

.stat-card span {
    font-size: 13px;
}

/* GRADIENT */
.blue   { background: linear-gradient(135deg, var(--dark), var(--mid)); }
.purple { background: linear-gradient(135deg, var(--mid), var(--primary)); }
.green  { background: linear-gradient(135deg, var(--primary), var(--soft)); }
.red    { background: linear-gradient(135deg, var(--mid), var(--soft)); }
.orange { background: linear-gradient(135deg, var(--primary), var(--light)); }

/* BOX */
.box {
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(12px);
    padding: 20px;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    height: 100%;
}

.box h6 {
    font-weight: 600;
    margin-bottom: 15px;
    color: var(--dark);
}

/* SHORTCUT */
.box a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
    border-radius: 12px;
    text-decoration: none;
    color: #333;
    transition: 0.25s;
}

.box a:hover {
    background: #f1f5f9;
    transform: translateX(6px);
}

/* LIST ITEM */
.act-item,
.notif {
    display: flex;
    gap: 10px;
    padding: 8px;
    border-radius: 10px;
    margin-bottom: 10px;
}

.act-item:hover { background: #f8fafc; }
.notif:hover { background: #fff5f5; }

/* RESPONSIVE */
@media (max-width: 768px) {
    .dash-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}
</style>

<div class="container-fluid py-3 dashboard">

    <!-- HEADER -->
    <div class="dash-header">
        <div>
            <h3 class="fw-bold mb-0">Selamat Datang di Dashboard Perpustakaan</h3>
            <small class="text-muted">Temukan, kelola, dan pantau semua aktivitas dengan mudah</small>
        </div>

        <div class="user-box">
            <i class="bi bi-person-circle fs-3 text-primary"></i>
            <div class="ms-2">
                <div class="fw-semibold">
                    <?= session()->get('nama') ?? 'Admin' ?>
                </div>
                <small class="text-muted">
                    <?= session()->get('role') ?? 'petugas' ?>
                </small>
            </div>
        </div>
    </div>

   <!-- STAT -->
<div class="row g-3">
    <?php
    $stats = [
        [
            'icon'  => 'bi-book',
            'value' => 10,
            'label' => 'Buku',
            'class' => 'blue'
        ],
        [
            'icon'  => 'bi-archive',
            'value' => 5,
            'label' => 'Rak (A–E)',
            'class' => 'purple'
        ],
        [
            'icon'  => 'bi-journal-check',
            'value' => 94,
            'label' => 'Dipinjam',
            'class' => 'green'
        ],
        [
            'icon'  => 'bi-exclamation-triangle',
            'value' => 5,
            'label' => 'Terlambat',
            'class' => 'red'
        ],
        [
            'icon'  => 'bi-cash',
            'value' => 'Rp 1.000',
            'label' => 'Denda',
            'class' => 'orange'
        ],
    ];
    ?>

    <?php foreach ($stats as $s): ?>
        <div class="col-md-2">
            <div class="stat-card <?= $s['class'] ?>">
                <i class="bi <?= $s['icon'] ?>"></i>
                <h4><?= $s['value'] ?></h4>
                <span><?= $s['label'] ?></span>
            </div>
        </div>
    <?php endforeach; ?>
</div>
    <!-- GRID -->
    <div class="row mt-4 g-3">

        <!-- SHORTCUT -->
        <div class="col-lg-3">
            <div class="box">
                <h6>Shortcut</h6>
                <div class="d-grid gap-2">
                    <a href="<?= base_url('buku') ?>" class="btn btn-light text-start">
                        <i class="bi bi-book text-primary"></i> Buku
                    </a>
                    <a href="<?= base_url('rak') ?>" class="btn btn-light text-start">
                        <i class="bi bi-archive text-warning"></i> Rak
                    </a>
                    <a href="<?= base_url('peminjaman') ?>" class="btn btn-light text-start">
                        <i class="bi bi-journal text-success"></i> Peminjaman
                    </a>
                    <a href="<?= base_url('denda') ?>" class="btn btn-light text-start">
                        <i class="bi bi-cash text-danger"></i> Denda
                    </a>
                </div>
            </div>
        </div>

        <!-- AKTIVITAS -->
        <div class="col-lg-4">
            <div class="box">
                <h6>Aktivitas</h6>

                <?php if (!empty($aktivitas)): ?>
                    <?php foreach ($aktivitas as $a): ?>
                        <div class="act-item">
                            <i class="bi bi-arrow-right-circle text-primary"></i>
                            <div>
                                <div>ID #<?= $a['id_peminjaman'] ?></div>
                                <small><?= $a['status'] ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>

                    <div class="act-item">
                        <i class="bi bi-book text-warning"></i>
                        <div>
                            <div><b>Anggota</b></div>
                            <small>Meminjam buku "Laskar Pelangi"</small><br>
                            <small class="text-muted">Baru saja</small>
                        </div>
                    </div>

                    <div class="act-item">
                        <i class="bi bi-check-circle text-success"></i>
                        <div>
                            <div><b>Anggota</b></div>
                            <small>Mengembalikan buku</small><br>
                            <small class="text-muted">Hari ini</small>
                        </div>
                    </div>

                    <div class="act-item">
                        <i class="bi bi-exclamation-circle text-danger"></i>
                        <div>
                            <div><b>Sistem</b></div>
                            <small>Denda keterlambatan dibuat</small><br>
                            <small class="text-muted">1 jam lalu</small>
                        </div>
                    </div>

                    <div class="act-item">
                        <i class="bi bi-credit-card text-primary"></i>
                        <div>
                            <div><b>Anggota</b></div>
                            <small>Melakukan pembayaran denda</small><br>
                            <small class="text-muted">Kemarin</small>
                        </div>
                    </div>

                <?php endif; ?>
            </div>
        </div>

        <!-- OVERDUE -->
        <div class="col-lg-5">
            <div class="box">
                <h6>⚠️ Overdue</h6>

                <?php if (!empty($overdue)): ?>
                    <?php foreach ($overdue as $o): ?>
                        <div class="notif">
                            <i class="bi bi-alarm text-danger"></i>
                            <div>
                                <div><b>ID #<?= $o['id_peminjaman'] ?></b></div>
                                <small>Terlambat sejak: <?= $o['tanggal_kembali'] ?></small>

                                <?php if (!empty($o['nama'])): ?>
                                    <br>
                                    <small class="text-muted"><?= $o['nama'] ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="notif">
                        <i class="bi bi-alarm text-danger"></i>
                        <div>
                            <div><b>ID #101</b></div>
                            <small>Terlambat sejak: 20 Apr 2026</small><br>
                            <small class="text-muted">Anggota</small>
                        </div>
                    </div>

                    <div class="notif">
                        <i class="bi bi-alarm text-danger"></i>
                        <div>
                            <div><b>ID #102</b></div>
                            <small>Terlambat sejak: 22 Apr 2026</small><br>
                            <small class="text-muted">Anggota</small>
                        </div>
                    </div>

                    <div class="notif">
                        <i class="bi bi-check-circle text-success"></i>
                        <div>
                            <div><b>Semua Aman</b></div>
                            <small class="text-muted">Tidak ada keterlambatan saat ini</small>
                        </div>
                    </div>

                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>