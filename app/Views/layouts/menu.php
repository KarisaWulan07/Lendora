<?php 
$role = session()->get('role');
?>

<style>
/* ================= USER CARD ================= */
/* GANTI CSS .menu-user YANG LAMA DENGAN INI */

.menu-user {
    background: rgba(255,255,255,0.10);
    border-radius: 14px;
    padding: 14px 12px;
    margin-top: 15px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}

.menu-user img {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid rgba(255,255,255,0.7);
    margin-bottom: 8px;
}

.menu-user .user-name {
    font-size: 13px;
    font-weight: 600;
    color: #fff;
    margin-bottom: 2px;
}

.menu-user .user-role {
    font-size: 11px;
    color: rgba(255,255,255,0.85);
    margin-bottom: 10px;
    text-transform: capitalize;
}

.menu-user .account-btn {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 600;
    text-decoration: none;
    background: rgba(255,255,255,0.18);
    color: #fff;
    transition: 0.3s;
}

.menu-user .account-btn:hover {
    background: rgba(255,255,255,0.28);
    color: #fff;
}

/* ================= WRAPPER ================= */
.menu-wrapper {
    display: flex;
    flex-direction: column;
    height: 100%;
}

/* ================= BRAND ================= */
.menu-brand i {
    font-size: 30px;
    color: #1B7F9F;
    margin-bottom: 5px;
}

.menu-brand .title {
    font-weight: bold;
    font-size: 18px;
    color: #fff;
}

.menu-brand .tagline {
    font-size: 13px;
    color: #fcf7f7;
}

/* ================= MENU ================= */
.menu-list {
    flex-grow: 1;
}

.menu-list a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 14px;
    border-radius: 12px;
    color: #fff;
    text-decoration: none;
    margin-bottom: 6px;
    transition: 0.25s;
    font-size: 14px;
}

.menu-list a:hover {
    background: rgba(255,255,255,0.15);
    transform: translateX(5px);
}

.menu-list .logout:hover {
    background: rgba(255, 0, 0, 0.18);
}

.menu-list a.active {
    background: rgba(255,255,255,0.22);
}
</style>

<div class="menu-wrapper">
<br>

<!-- BRAND -->
<div class="menu-brand d-flex align-items-center">
    <div class="brand-icon me-2">
        <i class="bi bi-book-half"></i>
    </div>

    <div class="brand-text">
        <div class="title">Lendora</div>
        <div class="tagline">Smart Library, Smart You</div>
    </div>
</div>

<br>

<!-- USER -->
<div class="menu-user">
    <img src="<?= session()->get('foto') 
        ? base_url('uploads/users/' . session()->get('foto')) 
        : base_url('assets/img/default.png') ?>" alt="user">

    <div class="user-name">
        <?= session('nama'); ?>
    </div>

    <div class="user-role">
        <?= session('role'); ?>
    </div>

    <a href="<?= base_url('users/edit/' . session()->get('id')) ?>" class="account-btn">
        <i class="bi bi-person-fill"></i> Personal Account
    </a>
</div>

<!-- MENU -->
<div class="menu-list mt-4">

    <a href="<?= base_url('/') ?>">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
    </a>

    <?php if (in_array($role, ['admin', 'petugas'])): ?>
    <a href="<?= base_url('/users') ?>">
        <i class="bi bi-people"></i>
        <span>Users</span>
    </a>
    <?php endif; ?>

    <a href="<?= base_url('/buku') ?>">
        <i class="bi bi-book"></i>
        <span>Buku</span>
    </a>

    <a href="<?= base_url('/rak') ?>">
        <i class="bi bi-archive"></i>
        <span>Rak</span>
    </a>

    <a href="<?= base_url('/peminjaman') ?>">
        <i class="bi bi-box"></i>
        <span>Peminjaman</span>
    </a>

    <?php if (in_array($role, ['admin', 'petugas'])): ?>
    <a href="<?= base_url('/pengembalian') ?>">
        <i class="bi bi-arrow-repeat"></i>
        <span>Pengembalian</span>
    </a>
    <?php endif; ?>

    <a href="<?= base_url('/denda') ?>">
        <i class="bi bi-cash-stack"></i>
        <span>Denda</span>
    </a>

    <?php if (in_array($role, ['admin', 'petugas'])): ?>
    <a href="<?= base_url('/kategori') ?>">
        <i class="bi bi-tags"></i>
        <span>Kategori</span>
    </a>

    <a href="<?= base_url('/penulis') ?>">
        <i class="bi bi-pencil-square"></i>
        <span>Penulis</span>
    </a>

    <a href="<?= base_url('/penerbit') ?>">
        <i class="bi bi-building"></i>
        <span>Penerbit</span>
    </a>
    <?php endif; ?>

    <!-- SETTING -->
    <a href="<?= base_url('users/edit/' . session()->get('id')) ?>">
        <i class="bi bi-gear"></i>
        <span>Setting</span>
    </a>

    <!-- BACKUP -->
    <?php if ($role == 'admin'): ?>
    <a href="<?= base_url('/backup') ?>">
        <i class="bi bi-database"></i>
        <span>Backup</span>
    </a>
    <?php endif; ?>

    <!-- LOGOUT -->
    <a href="<?= site_url('/logout') ?>" class="logout">
        <i class="bi bi-box-arrow-right"></i>
        <span>Logout</span>
    </a>

</div>
</div>