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

.filter-box {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.filter-box input,
.filter-box select {
    border-radius: 10px;
}

.table-custom {
    border-radius: 12px;
    overflow: hidden;
}

.table-custom thead {
    background: #0B2E59;
    color: #fff;
}

.table-custom tbody tr:hover {
    background: #f8fafc;
}

.cover-img {
    width: 45px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
}

.action-btn a {
    margin-right: 5px;
}
</style>

<div class="container-fluid py-3">

    <div class="table-box">

        <!-- HEADER -->
        <div class="table-header">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-book"></i> Data Buku
            </h5>

            <div class="d-flex gap-2">

                <?php if (in_array(session()->get('role'), ['admin','petugas'])): ?>
                    <a href="<?= base_url('buku/create') ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus"></i> Tambah
                    </a>
                <?php endif; ?>

            </div>
        </div>

        <!-- FILTER (TIDAK DIUBAH) -->
        <form method="get" class="filter-box mb-3">

            <input type="text" name="keyword" class="form-control form-control-sm"
                   placeholder="Cari judul..."
                   value="<?= $_GET['keyword'] ?? '' ?>">

            <select name="kategori" class="form-select form-select-sm">
                <option value="">Semua Kategori</option>
                <?php foreach ($kategori as $k): ?>
                    <option value="<?= $k['id_kategori'] ?>"
                        <?= (($_GET['kategori'] ?? '') == $k['id_kategori']) ? 'selected' : '' ?>>
                        <?= $k['nama_kategori'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button class="btn btn-primary btn-sm">
                <i class="bi bi-search"></i>
            </button>

            <a href="<?= base_url('buku') ?>" class="btn btn-secondary btn-sm">
                Reset
            </a>
            <!-- ✅ PRINT SEMUA BUKU (SUDAH DIPINDAH KE ATAS) -->
                <a href="<?= base_url('buku/print') ?>" target="_blank" class="btn btn-secondary btn-sm">
                    <i class="bi bi-printer"></i> Print
                </a>

        </form>

        <!-- ALERT -->
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
                        <th>Cover</th>
                        <th>Judul</th>
                        <th>ISBN</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Rak</th>
                        <th>Tahun</th>
                        <th>Jumlah</th>
                        <th>Tersedia</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($buku)): ?>
                        <?php $no = 1 + (10 * ($pager->getCurrentPage() - 1)); ?>

                        <?php foreach ($buku as $b): ?>
                            <tr>

                                <td><?= $no++ ?></td>

                                <td>
                                    <?php if ($b['cover']): ?>
                                        <img src="<?= base_url('uploads/buku/' . $b['cover']) ?>" class="cover-img">
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>

                                <td><?= $b['judul'] ?></td>
                                <td><?= $b['isbn'] ?: '-' ?></td>

                                <td><?= $b['nama_kategori'] ?? '-' ?></td>
                                <td><?= $b['nama_penulis'] ?? '-' ?></td>
                                <td><?= $b['nama_penerbit'] ?? '-' ?></td>
                                <td><?= $b['nama_rak'] ?? '-' ?></td>

                                <td><?= $b['tahun_terbit'] ?></td>
                                <td><?= $b['jumlah'] ?></td>

                                <td>
                                    <span class="badge <?= $b['tersedia'] > 0 ? 'bg-success' : 'bg-danger' ?>">
                                        <?= $b['tersedia'] ?>
                                    </span>
                                </td>

                                <td class="text-center action-btn">

                                    <a href="<?= base_url('buku/detail/' . $b['id_buku']) ?>"
                                       class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <?php if (in_array(session()->get('role'), ['admin','petugas'])): ?>
                                        <a href="<?= base_url('buku/edit/' . $b['id_buku']) ?>"
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    <?php endif; ?>

                                    <a href="<?= base_url('buku/wa/' . $b['id_buku']) ?>"
                                       target="_blank"
                                       class="btn btn-success btn-sm">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>

                                    <!-- ❌ PRINT PER BUKU DIHAPUS -->

                                    <?php if (session()->get('role') == 'admin'): ?>
                                        <a href="<?= base_url('buku/delete/' . $b['id_buku']) ?>"
                                           onclick="return confirm('Hapus buku ini?')"
                                           class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    <?php endif; ?>

                                </td>

                            </tr>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <tr>
                            <td colspan="12" class="text-center text-muted">
                                Belum ada data buku
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