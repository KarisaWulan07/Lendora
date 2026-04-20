<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\DetailPeminjamanModel;
use App\Models\BukuModel;
use App\Models\UsersModel;
use App\Models\KategoriModel; 

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
        $bukuModel = new BukuModel();
        $users = new UsersModel();

        $search = $this->request->getGet('search');

        // ✅ FILTER + JOIN PENULIS
        if($search){
            $buku = $bukuModel
                ->select('buku.*, penulis.nama_penulis')
                ->join('kategori', 'kategori.id_kategori = buku.id_kategori')
                ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left')
                ->like('kategori.nama_kategori', $search)
                ->findAll();
        } else {
            $buku = $bukuModel
                ->select('buku.*, penulis.nama_penulis')
                ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left')
                ->findAll();
        }

        // ✅ CART (FIX PENULIS)
        $cartSession = session()->get('cart') ?? [];
        $cart = [];

        foreach ($cartSession as $id => $qty) {
            $b = $bukuModel
                ->select('buku.*, penulis.nama_penulis')
                ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left')
                ->where('buku.id_buku', $id)
                ->first();

            if ($b) {
                $b['qty'] = $qty;
                $cart[] = $b;
            }
        }

        $data = [
            'buku' => $buku,
            'search' => $search,
            'anggota' => $users->findAll(),
            'petugas' => $users->where('role', 'petugas')->findAll(),
            'cart' => $cart
        ];

        return view('peminjaman/create', $data);
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

        // ✅ VALIDASI STOK
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

        // ✅ AUTO TANGGAL
        $tanggal_pinjam = date('Y-m-d');
        $tanggal_kembali = date('Y-m-d', strtotime('+7 days'));

        // ✅ INSERT
       $id = $peminjaman->insert([
    'id_anggota' => session()->get('id_user'), // ✅ FIX
    'id_petugas' => $this->request->getPost('id_petugas'),
    'tanggal_pinjam' => $tanggal_pinjam,
    'tanggal_kembali' => $tanggal_kembali,
    'status' => 'dipinjam'
]);

        if(!$id){
            return redirect()->back()->with('error','Gagal simpan peminjaman');
        }

        // ✅ DETAIL + UPDATE STOK
        foreach($cart as $id_buku => $qty){

            $b = $bukuModel->find($id_buku);

            $detail->insert([
                'id_peminjaman' => $id,
                'id_buku' => $id_buku,
                'jumlah' => $qty
            ]);

            $bukuModel->update($id_buku, [
                'tersedia' => $b['tersedia'] - $qty
            ]);
        }

        session()->remove('cart');

        return redirect()->to(base_url('peminjaman'))
            ->with('success','Peminjaman berhasil disimpan');
    }
}