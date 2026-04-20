<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\DetailPeminjamanModel;
use App\Models\BukuModel;
use App\Models\UsersModel;

class Peminjaman extends BaseController
{
    public function index()
    {
        $peminjaman = new PeminjamanModel();

        $data['peminjaman'] = $peminjaman
            ->select('peminjaman.*, users.nama')
            ->join('users', 'users.id = peminjaman.id_anggota', 'left')
            ->findAll();

        return view('peminjaman/index', $data);
    }

    public function detail($id)
    {
        $peminjaman = new PeminjamanModel();
        $detail = new DetailPeminjamanModel();

        $data['peminjaman'] = $peminjaman
            ->select('peminjaman.*, users.nama')
            ->join('users','users.id=peminjaman.id_anggota')
            ->where('id_peminjaman',$id)
            ->first();

        $data['detail'] = $detail
            ->select('detail_peminjaman.*, buku.judul')
            ->join('buku','buku.id_buku=detail_peminjaman.id_buku')
            ->where('id_peminjaman',$id)
            ->findAll();

        return view('peminjaman/detail',$data);
    }

   public function create()
{
    $buku = new BukuModel();
    $users = new UsersModel();

    $data = [
        'buku' => $buku->findAll(),

        // anggota = user login (auto)
        'anggota_login' => session()->get('nama'),

        // petugas list
        'petugas' => $users->where('role','petugas')->findAll(),

        'cart' => session()->get('cart') ?? []
    ];

    return view('peminjaman/create',$data);
}

    public function addCart($id)
    {
        $cart = session()->get('cart') ?? [];

        if(isset($cart[$id])){
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        session()->set('cart',$cart);

        return redirect()->back();
    }

    public function removeCart($id)
    {
        $cart = session()->get('cart') ?? [];

        unset($cart[$id]);

        session()->set('cart',$cart);

        return redirect()->back();
    }

   public function store()
{
    $peminjaman = new PeminjamanModel();
    $detail = new DetailPeminjamanModel();
    $bukuModel = new BukuModel();

    $cart = session()->get('cart');

    if(!$cart){
        return redirect()->back()->with('error','Pilih buku dulu');
    }

    // cek apakah buku valid
    foreach($cart as $id_buku => $qty){

        $b = $bukuModel->find($id_buku);

        if(!$b){
            return redirect()->back()->with('error','Buku tidak ditemukan');
        }

        if($b['tersedia'] < $qty){
            return redirect()->back()
                ->with('error','Stok "'.$b['judul'].'" tidak cukup');
        }
    }

    // INSERT PEMINJAMAN (AMANIN SESSION)
   $id = $peminjaman->insert([
    'id_anggota' => session()->get('id_user'), // AUTO LOGIN
    'id_petugas' => $this->request->getPost('id_petugas'),
    'tanggal_pinjam' => $this->request->getPost('tanggal_pinjam'),
    'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
    'status' => 'dipinjam'
]);

    // cek insert berhasil atau tidak
    if(!$id){
        return redirect()->back()->with('error','Gagal simpan peminjaman');
    }

    foreach($cart as $id_buku => $qty){

        $b = $bukuModel->find($id_buku);

        // insert detail
        $detail->insert([
            'id_peminjaman' => $id,
            'id_buku' => $id_buku,
            'jumlah' => $qty
        ]);

        // update stok
        $bukuModel->update($id_buku, [
            'tersedia' => $b['tersedia'] - $qty
        ]);
    }

    session()->remove('cart');

    return redirect()->to(base_url('peminjaman'))
        ->with('success','Peminjaman berhasil disimpan');
}
}