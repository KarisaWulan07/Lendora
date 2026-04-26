<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-3">
        <h3 class="fw-bold">
            <i class="bi bi-tags me-2"></i> Tambah Kategori
        </h3>
    </div>

    <!-- CARD FORM -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form method="post" action="<?= base_url('kategori/store') ?>">

                <!-- INPUT -->
                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text"
                           name="nama_kategori"
                           class="form-control"
                           placeholder="Masukkan nama kategori"
                           required>
                </div>

                <!-- BUTTON -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>

                    <a href="<?= base_url('kategori') ?>" class="btn btn-outline-secondary">
                        Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>