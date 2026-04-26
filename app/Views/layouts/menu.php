<?php
$role = session()->get('role');
$idu  = session()->get('id');

/* ================= MENU CONFIG ================= */
$menus = [

    [
        'url'   => '/',
        'icon'  => 'bi-speedometer2',
        'label' => 'Dashboard',
        'roles' => ['admin', 'petugas', 'anggota']
    ],
    [
        'url'   => '/users',
        'icon'  => 'bi-people',
        'label' => 'Users',
        'roles' => ['admin', 'petugas']
    ],
    [
        'url'   => '/buku',
        'icon'  => 'bi-book',
        'label' => 'Buku',
        'roles' => ['admin', 'petugas', 'anggota']
    ],
    [
        'url'   => '/rak',
        'icon'  => 'bi-archive',
        'label' => 'Rak',
        'roles' => ['admin', 'petugas', 'anggota']
    ],
    [
        'url'   => '/peminjaman',
        'icon'  => 'bi-box',
        'label' => 'Peminjaman',
        'roles' => ['admin', 'petugas', 'anggota']
    ],
    [
        'url'   => '/pengembalian',
        'icon'  => 'bi-arrow-repeat',
        'label' => 'Pengembalian',
        'roles' => ['admin', 'petugas']
    ],
    [
        'url'   => '/denda',
        'icon'  => 'bi-cash-stack',
        'label' => 'Denda',
        'roles' => ['admin', 'petugas', 'anggota']
    ],
    [
        'url'   => '/kategori',
        'icon'  => 'bi-tags',
        'label' => 'Kategori',
        'roles' => ['admin', 'petugas']
    ],
    [
        'url'   => '/penulis',
        'icon'  => 'bi-pencil-square',
        'label' => 'Penulis',
        'roles' => ['admin', 'petugas']
    ],
    [
        'url'   => '/penerbit',
        'icon'  => 'bi-building',
        'label' => 'Penerbit',
        'roles' => ['admin', 'petugas']
    ],
];
?>

<style>
/* ================= USER ================= */
.menu-user {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px;
    margin-top: 15px;
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
}

.menu-user img {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    object-fit: cover;
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
    padding: 10px 12px;
    border-radius: 12px;
    color: #fff;
    text-decoration: none;
    margin-bottom: 5px;
    transition: 0.25s;
    font-size: 14px;
}

.menu-list a:hover {
    background: rgba(255,255,255,0.15);
    transform: translateX(6px);
}

.menu-list .logout:hover {
    background: rgba(255, 0, 0, 0.2);
}

/* ACTIVE MENU */
.menu-list a.active {
    background: rgba(255,255,255,0.25);
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

        <div>
            <div class="fw-semibold"><?= session('nama'); ?></div>
            <small class="text-light"><?= session('role'); ?></small>
        </div>
    </div>

    <!-- MENU -->
    <div class="menu-list mt-3">

        <?php foreach ($menus as $m): ?>
            <?php if (in_array($role, $m['roles'])): ?>
                
                <?php
                $active = uri_string() == trim($m['url'], '/') ? 'active' : '';
                ?>

                <a href="<?= base_url($m['url']) ?>" class="<?= $active ?>">
                    <i class="bi <?= $m['icon'] ?>"></i>
                    <span><?= $m['label'] ?></span>
                </a>

            <?php endif; ?>
        <?php endforeach; ?>

        <!-- SETTING -->
        <a href="<?= base_url('users/edit/' . $idu) ?>">
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