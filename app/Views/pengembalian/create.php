<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
.box {
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(12px);
    padding: 20px;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.label {
    font-size: 13px;
    color: #666;
}

.form-control, .form-select {
    border-radius: 10px;
}
</style>

<div class="container-fluid py-3">

    <!-- TITLE -->
    <h4 class="fw-bold mb-3">
        <i class="bi bi-arrow-return-left"></i> Pengembalian Buku
    </h4>

    <!-- ERROR -->
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- FORM BOX -->
    <div class="box">

        <form action="<?= base_url('pengembalian/store') ?>" method="post">

            <!-- PILIH PEMINJAMAN -->
            <div class="mb-3">
                <label class="label">Peminjaman</label>

                <select name="id_peminjaman" class="form-select" required>
                    <option value="">-- Pilih Peminjaman --</option>

                    <?php foreach ($peminjaman as $p) : ?>
                        <option value="<?= $p['id_peminjaman'] ?>">
                            ID <?= $p['id_peminjaman'] ?> - <?= $p['tanggal_pinjam'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- TANGGAL -->
            <div class="mb-3">
                <label class="label">Tanggal Kembali</label>

                <input type="date"
                       name="tanggal_dikembalikan"
                       class="form-control"
                       value="<?= date('Y-m-d') ?>"
                       readonly>
            </div>

            <!-- KONDISI BUKU -->
            <div class="mb-3">
                <label class="label">Kondisi Buku</label>

                <select name="kondisi_buku" class="form-select" required>
                    <option value="normal">Normal</option>
                    <option value="rusak">Rusak</option>
                    <option value="hilang">Hilang</option>
                </select>

                <small class="text-muted">
                    *Pilih kondisi buku saat dikembalikan
                </small>
            </div>

            <!-- DENDA -->
            <div class="mb-3">
                <label class="label">Denda</label>

                <input type="number"
                       class="form-control"
                       value="0"
                       readonly>

                <small class="text-muted">
                    *Denda keterlambatan Rp1.000 / hari
                    <br>
                    *Rusak +Rp50.000
                    <br>
                    *Hilang +Rp100.000
                </small>
            </div>

            <!-- METODE PEMBAYARAN -->
            <div class="mb-3">
                <label class="label">Metode Pembayaran</label>

                <select name="metode_pembayaran" class="form-select">
                    <option value="">-- Bayar nanti --</option>
                    <option value="cash">Cash</option>
                    <option value="qris">QRIS / DANA</option>
                </select>
            </div>

            <!-- BUTTON -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Simpan
                </button>

                <a href="<?= base_url('peminjaman') ?>" class="btn btn-secondary">
                    Kembali
                </a>
            </div>

        </form>

    </div>

</div>

<?= $this->endSection() ?>