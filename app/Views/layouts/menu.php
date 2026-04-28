<?php 
$role = session()->get('role');
?>

<style>
/* ================= WRAPPER ================= */
.menu-wrapper {
    display: flex;
    flex-direction: column;
    height: 100vh;
    overflow-y: auto;
    padding-bottom: 20px;
}

.menu-wrapper::-webkit-scrollbar {
    width: 5px;
}

.menu-wrapper::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.2);
    border-radius: 10px;
}

/* ================= USER CARD ================= */
.menu-user {
    background: rgba(255,255,255,0.10);
    border-radius: 14px;
    padding: 14px 12px;
    margin-top: 15px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}

.menu-user img {
    width: 55px;
    height: 55px;
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

/* ================= BRAND ================= */
.menu-brand {
    margin-top: 15px;
}

.menu-brand i {
    font-size: 30px;
    color: #1B7F9F;
}

.menu-brand .title {
    font-weight: bold;
    font-size: 18px;
    color: #fff;
}

.menu-brand .tagline {
    font-size: 12px;
    color: #fcf7f7;
}

/* ================= MENU ================= */
.menu-list {
    flex-grow: 1;
    margin-top: 20px;
}

.menu-list a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    border-radius: 12px;
    color: #fff;
    text-decoration: none;
    margin-bottom: 5px;
    transition: 0.25s;
    font-size: 14px;
}

.menu-list a:hover {
    background: rgba(255,255,255,0.15);
    transform: translateX(4px);
}

.menu-list .logout:hover {
    background: rgba(255, 0, 0, 0.18);
}

/* ================= SUB MENU ================= */
.sub-menu {
    margin-top: 5px;
}

.sub-menu a {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    padding: 8px 14px 8px 45px;
    border-radius: 10px;
    color: #fff;
    text-decoration: none;
    margin-bottom: 4px;
    transition: 0.25s;
}

.sub-menu a:hover {
    background: rgba(255,255,255,0.12);
}
</style>

<div class="menu-wrapper">

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

        <a href="<?= base_url('profile') ?>" class="account-btn">
            <i class="bi bi-person-fill"></i>
            Personal Account
        </a>

    </div>

    <!-- MENU -->
    <div class="menu-list">

        <!-- DASHBOARD -->
        <a href="<?= base_url('/') ?>">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>

        <!-- USERS KHUSUS ADMIN -->
        <?php if ($role == 'admin'): ?>

        <a href="<?= base_url('/users') ?>">
            <i class="bi bi-people"></i>
            <span>Users</span>
        </a>

        <?php endif; ?>

        <!-- MENU BUKU -->
        <?php if (in_array($role, ['admin', 'petugas'])): ?>

        <!-- ADMIN & PETUGAS -->
        <div class="mb-1">

            <a class="d-flex align-items-center justify-content-between"
               data-bs-toggle="collapse"
               href="#menuBuku"
               role="button">

                <div>
                    <i class="bi bi-book"></i>
                    <span>Buku</span>
                </div>

                <i class="bi bi-chevron-down small"></i>
            </a>

            <div class="collapse mt-1" id="menuBuku">

                <div class="sub-menu">

                    <a href="<?= base_url('/buku') ?>">
                        <i class="bi bi-dot"></i>
                        Data Buku
                    </a>

                    <a href="<?= base_url('/kategori') ?>">
                        <i class="bi bi-dot"></i>
                        Kategori
                    </a>

                    <a href="<?= base_url('/penulis') ?>">
                        <i class="bi bi-dot"></i>
                        Penulis
                    </a>

                    <a href="<?= base_url('/penerbit') ?>">
                        <i class="bi bi-dot"></i>
                        Penerbit
                    </a>

                </div>

            </div>

        </div>

        <?php else: ?>

        <!-- ANGGOTA -->
        <a href="<?= base_url('/buku') ?>">
            <i class="bi bi-book"></i>
            <span>Buku</span>
        </a>

        <?php endif; ?>

        <!-- RAK KHUSUS ADMIN & PETUGAS -->
        <?php if (in_array($role, ['admin', 'petugas'])): ?>

        <a href="<?= base_url('/rak') ?>">
            <i class="bi bi-archive"></i>
            <span>Rak</span>
        </a>

        <?php endif; ?>

        <!-- PEMINJAMAN -->
        <a href="<?= base_url('/peminjaman') ?>">
            <i class="bi bi-box"></i>
            <span>Peminjaman</span>
        </a>

        <!-- PENGEMBALIAN KHUSUS ADMIN & PETUGAS -->
        <?php if (in_array($role, ['admin', 'petugas'])): ?>

        <a href="<?= base_url('/pengembalian') ?>">
            <i class="bi bi-arrow-repeat"></i>
            <span>Pengembalian</span>
        </a>

        <?php endif; ?>

        <!-- DENDA -->
        <a href="<?= base_url('/denda') ?>">
            <i class="bi bi-cash-stack"></i>
            <span>Denda</span>
        </a>

        <!-- SETTING -->
        <a href="<?= base_url('profile') ?>">
            <i class="bi bi-gear"></i>
            <span>Setting</span>
        </a>

        <!-- BACKUP KHUSUS ADMIN -->
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

<!-- BOOTSTRAP JS -->
<script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>