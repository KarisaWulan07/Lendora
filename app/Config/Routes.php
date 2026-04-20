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
$routes->post('/proses-login', 'Auth::prosesLogin');
$routes->get('/logout', 'Auth::logout');

// 🔥 FIX PENTING (REGISTER)
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::prosesRegister');


// ========================
// HOME / DASHBOARD
// ========================
$routes->get('/', 'Home::index', $authFilter);
$routes->get('/dashboard', 'Home::index', $authFilter);


// ========================
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
$routes->get('peminjaman','Peminjaman::index');
$routes->get('peminjaman/create','Peminjaman::create');
$routes->post('peminjaman/store','Peminjaman::store');

$routes->get('peminjaman/detail/(:num)','Peminjaman::detail/$1');
$routes->get('peminjaman/delete/(:num)', 'Peminjaman::delete/$1');
$routes->get('peminjaman/addCart/(:num)','Peminjaman::addCart/$1');
$routes->get('peminjaman/removeCart/(:num)','Peminjaman::removeCart/$1');


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