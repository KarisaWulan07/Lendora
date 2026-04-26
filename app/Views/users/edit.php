<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
/* WRAPPER */
.form-box {
    max-width: 600px;
    margin: 20px auto;
    padding: 25px;
    border-radius: 18px;
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(12px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

/* TITLE */
.form-title {
    font-weight: 600;
    color: #0B2E59;
    margin-bottom: 15px;
}

/* INPUT */
.form-control,
.form-select {
    border-radius: 10px;
}

/* FOTO */
.preview-img {
    width: 90px;
    height: 90px;
    border-radius: 12px;
    object-fit: cover;
    margin-top: 10px;
}

/* BUTTON */
.btn-primary {
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, #0B2E59, #1B7F9F);
}

.btn-primary:hover {
    opacity: 0.9;
}
</style>

<div class="container-fluid py-3">

    <div class="form-box">

        <!-- TITLE -->
        <h5 class="form-title">
            <i class="bi bi-pencil-square"></i> Edit User
        </h5>

        <!-- FORM -->
        <form action="<?= base_url('users/update/' . $user['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control"
                       value="<?= $user['nama'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                       value="<?= $user['email'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control"
                       value="<?= $user['username'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control">
                <small class="text-muted">Kosongkan jika tidak ingin diubah</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select">
                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="petugas" <?= $user['role'] == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                    <option value="anggota" <?= $user['role'] == 'anggota' ? 'selected' : '' ?>>Anggota</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto Profil</label>
                <input type="file" name="foto" class="form-control">

                <div class="mt-2">
                    <small class="text-muted">Foto saat ini:</small><br>

                    <?php if ($user['foto']): ?>
                        <img src="<?= base_url('uploads/users/' . $user['foto']) ?>" class="preview-img">
                    <?php else: ?>
                        <span class="text-muted">Tidak ada foto</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ACTION -->
            <div class="d-flex justify-content-between mt-3">

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Update
                </button>

                <a href="<?= base_url('users') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>

            </div>

        </form>

    </div>

</div>

<?= $this->endSection() ?>