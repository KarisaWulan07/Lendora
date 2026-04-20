<a href="#">
    <b>📚 Lendora App</b>
</a><br><br>

<a href="<?= base_url('/') ?>">
    🏠 Dashboard
</a><br>

<?php if (session()->get('role') == 'admin' || session()->get('role') == 'petugas') : ?>
    <a href="<?= base_url('/users') ?>">
        👤 Users
    </a><br>
<?php endif; ?>

<?php 
$role = session()->get('role'); 
?>

<?php if (in_array($role, ['admin', 'petugas','anggota'])) : ?>
    <a href="<?= base_url('/buku') ?>">
        📖 Buku
    </a><br>
<?php endif; ?>

<?php if (in_array($role, ['admin', 'petugas', ' anggota'])) : ?>
    <a href="<?= base_url('/rak') ?>">
        🗄️ Rak
    </a><br>
<?php endif; ?>

<?php if (in_array($role, ['admin', 'petugas','anggota'])) : ?>
    <a href="<?= base_url('/peminjaman') ?>">
        📦 Peminjaman
    </a><br>
<?php endif; ?>

<!-- 🔥 TAMBAHAN PENGEMBALIAN -->
<?php if (in_array($role, ['admin', 'petugas'])) : ?>
    <a href="<?= base_url('/pengembalian') ?>">
        🔄 Pengembalian
    </a><br>
<?php endif; ?>

<?php if (in_array($role, ['admin', 'petugas'])) : ?>
    <a href="<?= base_url('/kategori') ?>">
        🗂️ Kategori
    </a><br>
<?php endif; ?>

<?php if (in_array($role, ['admin', 'petugas'])) : ?>
    <a href="<?= base_url('/penulis') ?>">
        ✍️ Penulis
    </a><br>
<?php endif; ?>

<?php if (in_array($role, ['admin', 'petugas'])) : ?>
    <a href="<?= base_url('/penerbit') ?>">
        🏢 Penerbit
    </a><br>
<?php endif; ?>

<?php $idu = session('id'); ?>
<a href="<?= base_url('users/edit/' . $idu) ?>">
    ⚙️ Setting
</a><br>

<a href="<?= site_url('/logout') ?>">
    🚪 Log Out
</a>

<br><br>

Masuk sebagai: <b><?= session('nama'); ?> (<?= session('role'); ?>)</b>
<br>

<img src="<?= base_url('uploads/users/' . session()->get('foto')) ?>" height="80" />