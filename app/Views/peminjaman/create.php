<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
/* WRAPPER */
.box {
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(12px);
    padding: 20px;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

/* SEARCH */
.search-box input {
    border-radius: 10px;
}

/* GRID BUKU */
.buku-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 15px;
}

/* CARD BUKU */
.buku-card {
    border-radius: 14px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: 0.25s;
}

.buku-card:hover {
    transform: translateY(-5px);
}

.buku-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

/* BODY */
.buku-body {
    padding: 10px;
}

.buku-body h6 {
    font-size: 14px;
    font-weight: 600;
}

/* STATUS */
.badge-stock {
    font-size: 11px;
}

/* CART */
.cart-box {
    background: #f8fafc;
    padding: 15px;
    border-radius: 12px;
}

/* BUTTON */
.btn-primary {
    border-radius: 10px;
}
</style>

<div class="container-fluid py-3">

    <h4 class="fw-bold mb-3">
        <i class="bi bi-journal-plus"></i> Tambah Peminjaman
    </h4>

    <form action="<?= base_url('peminjaman/store') ?>" method="post">
        <?= csrf_field() ?>

        <!-- SEARCH -->
        <div class="box mb-3 search-box">
            <label class="form-label fw-semibold">Cari Buku</label>
            <input type="text" id="search" class="form-control" placeholder="Cari judul buku...">
        </div>

        <!-- LIST BUKU -->
        <div class="box mb-3">
            <h6 class="fw-semibold mb-3">Pilih Buku</h6>

            <div class="buku-grid" id="listBuku">

                <?php foreach($buku as $b): ?>
                    <div class="buku-card item-buku">

                        <!-- COVER -->
                        <img src="<?= base_url('uploads/buku/'.$b['cover']) ?>">

                        <div class="buku-body">

                            <!-- JUDUL -->
                            <h6><?= $b['judul'] ?></h6>

                            <!-- STOK -->
                            <div class="mb-2">
                                <?php if ($b['tersedia'] > 0): ?>
                                    <span class="badge bg-success badge-stock">
                                        Stok: <?= $b['tersedia'] ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger badge-stock">
                                        Habis
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- ACTION -->
                            <div class="d-flex justify-content-between">

                                <a href="<?= base_url('buku/detail/'.$b['id_buku']) ?>"
                                   class="btn btn-sm btn-outline-primary">
                                    Detail
                                </a>

                                <?php if ($b['tersedia'] > 0): ?>
                                    <a href="<?= base_url('peminjaman/addCart/'.$b['id_buku']) ?>"
                                       class="btn btn-sm btn-success">
                                        Pinjam
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-secondary" disabled>
                                        Tidak tersedia
                                    </button>
                                <?php endif; ?>

                            </div>

                        </div>

                    </div>
                <?php endforeach ?>

            </div>
        </div>

        <!-- CART -->
        <div class="box mb-3">
            <h6 class="fw-semibold mb-2">Buku Dipilih</h6>

            <div class="cart-box">

                <?php if (!empty($cart)): ?>
                    <?php foreach($cart as $b): ?>
                        <div class="d-flex justify-content-between align-items-center mb-2">

                            <div>
                                <?= $b['judul'] ?>
                                <span class="badge bg-primary">
                                    <?= $b['qty'] ?>
                                </span>
                            </div>

                            <a href="<?= base_url('peminjaman/removeCart/'.$b['id_buku']) ?>"
                               class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </a>

                        </div>
                    <?php endforeach ?>
                <?php else: ?>
                    <small class="text-muted">Belum ada buku dipilih</small>
                <?php endif; ?>

            </div>

        </div>

        <!-- STATUS -->
        <div class="box mb-3">
            <b>Status:</b>
            <span class="text-warning">
                Menunggu persetujuan petugas
            </span>
        </div>

        <!-- SUBMIT -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-save"></i> Simpan Peminjaman
            </button>
        </div>

    </form>

</div>

<!-- SEARCH SCRIPT -->
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