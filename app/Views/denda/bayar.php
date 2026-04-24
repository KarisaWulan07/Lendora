<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Bayar Denda</h2>

<p>
    Total Denda: 
    <b>Rp <?= number_format($denda['jumlah_denda'],0,',','.') ?></b>
</p>

<form id="formBayar" method="post" action="<?= base_url('denda/prosesCash') ?>">

    <input type="hidden" name="id_denda" value="<?= $denda['id_denda'] ?>">

    <label>Metode:</label><br>

    <input type="radio" name="metode" value="cash" required> 💵 Cash <br>
    <input type="radio" name="metode" value="qris"> 📱 QRIS <br>

    <br><br>

    <button type="submit">Bayar</button>
</form>

<script>
const form = document.getElementById('formBayar');

document.querySelectorAll('input[name="metode"]').forEach(function(radio){
    radio.addEventListener('change', function(){

        if (this.value === 'cash') {
            // tetap submit ke prosesCash
            form.action = "<?= base_url('denda/prosesCash') ?>";
        }

        if (this.value === 'qris') {
            alert('Kamu akan diarahkan ke halaman QRIS');

            // redirect ke QRIS
            window.location.href = "<?= base_url('denda/qris/'.$denda['id_denda']) ?>";
        }

    });
});
</script>

<?= $this->endSection() ?>