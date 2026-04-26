<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
/* WRAPPER */
.detail-box {
    max-width: 800px;
    margin: 20px auto;
    padding: 25px;
    border-radius: 18px;
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(12px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

/* HEADER */
.detail-header {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
    align-items: center;
}

.cover-img {
    width: 110px;
    height: 150px;
    object-fit: cover;
    border-radius: 12px;
}

/* ITEM */
.detail-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.detail-item:last-child {
    border-bottom: none;
}

.label {
    color: #555;
    font-weight: 500;
}

.value {
    font-weight: 600;
    text-align: right;
    max-width: 60%;
}

/* DESKRIPSI */
.desc {
    white-space: pre-line;
}

/* ACTION */
.action {
    margin-top: 20px;
    display: flex;
    gap: 10px;
}
</style>

<div class="container-fluid py-3">

    <div class="detail-box">

        <!-- HEADER -->
        <div class="detail-header">

            <?php if ($buku['cover']): ?>
                <img src="<?= base_url('uploads/buku/' . $buku['cover']) ?>" class="cover-img">
            <?php else: ?>
                <img src="<?= base_url('assets/img/default-book.png') ?>" class="cover-img">
            <?php endif; ?>

            <div>
                <h5 class="mb-1"><?= $buku['judul'] ?></h5>
                <small class="text-muted">
                    <?= $buku['nama_penulis'] ?? '-' ?>
                </small>
            </div>

        </div>

        <!-- DETAIL -->
        <div class="detail-item">
            <div class="label">ISBN</div>
            <div class="value"><?= $buku['isbn'] ?: '-' ?></div>
        </div>

        <div class="detail-item">
            <div class="label">Kategori</div>
            <div class="value"><?= $buku['nama_kategori'] ?? '-' ?></div>
        </div>

        <div class="detail-item">
            <div class="label">Penulis</div>
            <div class="value"><?= $buku['nama_penulis'] ?? '-' ?></div>
        </div>

        <div class="detail-item">
            <div class="label">Penerbit</div>
            <div class="value"><?= $buku['nama_penerbit'] ?? '-' ?></div>
        </div>

        <div class="detail-item">
            <div class="label">Rak</div>
            <div class="value">
                <?= $buku['nama_rak'] ?> - <?= $buku['lokasi'] ?>
            </div>
        </div>

        <div class="detail-item">
            <div class="label">Tahun Terbit</div>
            <div class="value"><?= $buku['tahun_terbit'] ?: '-' ?></div>
        </div>

        <div class="detail-item">
            <div class="label">Jumlah</div>
            <div class="value"><?= $buku['jumlah'] ?></div>
        </div>

        <div class="detail-item">
            <div class="label">Tersedia</div>
            <div class="value">
                <span class="badge bg-success">
                    <?= $buku['tersedia'] ?>
                </span>
            </div>
        </div>

        <div class="detail-item">
            <div class="label">Deskripsi</div>
            <div class="value desc">
                <?= $buku['deskripsi'] ?: '-' ?>
            </div>
        </div>

        <div class="detail-item">
            <div class="label">Dibuat</div>
            <div class="value"><?= $buku['created_at'] ?></div>
        </div>

        <!-- ACTION -->
        <div class="action">

            <?php if (session()->get('role') == 'admin'): ?>
                <a href="<?= base_url('buku') ?>" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            <?php else: ?>
                <a href="<?= base_url('peminjaman/create') ?>" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            <?php endif; ?>

            <a href="<?= base_url('buku/wa/' . $buku['id_buku']) ?>"
               target="_blank"
               class="btn btn-success btn-sm">
                <i class="bi bi-whatsapp"></i> WA
            </a>

        </div>

    </div>

</div>

<?= $this->endSection() ?>