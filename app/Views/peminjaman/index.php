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

.table-custom tbody tr:hover {
    background: #f8fafc;
}

/* TELAT */
.row-telat {
    background-color: #ffe6e6 !important;
}
</style>

<div class="container-fluid py-3">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-journal"></i> Data Peminjaman
        </h4>

        <?php if (session()->get('role') == 'anggota') : ?>
            <a href="<?= base_url('peminjaman/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus"></i> Tambah
            </a>
        <?php endif; ?>
    </div>

    <!-- ALERT -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- FILTER -->
    <div class="box mb-3">
        <form method="get" class="row g-2">

            <div class="col-md-4">
                <input type="text" name="keyword"
                       class="form-control"
                       placeholder="Cari peminjaman..."
                       value="<?= esc($keyword ?? '') ?>">
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>

        </form>
    </div>

    <!-- TABLE -->
    <div class="box">

        <div class="table-responsive">
            <table class="table table-hover align-middle table-custom">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>No</th>
                        <th>Anggota</th>
                        <th>Petugas</th>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th>Status Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (!empty($peminjaman)) : ?>
                <?php $no = 1; ?>

                <?php foreach ($peminjaman as $row) : ?>

                <?php
                $today = date('Y-m-d');
                $isTelat = false;
                $denda = 0;

                if (
                    ($row['status'] ?? '') == 'dipinjam' &&
                    !empty($row['tanggal_kembali']) &&
                    $today > $row['tanggal_kembali']
                ) {
                    $isTelat = true;

                    $selisih = (strtotime($today) - strtotime($row['tanggal_kembali'])) / 86400;
                    $denda = $selisih * 1000;
                }
                ?>

                <tr class="<?= $isTelat ? 'row-telat' : '' ?>">

                    <td><?= $row['id_peminjaman'] ?? '-' ?></td>
                    <td><?= $no++ ?></td>
                    <td><?= $row['nama_anggota'] ?? '-' ?></td>
                    <td><?= $row['nama_petugas'] ?? '-' ?></td>
                    <td><?= $row['buku'] ?? '-' ?></td>
                    <td><?= $row['tanggal_pinjam'] ?? '-' ?></td>
                    <td><?= $row['tanggal_kembali'] ?? '-' ?></td>

                    <!-- STATUS -->
                    <td>
                        <?php if (($row['status'] ?? '') == 'menunggu'): ?>
                            <span class="badge bg-warning text-dark">Menunggu</span>

                        <?php elseif (($row['status'] ?? '') == 'dipinjam' && $isTelat): ?>
                            <span class="badge bg-danger">TELAT</span>

                        <?php elseif (($row['status'] ?? '') == 'dipinjam'): ?>
                            <span class="badge bg-primary">Dipinjam</span>

                        <?php else: ?>
                            <span class="badge bg-success">Dikembalikan</span>
                        <?php endif; ?>
                    </td>

                    <!-- DENDA -->
                    <td>
                        <?php if ($denda > 0): ?>
                            <span class="text-danger fw-semibold">
                                Rp <?= number_format($denda, 0, ',', '.') ?>
                            </span>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>

                    <!-- STATUS DENDA -->
                    <td>
                        <?php if (($row['status_denda'] ?? '') == 'belum') : ?>
                            <span class="badge bg-danger">Belum</span>

                        <?php elseif (($row['status_denda'] ?? '') == 'menunggu') : ?>
                            <span class="badge bg-warning text-dark">Menunggu</span>

                        <?php elseif (($row['status_denda'] ?? '') == 'lunas') : ?>
                            <span class="badge bg-success">Lunas</span>

                        <?php else : ?>
                            -
                        <?php endif; ?>
                    </td>

                    <!-- AKSI -->
                    <td>

                        <?php if (
                            in_array(session()->get('role'), ['admin','petugas']) &&
                            ($row['status'] ?? '') == 'menunggu'
                        ): ?>
                            <a href="<?= base_url('peminjaman/setujui/'.$row['id_peminjaman']) ?>"
                               class="btn btn-sm btn-success mb-1">
                               ✔
                            </a>
                        <?php endif; ?>

                        <a href="<?= base_url('peminjaman/detail/'.$row['id_peminjaman']) ?>"
                           class="btn btn-sm btn-info mb-1">
                           Detail
                        </a>

                        <?php if (in_array(session()->get('role'), ['admin','petugas'])) : ?>
                            <a href="<?= base_url('peminjaman/perpanjang/'.$row['id_peminjaman']) ?>"
                               class="btn btn-sm btn-warning mb-1">
                               Perpanjang
                            </a>
                        <?php endif; ?>

                        <a href="<?= base_url('peminjaman/print/'.$row['id_peminjaman']) ?>"
                           target="_blank"
                           class="btn btn-sm btn-secondary mb-1">
                           Print
                        </a>

                        <?php if (in_array(session()->get('role'), ['admin','petugas'])) : ?>
                            <a href="<?= base_url('peminjaman/delete/'.$row['id_peminjaman']) ?>"
                               onclick="return confirm('Yakin hapus?')"
                               class="btn btn-sm btn-danger mb-1">
                               Hapus
                            </a>
                        <?php endif; ?>

                        <a href="<?= base_url('peminjaman/wa/'.$row['id_peminjaman']) ?>"
                           target="_blank"
                           class="btn btn-sm btn-success mb-1">
                           WA
                        </a>

                    </td>

                </tr>

                <?php endforeach; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="11" class="text-center text-muted">
                            Tidak ada data peminjaman
                        </td>
                    </tr>
                <?php endif; ?>

                </tbody>
            </table>
        </div>

    </div>

</div>

<?= $this->endSection() ?>