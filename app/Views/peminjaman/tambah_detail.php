<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
/* BOX */
.box {
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(12px);
    padding: 20px;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

/* TABLE */
.table-custom thead {
    background: #0B2E59;
    color: #fff;
}

/* INPUT QTY */
.qty-input {
    width: 80px;
}

/* ROW HOVER */
.table-custom tbody tr:hover {
    background: #f8fafc;
}
</style>

<div class="container-fluid py-3">

    <!-- TITLE -->
    <h4 class="fw-bold mb-3">
        <i class="bi bi-book"></i> Tambah Detail Buku
    </h4>

    <div class="box">

        <form action="<?= base_url('/peminjaman/saveDetail/' . $id) ?>" method="post">
            <?= csrf_field(); ?>

            <div class="table-responsive">
                <table class="table table-hover align-middle table-custom">

                    <thead>
                        <tr>
                            <th width="10%">Pilih</th>
                            <th>Judul Buku</th>
                            <th width="20%">Jumlah</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($buku)): ?>
                            <?php foreach ($buku as $b): ?>
                                <tr>

                                    <!-- CHECKBOX -->
                                    <td class="text-center">
                                        <input type="checkbox"
                                               class="form-check-input"
                                               name="buku[<?= $b['id_buku']; ?>][id_buku]"
                                               value="<?= $b['id_buku']; ?>">
                                    </td>

                                    <!-- JUDUL -->
                                    <td><?= $b['judul']; ?></td>

                                    <!-- JUMLAH -->
                                    <td>
                                        <input type="number"
                                               class="form-control qty-input"
                                               name="buku[<?= $b['id_buku']; ?>][jumlah]"
                                               value="1"
                                               min="1">
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    Tidak ada data buku
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>

            <!-- BUTTON -->
            <div class="mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Simpan
                </button>

                <a href="<?= base_url('peminjaman') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

        </form>

    </div>

</div>

<?= $this->endSection() ?>