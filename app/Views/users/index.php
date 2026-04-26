<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
/* WRAPPER */
.users-box {
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(12px);
    padding: 20px;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

/* HEADER */
.users-header {
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

.filter-box input,
.filter-box select {
    border-radius: 10px;
}

/* TABLE */
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

/* FOTO */
.user-img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 10px;
}

/* ACTION */
.action-btn a {
    margin-right: 5px;
    font-size: 13px;
}
</style>

<div class="container-fluid py-3">

    <div class="users-box">

        <!-- HEADER -->
        <div class="users-header">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-people"></i> Data Users
            </h5>

            <div>
                <a href="<?= base_url('users/create') ?>" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus"></i> Tambah
                </a>
            </div>
        </div>

        <!-- FILTER -->
        <form method="get" class="filter-box mb-3">
            <input type="text" name="keyword" class="form-control form-control-sm"
                placeholder="Cari nama..."
                value="<?= $_GET['keyword'] ?? '' ?>">

            <select name="role" class="form-select form-select-sm">
                <option value="">Semua Role</option>
                <option value="admin" <?= (($_GET['role'] ?? '') == 'admin') ? 'selected' : '' ?>>Admin</option>
                <option value="petugas" <?= (($_GET['role'] ?? '') == 'petugas') ? 'selected' : '' ?>>Petugas</option>
                <option value="anggota" <?= (($_GET['role'] ?? '') == 'anggota') ? 'selected' : '' ?>>Anggota</option>
            </select>

            <button class="btn btn-primary btn-sm">
                <i class="bi bi-search"></i>
            </button>

            <a href="<?= base_url('users') ?>" class="btn btn-secondary btn-sm">
                Reset
            </a>

            <a href="<?= base_url('users/print?' . http_build_query($_GET)) ?>"
               target="_blank"
               class="btn btn-success btn-sm">
                <i class="bi bi-printer"></i>
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
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Foto</th>

                        <?php if (session()->get('role') == 'admin') : ?>
                            <th class="text-center">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php $no = 1 + (10 * ($pager->getCurrentPage() - 1)); ?>

                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $u['nama'] ?></td>
                                <td><?= $u['email'] ?></td>
                                <td><?= $u['username'] ?></td>

                                <td>
                                    <span class="badge bg-primary">
                                        <?= ucfirst($u['role']) ?>
                                    </span>
                                </td>

                                <td>
                                    <?php if ($u['foto']): ?>
                                        <img src="<?= base_url('uploads/users/' . $u['foto']) ?>" class="user-img">
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>

                                <?php if (session()->get('role') == 'admin') : ?>
                                    <td class="action-btn text-center">

                                        <a href="<?= base_url('users/detail/' . $u['id']) ?>"
                                           class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="<?= base_url('users/edit/' . $u['id']) ?>"
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <a href="<?= base_url('users/wa/' . $u['id']) ?>"
                                           target="_blank"
                                           class="btn btn-success btn-sm">
                                            <i class="bi bi-whatsapp"></i>
                                        </a>

                                        <a href="<?= base_url('users/delete/' . $u['id']) ?>"
                                           onclick="return confirm('Hapus user ini?')"
                                           class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </a>

                                    </td>
                                <?php endif; ?>

                            </tr>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Belum ada data user
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