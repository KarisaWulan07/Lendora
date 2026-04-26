<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
/* WRAPPER */
.detail-box {
    max-width: 700px;
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
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
}

.detail-img {
    width: 80px;
    height: 80px;
    border-radius: 15px;
    object-fit: cover;
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
}

/* BUTTON */
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

            <?php if ($user['foto']): ?>
                <img src="<?= base_url('uploads/users/' . $user['foto']) ?>" class="detail-img">
            <?php else: ?>
                <img src="<?= base_url('assets/img/default.png') ?>" class="detail-img">
            <?php endif; ?>

            <div>
                <h5 class="mb-0"><?= $user['nama'] ?></h5>
                <small class="text-muted"><?= ucfirst($user['role']) ?></small>
            </div>

        </div>

        <!-- DETAIL -->
        <div class="detail-item">
            <div class="label">Email</div>
            <div class="value"><?= $user['email'] ?></div>
        </div>

        <div class="detail-item">
            <div class="label">Username</div>
            <div class="value"><?= $user['username'] ?></div>
        </div>

        <div class="detail-item">
            <div class="label">Password</div>
            <div class="value">********</div>
        </div>

        <div class="detail-item">
            <div class="label">Role</div>
            <div class="value">
                <span class="badge bg-primary">
                    <?= ucfirst($user['role']) ?>
                </span>
            </div>
        </div>

        <!-- ACTION -->
        <div class="action">

            <a href="<?= base_url('users') ?>" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            <?php if (session()->get('role') == 'admin') : ?>
                <a href="<?= base_url('users/edit/' . $user['id']) ?>" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            <?php endif; ?>

        </div>

    </div>

</div>

<?= $this->endSection() ?>