<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\KategoriModel;
use App\Models\PenulisModel;
use App\Models\PenerbitModel;
use App\Models\RakModel;
use App\Models\BukuRakModel;

class Buku extends BaseController
{
    protected $bukuModel;

    public function __construct()
    {
        $this->bukuModel = new BukuModel();
    }

public function create()
{
    $kategoriModel = new \App\Models\KategoriModel();
    $penulisModel = new \App\Models\PenulisModel();
    $penerbitModel = new \App\Models\PenerbitModel();
    $RakModel = new \App\Models\RakModel();
    
    $data = [
        'kategori' => $kategoriModel->findAll(),
        'penulis' => $penulisModel->findAll(),
        'penerbit' => $penerbitModel->findAll(),
        'rak' => $RakModel->findAll(),
    ];

    return view('buku/create', $data);
}

    // LIST DATA
    public function index()
{
    $keyword = $this->request->getGet('keyword');
    $kategori = $this->request->getGet('kategori');

    $builder = $this->bukuModel
        ->select('buku.*, kategori.nama_kategori, penulis.nama_penulis, penerbit.nama_penerbit, rak.nama_rak, rak.lokasi')
        ->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left')
        ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left')
        ->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left')
        ->join('buku_rak', 'buku_rak.id_buku = buku.id_buku', 'left')
        ->join('rak', 'rak.id_rak = buku_rak.id_rak', 'left');

    // FILTER JUDUL
    if ($keyword) {
        $builder->like('buku.judul', $keyword);
    }

    // FILTER KATEGORI
    if ($kategori) {
        $builder->where('buku.id_kategori', $kategori);
    }

    $data['buku'] = $builder->paginate(10);
    $data['pager'] = $this->bukuModel->pager;

    // kirim data kategori ke view
    $kategoriModel = new \App\Models\KategoriModel();
    $data['kategori'] = $kategoriModel->findAll();

    return view('buku/index', $data);
}

    // SIMPAN (MULTI INPUT)
  public function store()
{
    $kategoriModel = new KategoriModel();
    $penulisModel = new PenulisModel();
    $penerbitModel = new PenerbitModel();
    $bukuRakModel = new \App\Models\BukuRakModel();

    // kategori
    $id_kategori = $this->request->getPost('id_kategori');
    if ($this->request->getPost('kategori_baru')) {
        $id_kategori = $kategoriModel->insert([
            'nama_kategori' => $this->request->getPost('kategori_baru')
        ]);
    }

    // penulis
    $id_penulis = $this->request->getPost('id_penulis');
    if ($this->request->getPost('penulis_baru')) {
        $id_penulis = $penulisModel->insert([
            'nama_penulis' => $this->request->getPost('penulis_baru')
        ]);
    }

    // penerbit
    $id_penerbit = $this->request->getPost('id_penerbit');
    if ($this->request->getPost('penerbit_baru')) {
        $id_penerbit = $penerbitModel->insert([
            'nama_penerbit' => $this->request->getPost('penerbit_baru')
        ]);
    }

    // ambil rak
    $id_rak = $this->request->getPost('id_rak');

    // cover
    $cover = $this->request->getFile('cover');
    $namaCover = null;

    if ($cover && $cover->isValid()) {
        $namaCover = $cover->getRandomName();
        $cover->move('uploads/buku', $namaCover);
    }

    // judul
   $judul = $this->request->getPost('judul');

        if ($judul != '') {

            // simpan buku
            $id_buku = $this->bukuModel->insert([
                'judul' => $judul,
                'isbn' => $this->request->getPost('isbn'),
                'id_kategori' => $id_kategori,
                'id_penulis' => $id_penulis,
                'id_penerbit' => $id_penerbit,
                'tahun_terbit' => $this->request->getPost('tahun_terbit'),
                'jumlah' => $this->request->getPost('jumlah'),
                'tersedia' => $this->request->getPost('jumlah'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'cover' => $namaCover
            ]);

            // simpan ke buku_rak
            if ($id_rak) {
                $bukuRakModel->insert([
                    'id_buku' => $id_buku,
                    'id_rak' => $id_rak
                ]);
            }
        }

    return redirect()->to('/buku')->with('success', 'Buku berhasil ditambahkan');
}
    // DETAIL
    public function detail($id)
{
    $data['buku'] = $this->bukuModel
        ->select('buku.*, kategori.nama_kategori, penulis.nama_penulis, penerbit.nama_penerbit, rak.nama_rak, rak.lokasi')
        ->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left')
        ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left')
        ->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left')
        ->join('buku_rak', 'buku_rak.id_buku = buku.id_buku', 'left')
        ->join('rak', 'rak.id_rak = buku_rak.id_rak', 'left')
        ->where('buku.id_buku', $id)
        ->first();

    return view('buku/detail', $data);
}

    public function print()
{
    $keyword = $this->request->getGet('keyword');
    $kategori = $this->request->getGet('kategori');

    $builder = $this->bukuModel
        ->select('buku.*, kategori.nama_kategori, penulis.nama_penulis, penerbit.nama_penerbit')
        ->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left')
        ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left')
        ->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left');

    if ($keyword) {
        $builder->like('buku.judul', $keyword);
    }

    if ($kategori) {
        $builder->where('buku.id_kategori', $kategori);
    }

    $data['buku'] = $builder->findAll();

    return view('buku/print', $data);
}

    // EDIT
    public function edit($id)
{
    $kategoriModel = new \App\Models\KategoriModel();
    $penulisModel = new \App\Models\PenulisModel();
    $penerbitModel = new \App\Models\PenerbitModel();
    $rakModel = new \App\Models\RakModel();

    $data = [
        'buku' => $this->bukuModel->find($id),
        'kategori' => $kategoriModel->findAll(),
        'penulis' => $penulisModel->findAll(),
        'penerbit' => $penerbitModel->findAll(),
        'rak' => $rakModel->findAll(),
    ];

    return view('buku/edit', $data);
}

    // UPDATE
    public function update($id)
{
    $cover = $this->request->getFile('cover');
    $namaCover = $this->request->getPost('old_cover');

    if ($cover && $cover->isValid() && !$cover->hasMoved()) {
        $namaCover = $cover->getRandomName();
        $cover->move('uploads/buku', $namaCover);
    }

    $this->bukuModel->update($id, [
        'judul' => $this->request->getPost('judul'),
        'isbn' => $this->request->getPost('isbn'),
        'id_kategori' => $this->request->getPost('id_kategori') ?: null,
        'id_penulis' => $this->request->getPost('id_penulis') ?: null,
        'id_penerbit' => $this->request->getPost('id_penerbit') ?: null,
        'tahun_terbit' => $this->request->getPost('tahun_terbit'),
        'jumlah' => $this->request->getPost('jumlah'),
        'tersedia' => $this->request->getPost('tersedia'),
        'deskripsi' => $this->request->getPost('deskripsi'),
        'cover' => $namaCover
    ]);

    return redirect()->to('/buku');
}

    // DELETE
    public function delete($id)
    {
        $this->bukuModel->delete($id);
        return redirect()->to('/buku');
    }

     public function wa($id)
    {
        $buku = $this->detailData($id);

        $pesan = "DATA BUKU\n\n";
        foreach ($buku as $key => $value) {
            $pesan .= strtoupper($key) . ": " . $value . "\n";
        }

        return redirect()->to("https://wa.me/6285175017991?text=" . urlencode($pesan));
    }

   private function detailData($id)
{
    return $this->bukuModel
        ->select('buku.*, kategori.nama_kategori, penulis.nama_penulis, penerbit.nama_penerbit')
        ->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left')
        ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left')
        ->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left')
        ->where('buku.id_buku', $id)
        ->first();
}
}