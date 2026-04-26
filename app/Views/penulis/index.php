<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
.table-box {
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(12px);
    padding: 20px;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.table-custom {
    width: 100%;
    border-radius: 12px;
    overflow: hidden;
}

.table-custom thead {
    background: #0B2E59;
    color: #fff;
}

.table-custom th,
.table-custom td {
    padding: 10px;
    text-align: center;
    border-bottom: 1px solid #eee;
}

.table-custom tbody tr:hover {
    background: #f8fafc;
}
</style>

<div class="container-fluid py-3">

    <div class="table-box">

        <!-- HEADER -->
        <div class="table-header">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-person-lines-fill"></i> Data Penulis
            </h5>

            <a href="<?= base_url('penulis/create') ?>" class="btn btn-primary btn-sm">
                + Tambah
            </a>
        </div>

        <!-- SEARCH -->
        <form method="get" class="mb-3 d-flex gap-2 flex-wrap">

            <input type="text"
                   name="keyword"
                   class="form-control form-control-sm"
                   style="max-width:300px"
                   placeholder="Cari penulis..."
                   value="<?= esc($_GET['keyword'] ?? '') ?>">

            <button class="btn btn-primary btn-sm">
                <i class="bi bi-search"></i>
            </button>

            <a href="<?= base_url('penulis') ?>" class="btn btn-secondary btn-sm">
                Reset
            </a>

        </form>

        <!-- FLASH -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-hover align-middle table-custom">

                <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Penulis</th>
                    <th>Aksi</th>
                </tr>
                </thead>

                <tbody>

                <?php if (!empty($penulis)): ?>
                    <?php $no = 1 + (10 * ($pager->getCurrentPage() - 1)); ?>

                    <?php foreach ($penulis as $p): ?>
                        <tr>

                            <td><?= $no++ ?></td>

                            <td class="fw-semibold">
                                <?= esc($p['nama_penulis']) ?>
                            </td>

                            <td class="d-flex justify-content-center gap-2">

                                <a href="<?= base_url('penulis/edit/' . $p['id_penulis']) ?>"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <a href="<?= base_url('penulis/delete/' . $p['id_penulis']) ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Hapus data?')">
                                    Hapus
                                </a>

                            </td>

                        </tr>
                    <?php endforeach; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">
                            Belum ada data penulis
                        </td>
                    </tr>
                <?php endif; ?>

                </tbody>

            </table>
        </div>

        <!-- PAGINATION -->
        <div class="mt-3">
            <?= $pager->links() ?>
        </div>

    </div>

</div>

<?= $this->endSection() ?>