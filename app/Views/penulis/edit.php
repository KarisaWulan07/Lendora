<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <h3 class="mb-4 fw-bold">
                <i class="bi bi-pencil-square me-2"></i> Edit Penulis
            </h3>

            <form method="post" action="<?= base_url('penulis/update/' . $penulis['id_penulis']) ?>">

                <div class="mb-3">
                    <label class="form-label">Nama Penulis</label>
                    <input type="text"
                           name="nama_penulis"
                           class="form-control"
                           value="<?= esc($penulis['nama_penulis']) ?>"
                           required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        Update
                    </button>

                    <a href="<?= base_url('penulis') ?>" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>