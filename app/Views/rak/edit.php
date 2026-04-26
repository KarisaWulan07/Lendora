<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
/* WRAPPER */
.form-box {
    max-width: 500px;
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
.form-control {
    border-radius: 10px;
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
            <i class="bi bi-pencil-square"></i> Edit Rak
        </h5>

        <!-- ALERT -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- FORM -->
        <form action="<?= base_url('rak/update/' . $rak['id_rak']) ?>" method="post">
            <?= csrf_field() ?>

            <!-- NAMA RAK -->
            <div class="mb-3">
                <label class="form-label">Nama Rak</label>
                <input type="text" name="nama_rak" class="form-control"
                       value="<?= old('nama_rak', $rak['nama_rak']) ?>" required>
            </div>

            <!-- LOKASI -->
            <div class="mb-3">
                <label class="form-label">Lokasi</label>
                <input type="text" name="lokasi" class="form-control"
                       value="<?= old('lokasi', $rak['lokasi']) ?>" required>
            </div>

            <!-- ACTION -->
            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Update
                </button>

                <a href="<?= base_url('rak') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

        </form>

    </div>

</div>

<?= $this->endSection() ?>