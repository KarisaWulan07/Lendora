<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ========================
// FILTER
// ========================
$authFilter = ['filter' => 'auth'];

$admin     = ['filter' => 'role:admin'];
$petugas   = ['filter' => 'role:petugas'];
$anggota   = ['filter' => 'role:anggota'];
$intRole   = ['filter' => 'role:admin, petugas'];
$allRole   = ['filter' => 'role:admin, petugas, anggota'];


// ========================
// AUTH (LOGIN & REGISTER)
// ========================

$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::prosesLogin');

$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::prosesRegister');

$routes->get('/logout', 'Auth::logout');


// ================= DASHBOARD (WAJIB LOGIN) =================
$routes->get('/', 'Home::index', $authFilter);
$routes->get('/dashboard', 'Home::index', $authFilter);
$routes->group('', function($routes) {
    $routes->get('/', 'Dashboard::index');

    $routes->get('rak', 'Rak::index');
    $routes->get('buku', 'Buku::index');
    $routes->get('peminjaman', 'Peminjaman::index');
    $routes->get('pengembalian', 'Pengembalian::index');
    $routes->get('denda', 'Denda::index');
});
// USERS
// ========================
$routes->get('/users/create', 'Users::create');
$routes->post('/users/store', 'Users::store');

$routes->get('/users', 'Users::index', $intRole);
$routes->get('/users/edit/(:num)', 'Users::edit/$1', $allRole);
$routes->post('/users/update/(:num)', 'Users::update/$1', $allRole);
$routes->get('/users/delete/(:num)', 'Users::delete/$1', $allRole);

$routes->get('users/detail/(:num)', 'Users::detail/$1', $allRole);
$routes->get('users/print', 'Users::print', $allRole);
$routes->get('users/wa/(:num)', 'Users::wa/$1', $allRole);



// ========================
// BUKU
// ========================
$routes->get('buku', 'Buku::index');
$routes->get('buku/create', 'Buku::create');
$routes->post('buku/store', 'Buku::store');
$routes->get('buku/detail/(:num)', 'Buku::detail/$1');
$routes->get('buku/edit/(:num)', 'Buku::edit/$1');
$routes->post('buku/update/(:num)', 'Buku::update/$1');
$routes->get('buku/delete/(:num)', 'Buku::delete/$1');
$routes->get('buku/print', 'Buku::print');
$routes->get('buku/wa/(:num)', 'Buku::wa/$1');

// ========================
// KATEGORI
// ========================
$routes->get('kategori', 'Kategori::index');
$routes->get('kategori/create', 'Kategori::create');
$routes->post('kategori/store', 'Kategori::store');
$routes->get('kategori/edit/(:num)', 'Kategori::edit/$1');
$routes->post('kategori/update/(:num)', 'Kategori::update/$1');
$routes->get('kategori/delete/(:num)', 'Kategori::delete/$1');

// ========================
// PENULIS
// ========================
$routes->get('penulis', 'Penulis::index');
$routes->get('penulis/create', 'Penulis::create');
$routes->post('penulis/store', 'Penulis::store');
$routes->get('penulis/edit/(:num)', 'Penulis::edit/$1');
$routes->post('penulis/update/(:num)', 'Penulis::update/$1');
$routes->get('penulis/delete/(:num)', 'Penulis::delete/$1');


// ========================
// PENERBIT
// ========================
$routes->get('penerbit', 'Penerbit::index');
$routes->get('penerbit/create', 'Penerbit::create');
$routes->post('penerbit/store', 'Penerbit::store');
$routes->get('penerbit/edit/(:num)', 'Penerbit::edit/$1');
$routes->post('penerbit/update/(:num)', 'Penerbit::update/$1');
$routes->get('penerbit/delete/(:num)', 'Penerbit::delete/$1');

// ========================
// PEMINJAMAN
// ========================

// =====================
// PEMINJAMAN
// =====================
$routes->get('peminjaman', 'Peminjaman::index');
$routes->get('peminjaman/create', 'Peminjaman::create');
$routes->post('peminjaman/store', 'Peminjaman::store');
$routes->get('/peminjaman/perpanjang/(:num)', 'Peminjaman::perpanjang/$1');
$routes->get('/peminjaman/detail/(:num)', 'Peminjaman::detail/$1');
$routes->get('/peminjaman/delete/(:num)', 'Peminjaman::delete/$1');
$routes->get('peminjaman/print/(:num)', 'Peminjaman::print/$1');
$routes->get('/peminjaman/addCart/(:num)', 'Peminjaman::addCart/$1');
$routes->get('/peminjaman/removeCart/(:num)', 'Peminjaman::removeCart/$1');
$routes->get('peminjaman/wa/(:num)', 'Peminjaman::wa/$1');
$routes->get('/peminjaman/setujui/(:num)', 'Peminjaman::setujui/$1');

// =====================
// TAMBAHAN
// =====================
$routes->get('/peminjaman/wa/(:num)', 'Peminjaman::kirimWA/$1');


// =====================
// KHUSUS ADMIN & PETUGAS
// =====================
$routes->get('/peminjaman/print', 'Peminjaman::print', ['filter' => 'role:admin,petugas']);


// ========================
// PENGEMBALIAN
// ========================
$routes->get('pengembalian', 'Pengembalian::index');
$routes->get('pengembalian/create', 'Pengembalian::create');
$routes->post('pengembalian/store', 'Pengembalian::store');
$routes->get('pengembalian/edit/(:num)', 'Pengembalian::edit/$1');
$routes->post('pengembalian/update/(:num)', 'Pengembalian::update/$1');
$routes->get('pengembalian/delete/(:num)', 'Pengembalian::delete/$1');
$routes->get('pengembalian/kembali/(:num)', 'Pengembalian::kembali/$1');


// ========================
// RAK
// ========================
$routes->get('/rak', 'Rak::index');
$routes->get('/rak/create', 'Rak::create');
$routes->post('/rak/store', 'Rak::store');
$routes->get('/rak/edit/(:num)', 'Rak::edit/$1');
$routes->post('/rak/update/(:num)', 'Rak::update/$1');
$routes->get('/rak/delete/(:num)', 'Rak::delete/$1');

//Backup
$routes->get('/backup', 'Backup::index');

$routes->get('/restore', 'Restore::index');
$routes->post('/restore/auth', 'Restore::auth');
$routes->get('/restore/form', 'Restore::form');
$routes->post('/restore/process', 'Restore::process');

//denda
$routes->group('denda', function($routes){

    $routes->get('/', 'Denda::index');

    $routes->get('bayar/(:num)', 'Denda::bayar/$1');
    $routes->post('prosesBayar', 'Denda::prosesBayar');

    // 🔥 WAJIB ADA INI
    $routes->get('approve/(:num)', 'Denda::approve/$1');
    $routes->get('tolak/(:num)', 'Denda::tolak/$1');

    $routes->get('detail/(:num)', 'Denda::detail/$1');
    
});
$routes->get('denda/verifikasi/(:num)', 'Denda::verifikasi/$1');
$routes->get('denda/qris/(:num)', 'Denda::qris/$1');
$routes->post('denda/konfirmasiBayar', 'Denda::konfirmasiBayar');
$routes->post('denda/prosesCash', 'Denda::prosesCash');