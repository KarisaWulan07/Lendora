<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
/* WRAPPER */
.form-box {
    max-width: 750px;
    margin: 20px auto;
    padding: 25px;
    border-radius: 18px;
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(12px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

/* TITLE */
.form-title {
    font-weight: 600;
    color: #0B2E59;
    margin-bottom: 15px;
}

/* INPUT */
.form-control,
.form-select,
textarea {
    border-radius: 10px;
}

/* COVER */
.cover-preview {
    width: 90px;
    height: 120px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 10px;
}

/* BUTTON */
.btn-primary {
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, #0B2E59, #1B7F9F);
}

.btn-primary:hover {
    opacity: 0.9;
}
</style>

<div class="container-fluid py-3">

    <div class="form-box">

        <!-- TITLE -->
        <h5 class="form-title">
            <i class="bi bi-pencil-square"></i> Edit Buku
        </h5>

        <!-- FORM -->
        <form action="<?= base_url('buku/update/' . $buku['id_buku']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <!-- JUDUL -->
            <div class="mb-3">
                <label class="form-label">Judul Buku</label>
                <input type="text" name="judul" class="form-control"
                       value="<?= old('judul', $buku['judul']) ?>" required>
            </div>

            <!-- ISBN -->
            <div class="mb-3">
                <label class="form-label">ISBN</label>
                <input type="text" name="isbn" class="form-control"
                       value="<?= old('isbn', $buku['isbn']) ?>">
            </div>

            <!-- KATEGORI -->
            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="id_kategori" class="form-select">
                    <option value="">-- Pilih --</option>
                    <?php foreach ($kategori as $k): ?>
                        <option value="<?= $k['id_kategori'] ?>"
                            <?= ($buku['id_kategori'] == $k['id_kategori']) ? 'selected' : '' ?>>
                            <?= $k['nama_kategori'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="text" name="kategori_baru" class="form-control mt-2"
                       placeholder="Atau tambah kategori baru">
            </div>

            <!-- PENULIS -->
            <div class="mb-3">
                <label class="form-label">Penulis</label>
                <select name="id_penulis" class="form-select">
                    <option value="">-- Pilih --</option>
                    <?php foreach ($penulis as $p): ?>
                        <option value="<?= $p['id_penulis'] ?>"
                            <?= ($buku['id_penulis'] == $p['id_penulis']) ? 'selected' : '' ?>>
                            <?= $p['nama_penulis'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="text" name="penulis_baru" class="form-control mt-2"
                       placeholder="Atau tambah penulis baru">
            </div>

            <!-- PENERBIT -->
            <div class="mb-3">
                <label class="form-label">Penerbit</label>
                <select name="id_penerbit" class="form-select">
                    <option value="">-- Pilih --</option>
                    <?php foreach ($penerbit as $p): ?>
                        <option value="<?= $p['id_penerbit'] ?>"
                            <?= ($buku['id_penerbit'] == $p['id_penerbit']) ? 'selected' : '' ?>>
                            <?= $p['nama_penerbit'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="text" name="penerbit_baru" class="form-control mt-2"
                       placeholder="Atau tambah penerbit baru">
            </div>

            <!-- RAK -->
            <div class="mb-3">
                <label class="form-label">Rak</label>
                <select name="id_rak" class="form-select">
                    <option value="">-- Pilih Rak --</option>
                    <?php foreach ($rak as $r): ?>
                        <option value="<?= $r['id_rak'] ?>"
                            <?= ($buku['id_rak'] ?? '') == $r['id_rak'] ? 'selected' : '' ?>>
                            <?= $r['nama_rak'] ?> - <?= $r['lokasi'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- TAHUN -->
            <div class="mb-3">
                <label class="form-label">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" class="form-control"
                       value="<?= old('tahun_terbit', $buku['tahun_terbit']) ?>">
            </div>

            <!-- JUMLAH -->
            <div class="mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" name="jumlah" class="form-control"
                       value="<?= old('jumlah', $buku['jumlah']) ?>">
            </div>

            <!-- TERSEDIA -->
            <div class="mb-3">
                <label class="form-label">Tersedia</label>
                <input type="number" name="tersedia" class="form-control"
                       value="<?= old('tersedia', $buku['tersedia']) ?>">
            </div>

            <!-- DESKRIPSI -->
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4"><?= old('deskripsi', $buku['deskripsi']) ?></textarea>
            </div>

            <!-- COVER -->
            <div class="mb-3">
                <label class="form-label">Cover</label>

                <input type="hidden" name="old_cover" value="<?= $buku['cover'] ?>">

                <?php if ($buku['cover']): ?>
                    <div>
                        <img src="<?= base_url('uploads/buku/' . $buku['cover']) ?>" class="cover-preview">
                    </div>
                <?php endif; ?>

                <input type="file" name="cover" class="form-control">
                <small class="text-muted">Kosongkan jika tidak ingin mengganti cover</small>
            </div>

            <!-- ACTION -->
            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Update
                </button>

                <a href="<?= base_url('buku') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

        </form>

    </div>

</div>

<?= $this->endSection() ?>