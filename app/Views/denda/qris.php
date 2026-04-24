<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>PEMBAYARAN DENDA</h2>

<div style="max-width:400px;margin:auto;text-align:center;border:2px solid #333;padding:20px;border-radius:10px;">

    <h3>Total Bayar</h3>
    <h1 style="color:red;">
        Rp <?= number_format($denda['jumlah_denda'],0,',','.') ?>
    </h1>

    <p>ID Peminjaman: <?= $denda['id_peminjaman'] ?></p>

    <hr>

    <p><b>Scan QRIS / DANA / OVO / GOPAY</b></p>

    <!-- QRIS IMAGE -->
    <img src="<?= base_url('lendora/uploads/qris/qris.1') ?>" 
         width="250" 
         style="margin:10px 0;">

    <!-- FORM UPLOAD BUKTI -->
    <form action="<?= base_url('denda/konfirmasiBayar') ?>" 
          method="post" 
          enctype="multipart/form-data">

        <input type="hidden" name="id_denda" value="<?= $denda['id_denda'] ?>">
        <input type="hidden" name="metode" value="QRIS">

        <p><b>Upload Bukti Pembayaran</b></p>

        <input type="file" name="bukti" accept="image/*" required>

        <br><br>

        <!-- PREVIEW GAMBAR -->
        <img id="preview" width="200" style="display:none;border:1px solid #ccc;margin-bottom:10px;">

        <br>

        <button type="submit" style="padding:10px 20px;background:green;color:white;border:none;border-radius:5px;">
            ✔ Saya Sudah Bayar
        </button>
<?php if(session()->getFlashdata('error')): ?>
    <p style="color:red;">
        <?= session()->getFlashdata('error') ?>
    </p>
<?php endif; ?>
    </form>

</div>

<!-- SCRIPT PREVIEW GAMBAR -->
<script>
const input = document.querySelector('input[name="bukti"]');
const preview = document.getElementById('preview');

input.addEventListener('change', function(){
    const file = this.files[0];
    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
});
</script>

<?= $this->endSection() ?>