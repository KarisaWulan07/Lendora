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
</style>

<div class="container-fluid py-3">

    <div class="table-box">

        <!-- HEADER -->
        <div class="table-header">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-cash-stack"></i> Data Denda
            </h5>
        </div>

        <!-- SEARCH -->
        <form method="get" class="mb-3 d-flex gap-2 flex-wrap">

            <input type="text"
                   name="search"
                   class="form-control form-control-sm"
                   style="max-width:300px"
                   placeholder="Cari nama / ID..."
                   value="<?= esc($search ?? '') ?>">

            <button class="btn btn-primary btn-sm">
                <i class="bi bi-search"></i>
            </button>

            <a href="<?= base_url('denda') ?>" class="btn btn-secondary btn-sm">
                Reset
            </a>

        </form>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-hover align-middle table-custom">

                <thead>
                <tr>
                    <th>ID</th>
                    <th>Peminjaman</th>
                    <th>Nama</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Metode</th>
                    <th>Bukti</th>
                    <th>Petugas</th>
                    <th>Aksi</th>
                </tr>
                </thead>

                <tbody>

                <?php if (!empty($denda)) : ?>
                    <?php foreach ($denda as $d): ?>

                        <?php
                        $status = $d['status_denda'] ?? 'belum';
                        $role = session()->get('role');
                        ?>

                        <tr>
                            <td><?= $d['id_denda'] ?></td>
                            <td><?= $d['id_peminjaman'] ?? '-' ?></td>
                            <td><?= $d['nama_anggota'] ?? '-' ?></td>

                            <td>
                                <?php if (!empty($d['jumlah_denda'])): ?>
                                    <span class="fw-semibold text-danger">
                                        Rp <?= number_format($d['jumlah_denda'], 0, ',', '.') ?>
                                    </span>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ($status == 'belum'): ?>
                                    <span class="badge bg-danger">Belum Bayar</span>
                                <?php elseif ($status == 'menunggu'): ?>
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                <?php elseif ($status == 'lunas'): ?>
                                    <span class="badge bg-success">Lunas</span>
                                <?php elseif ($status == 'ditolak'): ?>
                                    <span class="badge bg-danger">Ditolak</span>
                                <?php endif; ?>
                            </td>

                            <td><?= $d['metode_pembayaran'] ?? '-' ?></td>

                            <td>
                                <?php if (!empty($d['bukti_pembayaran'])): ?>
                                    <a href="<?= base_url('uploads/bukti/' . $d['bukti_pembayaran']) ?>"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary">
                                        Lihat
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>

                            <td><?= $d['nama_petugas'] ?? '-' ?></td>

                            <td class="d-flex flex-wrap gap-1">

                                <?php if ($status == 'belum'): ?>
                                    <?php if ($role == 'anggota'): ?>
                                        <a href="<?= base_url('denda/bayar/'.$d['id_denda']) ?>"
                                           class="btn btn-sm btn-success">
                                            Bayar
                                        </a>
                                    <?php endif; ?>

                                <?php elseif ($status == 'menunggu'): ?>
                                    <?php if (in_array($role, ['admin','petugas'])): ?>
                                        <a href="<?= base_url('denda/verifikasi/'.$d['id_denda']) ?>"
                                           class="btn btn-sm btn-success">
                                            ✔ Verifikasi
                                        </a>

                                        <a href="<?= base_url('denda/tolak/'.$d['id_denda']) ?>"
                                           class="btn btn-sm btn-danger">
                                            ✖ Tolak
                                        </a>
                                    <?php endif; ?>

                                <?php elseif ($status == 'ditolak'): ?>
                                    <?php if ($role == 'anggota'): ?>
                                        <a href="<?= base_url('denda/bayar/'.$d['id_denda']) ?>"
                                           class="btn btn-sm btn-warning">
                                            Bayar Ulang
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            Tidak ada data denda
                        </td>
                    </tr>
                <?php endif; ?>

                </tbody>

            </table>
        </div>

    </div>

</div>

<?= $this->endSection() ?>