<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Tambah Peminjaman</h2>

<form action="<?= base_url('peminjaman/store') ?>" method="post">
<?= csrf_field() ?>

<hr>

<!-- 🔥 PENCARIAN TANPA FORM -->
<label>Cari Buku</label><br>
<input type="text" id="search" placeholder="Cari judul...">

<hr>

<h4>Pilih Buku</h4>

<div style="display:flex;gap:10px;flex-wrap:wrap" id="listBuku">
<?php foreach($buku as $b): ?>
<div class="item-buku" style="border:1px solid #ccc;padding:10px;width:180px">

    <img src="<?= base_url('uploads/buku/'.$b['cover']) ?>" width="100%">

    <p><b><?= $b['judul'] ?></b></p>

    <p>
        Stok:
        <?php if ($b['tersedia'] > 0): ?>
            <?= $b['tersedia'] ?>
        <?php else: ?>
            <span style="color:red"><b>Habis</b></span>
        <?php endif; ?>
    </p>

    <a href="<?= base_url('buku/detail/'.$b['id_buku']) ?>">Detail</a>

    <?php if ($b['tersedia'] > 0): ?>
        | <a href="<?= base_url('peminjaman/addCart/'.$b['id_buku']) ?>">
            Pinjam
          </a>
    <?php else: ?>
        | <span style="color:gray">Tidak tersedia</span>
    <?php endif; ?>

</div>
<?php endforeach ?>
</div>

<hr>

<h3>Buku Yang Dipilih</h3>

<?php foreach($cart as $b): ?>
    <p><?= $b['judul'] ?> (<?= $b['qty'] ?>)</p>
    <a href="<?= base_url('peminjaman/removeCart/'.$b['id_buku']) ?>">Hapus</a>
<?php endforeach ?>

<br>
<hr>
<label>Petugas</label>
<select name="id_petugas" required>
    <option value="">-- pilih petugas --</option>
    <?php foreach($petugas as $p): ?>
        <option value="<?= $p['id'] ?>">
            <?= $p['nama'] ?>
        </option>
    <?php endforeach ?>
</select>
<br>
<hr>
<button type="submit">Simpan Peminjaman</button>

</form>

<!-- 🔥 SEARCH JAVASCRIPT -->
<script>
document.getElementById('search').addEventListener('keyup', function(){
    let keyword = this.value.toLowerCase();
    let items = document.querySelectorAll('.item-buku');

    items.forEach(item => {
        let text = item.innerText.toLowerCase();
        item.style.display = text.includes(keyword) ? 'block' : 'none';
    });
});
</script>

<?= $this->endSection() ?>