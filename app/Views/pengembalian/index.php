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

/* BADGE */
.badge-red { color: #dc3545; font-weight: 600; }
.badge-orange { color: #fd7e14; font-weight: 600; }
.badge-green { color: #198754; font-weight: 600; }

/* BUTTON */
.btn-action a {
    text-decoration: none;
    margin: 0 3px;
    font-size: 13px;
}

.btn-edit { color: #0d6efd; }
.btn-delete { color: #dc3545; }
.btn-delete:hover { text-decoration: underline; }
</style>

<div class="container-fluid py-3">

    <div class="table-box">

        <!-- HEADER -->
        <div class="table-header">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-arrow-left-right"></i> Data Pengembalian
            </h5>

            <a href="<?= base_url('pengembalian/create') ?>" class="btn btn-primary btn-sm">
                + Tambah
            </a>
        </div>

        <!-- SEARCH -->
        <form method="get" class="mb-3">
            <div class="input-group input-group-sm" style="max-width:350px;">
                <input type="text" name="search" class="form-control"
                       placeholder="Cari data..."
                       value="<?= esc($_GET['search'] ?? '') ?>">
                <button class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-hover align-middle table-custom">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Anggota</th>
                        <th>Tanggal</th>
                        <th>Denda</th>
                        <th>Status Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (!empty($pengembalian)) : ?>
                    <?php foreach($pengembalian as $p): ?>

                    <tr>
                        <td><?= $p['id_pengembalian'] ?></td>
                        <td><?= $p['nama_anggota'] ?? '-' ?></td>
                        <td><?= $p['tanggal_dikembalikan'] ?></td>

                        <!-- DENDA -->
                        <td>
                            <?php if (($p['jumlah_denda'] ?? 0) > 0): ?>
                                <span class="badge-red">
                                    Rp <?= number_format($p['jumlah_denda'], 0, ',', '.') ?>
                                </span>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>

                        <!-- STATUS -->
                        <td>
                            <?php if (($p['jumlah_denda'] ?? 0) > 0): ?>

                                <?php if (($p['status_denda'] ?? '') == 'belum'): ?>
                                    <span class="badge-red">Belum Bayar</span>

                                <?php elseif (($p['status_denda'] ?? '') == 'menunggu'): ?>
                                    <span class="badge-orange">Menunggu</span>

                                <?php elseif (($p['status_denda'] ?? '') == 'lunas'): ?>
                                    <span class="badge-green">Lunas</span>

                                <?php elseif (($p['status_denda'] ?? '') == 'ditolak'): ?>
                                    <span class="badge-red">Ditolak</span>

                                <?php else: ?>
                                    -
                                <?php endif; ?>

                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>

                        <!-- AKSI -->
                        <td class="btn-action">

                            <a class="btn-edit"
                               href="<?= base_url('pengembalian/edit/'.$p['id_pengembalian']) ?>">
                               Edit
                            </a>

                            |
                            <a class="btn-delete"
                               onclick="return confirm('Yakin hapus?')"
                               href="<?= base_url('pengembalian/delete/'.$p['id_pengembalian']) ?>">
                               Hapus
                            </a>

                        </td>

                    </tr>

                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Tidak ada data
                        </td>
                    </tr>
                <?php endif; ?>

                </tbody>

            </table>
        </div>

    </div>

</div>

<?= $this->endSection() ?>