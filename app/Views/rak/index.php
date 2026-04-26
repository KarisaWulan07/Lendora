<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
/* WRAPPER */
.table-box {
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(12px);
    padding: 20px;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

/* HEADER */
.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

/* FILTER */
.filter-box {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.filter-box input {
    border-radius: 10px;
}

/* TABLE */
.table-custom thead {
    background: #0B2E59;
    color: #fff;
}

.table-custom tbody tr:hover {
    background: #f8fafc;
}

/* ACTION */
.action-btn a {
    margin-right: 5px;
}
</style>

<div class="container-fluid py-3">

    <div class="table-box">

        <!-- HEADER -->
        <div class="table-header">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-archive"></i> Data Rak
            </h5>

            <a href="<?= base_url('rak/create') ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-plus"></i> Tambah
            </a>
        </div>

        <!-- FILTER -->
        <form method="get" class="filter-box mb-3">
            <input type="text" name="keyword" class="form-control form-control-sm"
                   placeholder="Cari rak / lokasi..."
                   value="<?= $_GET['keyword'] ?? '' ?>">

            <button class="btn btn-primary btn-sm">
                <i class="bi bi-search"></i>
            </button>

            <a href="<?= base_url('rak') ?>" class="btn btn-secondary btn-sm">
                Reset
            </a>
        </form>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-hover align-middle table-custom">

                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Rak</th>
                        <th>Lokasi</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($rak)): ?>
                        <?php $no = 1; foreach ($rak as $r): ?>
                            <tr>

                                <td><?= $no++ ?></td>
                                <td><?= $r['nama_rak'] ?></td>
                                <td><?= $r['lokasi'] ?></td>

                                <td class="text-center action-btn">

                                    <a href="<?= base_url('rak/edit/' . $r['id_rak']) ?>"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <a href="<?= base_url('rak/delete/' . $r['id_rak']) ?>"
                                       onclick="return confirm('Hapus rak ini?')"
                                       class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </a>

                                </td>

                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Belum ada data rak
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>

    </div>

</div>

<?= $this->endSection() ?>