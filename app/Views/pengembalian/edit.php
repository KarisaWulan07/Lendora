<?= $this->extend('layouts/main') ?> 
<?= $this->section('content') ?>

<style>
:root {
    --dark: #0B2E59;
    --mid: #0F4C75;
    --primary: #1B7F9F;
    --soft: #7FB3C8;
}

.form-box {
    max-width: 600px;
    margin: 30px auto;
    padding: 25px;
    border-radius: 18px;
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(12px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.form-title {
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 20px;
}

.form-control {
    border-radius: 10px;
}

.btn-primary {
    background: linear-gradient(135deg, var(--dark), var(--mid));
    border: none;
    border-radius: 10px;
}

.btn-primary:hover {
    opacity: 0.9;
}
</style>

<div class="container">

    <div class="form-box">

        <h4 class="form-title">
            <i class="bi bi-pencil-square"></i> Edit Pengembalian
        </h4>

        <form action="<?= base_url('pengembalian/update/' . $kembali['id_pengembalian']) ?>" method="post">

            <!-- ID PEMINJAMAN -->
            <div class="mb-3">
                <label class="form-label">ID Peminjaman</label>
                <input type="text" name="id_peminjaman" class="form-control"
                       value="<?= $kembali['id_peminjaman'] ?>">
            </div>

            <!-- TANGGAL -->
            <div class="mb-3">
                <label class="form-label">Tanggal Dikembalikan</label>
                <input type="date" name="tanggal_dikembalikan" class="form-control"
                       value="<?= $kembali['tanggal_dikembalikan'] ?>">
            </div>

            <!-- DENDA -->
            <div class="mb-3">
                <label class="form-label">Denda</label>
                <input type="number" name="denda" class="form-control"
                       value="<?= $kembali['denda'] ?>">
            </div>

            <!-- BUTTON -->
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary px-4">
                    Update
                </button>

                <a href="<?= base_url('pengembalian') ?>" class="btn btn-secondary">
                    Kembali
                </a>
            </div>

        </form>

    </div>

</div>

<?= $this->endSection() ?>