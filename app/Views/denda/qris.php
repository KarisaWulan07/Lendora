<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- TITLE -->
    <div class="text-center mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-cash-coin me-2"></i> Pembayaran Denda
        </h3>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm border-0 mx-auto" style="max-width: 450px;">
        <div class="card-body text-center">

            <h5 class="text-muted">Total Bayar</h5>

            <h2 class="text-danger fw-bold">
                Rp <?= number_format($denda['jumlah_denda'], 0, ',', '.') ?>
            </h2>

            <p class="mb-1">
                <small>ID Peminjaman: <?= $denda['id_peminjaman'] ?></small>
            </p>

            <hr>

            <p class="fw-semibold mb-2">
                Scan QRIS / E-Wallet
            </p>

            <!-- QR -->
            <div id="qrcode" class="d-flex justify-content-center my-3"></div>

            <small class="text-muted d-block mb-3">
                Scan menggunakan DANA / OVO / GoPay / Mobile Banking
            </small>

            <hr>

            <!-- FORM -->
            <h5 class="mb-3">Upload Bukti Pembayaran</h5>

            <form action="<?= base_url('denda/konfirmasiBayar') ?>"
                  method="post"
                  enctype="multipart/form-data">

                <input type="hidden" name="id_denda" value="<?= $denda['id_denda'] ?>">
                <input type="hidden" name="metode" value="QRIS">

                <input type="file"
                       name="bukti"
                       accept="image/*"
                       class="form-control mb-3"
                       required>

                <!-- PREVIEW -->
                <img id="preview"
                     class="img-thumbnail mb-3"
                     style="display:none; max-width: 220px;">

                <button type="submit" class="btn btn-success w-100">
                    ✔ Saya Sudah Bayar
                </button>

            </form>

            <a href="<?= base_url('denda') ?>" class="btn btn-outline-secondary w-100 mt-2">
                ← Kembali
            </a>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger mt-3 py-2">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

        </div>
    </div>

</div>

<!-- QR CODE -->
<script src="https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js"></script>

<script>
const qrText = "Denda ID: <?= $denda['id_denda'] ?> | Total: <?= $denda['jumlah_denda'] ?>";

new QRCode(document.getElementById("qrcode"), {
    text: qrText,
    width: 180,
    height: 180
});
</script>

<!-- PREVIEW IMAGE -->
<script>
const input = document.querySelector('input[name="bukti"]');
const preview = document.getElementById('preview');

input.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
});
</script>

<?= $this->endSection() ?>