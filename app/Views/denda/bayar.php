<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
:root {
    --dark: #0B2E59;
    --mid: #0F4C75;
    --primary: #1B7F9F;
}

/* CARD */
.pay-box {
    max-width: 500px;
    margin: 40px auto;
    padding: 25px;
    border-radius: 18px;
    background: rgba(255,255,255,0.88);
    backdrop-filter: blur(12px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

/* TITLE */
.pay-title {
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 20px;
    text-align: center;
}

/* TOTAL */
.total-box {
    text-align: center;
    margin-bottom: 20px;
}

.total-box b {
    font-size: 22px;
    color: red;
}

/* OPTION */
.option-box {
    padding: 12px;
    border-radius: 12px;
    border: 1px solid #eee;
    margin-bottom: 10px;
    transition: 0.2s;
}

.option-box:hover {
    background: #f8fafc;
}

/* BUTTON */
.btn-pay {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--dark), var(--mid));
    color: #fff;
    font-weight: 600;
    margin-top: 15px;
}

.btn-pay:hover {
    opacity: 0.9;
}
</style>

<div class="container">

    <div class="pay-box">

        <h4 class="pay-title">
            <i class="bi bi-cash-coin"></i> Bayar Denda
        </h4>

        <!-- TOTAL -->
        <div class="total-box">
            <small>Total Denda</small><br>
            <b>Rp <?= number_format($denda['jumlah_denda'],0,',','.') ?></b>
        </div>

        <!-- FORM -->
        <form id="formBayar" method="post" action="<?= base_url('denda/prosesCash') ?>">

            <input type="hidden" name="id_denda" value="<?= $denda['id_denda'] ?>">

            <label class="form-label">Pilih Metode Pembayaran</label>

            <div class="option-box">
                <input type="radio" name="metode" value="cash" required>
                <label class="ms-1">Cash</label>
            </div>

            <div class="option-box">
                <input type="radio" name="metode" value="qris">
                <label class="ms-1">QRIS / E-Wallet</label>
            </div>

            <button type="submit" class="btn-pay">
                Bayar Sekarang
            </button>

        </form>

    </div>

</div>

<script>
const form = document.getElementById('formBayar');

document.querySelectorAll('input[name="metode"]').forEach(function(radio){
    radio.addEventListener('change', function(){

        if (this.value === 'cash') {
            form.action = "<?= base_url('denda/prosesCash') ?>";
        }

        if (this.value === 'qris') {
            alert('Kamu akan diarahkan ke QRIS');
            window.location.href = "<?= base_url('denda/qris/'.$denda['id_denda']) ?>";
        }

    });
});
</script>

<?= $this->endSection() ?>