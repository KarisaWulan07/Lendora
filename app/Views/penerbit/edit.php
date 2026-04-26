<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <h3 class="mb-4 fw-bold">
                <i class="bi bi-pencil-square me-2"></i> Edit Penerbit
            </h3>

            <form action="<?= base_url('penerbit/update/' . $penerbit['id_penerbit']) ?>" method="post">

                <div class="mb-3">
                    <label class="form-label">Nama Penerbit</label>
                    <input type="text"
                           name="nama_penerbit"
                           class="form-control"
                           value="<?= esc($penerbit['nama_penerbit']) ?>"
                           required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        Update
                    </button>

                    <a href="<?= base_url('penerbit') ?>" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>