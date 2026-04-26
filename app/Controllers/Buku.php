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

    // =====================
    // CREATE
    // =====================
    public function create()
    {
        $data = [
            'kategori' => (new KategoriModel())->findAll(),
            'penulis'  => (new PenulisModel())->findAll(),
            'penerbit' => (new PenerbitModel())->findAll(),
            'rak'      => (new RakModel())->findAll(),
        ];

        return view('buku/create', $data);
    }

    // =====================
    // INDEX (FILTER + JOIN)
    // =====================
    public function index()
    {
        $keyword  = $this->request->getGet('keyword');
        $kategori = $this->request->getGet('kategori');

        $builder = $this->bukuModel
            ->select('buku.*, kategori.nama_kategori, penulis.nama_penulis, penerbit.nama_penerbit, rak.nama_rak, rak.lokasi')
            ->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left')
            ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left')
            ->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left')
            ->join('buku_rak', 'buku_rak.id_buku = buku.id_buku', 'left')
            ->join('rak', 'rak.id_rak = buku_rak.id_rak', 'left');

        if ($keyword) {
            $builder->like('buku.judul', $keyword);
        }

        if ($kategori) {
            $builder->where('buku.id_kategori', $kategori);
        }

        $data['buku'] = $builder->paginate(10);
        $data['pager'] = $this->bukuModel->pager;
        $data['kategori'] = (new KategoriModel())->findAll();

        return view('buku/index', $data);
    }

    // =====================
    // STORE
    // =====================
    public function store()
    {
        $kategoriModel = new KategoriModel();
        $penulisModel  = new PenulisModel();
        $penerbitModel = new PenerbitModel();
        $bukuRakModel   = new BukuRakModel();

        $id_kategori = $this->request->getPost('id_kategori');
        if ($this->request->getPost('kategori_baru')) {
            $id_kategori = $kategoriModel->insert([
                'nama_kategori' => $this->request->getPost('kategori_baru')
            ]);
        }

        $id_penulis = $this->request->getPost('id_penulis');
        if ($this->request->getPost('penulis_baru')) {
            $id_penulis = $penulisModel->insert([
                'nama_penulis' => $this->request->getPost('penulis_baru')
            ]);
        }

        $id_penerbit = $this->request->getPost('id_penerbit');
        if ($this->request->getPost('penerbit_baru')) {
            $id_penerbit = $penerbitModel->insert([
                'nama_penerbit' => $this->request->getPost('penerbit_baru')
            ]);
        }

        $id_rak = $this->request->getPost('id_rak');

        $cover = $this->request->getFile('cover');
        $namaCover = null;

        if ($cover && $cover->isValid()) {
            $namaCover = $cover->getRandomName();
            $cover->move('uploads/buku', $namaCover);
        }

        $id_buku = $this->bukuModel->insert([
            'judul'        => $this->request->getPost('judul'),
            'isbn'         => $this->request->getPost('isbn'),
            'id_kategori'  => $id_kategori,
            'id_penulis'   => $id_penulis,
            'id_penerbit'  => $id_penerbit,
            'tahun_terbit' => $this->request->getPost('tahun_terbit'),
            'jumlah'       => $this->request->getPost('jumlah'),
            'tersedia'     => $this->request->getPost('jumlah'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
            'cover'        => $namaCover
        ]);

        if ($id_rak) {
            $bukuRakModel->insert([
                'id_buku' => $id_buku,
                'id_rak'  => $id_rak
            ]);
        }

        return redirect()->to('/buku');
    }

    // =====================
    // EDIT
    // =====================
    public function edit($id)
    {
        $bukuRakModel = new BukuRakModel();

        $buku = $this->bukuModel->find($id);
        $bukuRak = $bukuRakModel->where('id_buku', $id)->first();

        return view('buku/edit', [
            'buku' => $buku,
            'kategori' => (new KategoriModel())->findAll(),
            'penulis'  => (new PenulisModel())->findAll(),
            'penerbit' => (new PenerbitModel())->findAll(),
            'rak'      => (new RakModel())->findAll(),
            'id_rak_terpilih' => $bukuRak['id_rak'] ?? null
        ]);
    }

    // =====================
    // UPDATE (FIXED + SAFE)
    // =====================
    public function update($id)
    {
        $kategoriModel = new KategoriModel();
        $penulisModel  = new PenulisModel();
        $penerbitModel = new PenerbitModel();
        $bukuRakModel  = new BukuRakModel();

        $bukuLama = $this->bukuModel->find($id);

        // kategori
        $id_kategori = $this->request->getPost('id_kategori') ?: $bukuLama['id_kategori'];
        if ($this->request->getPost('kategori_baru')) {
            $id_kategori = $kategoriModel->insert([
                'nama_kategori' => $this->request->getPost('kategori_baru')
            ]);
        }

        // penulis
        $id_penulis = $this->request->getPost('id_penulis') ?: $bukuLama['id_penulis'];
        if ($this->request->getPost('penulis_baru')) {
            $id_penulis = $penulisModel->insert([
                'nama_penulis' => $this->request->getPost('penulis_baru')
            ]);
        }

        // penerbit
        $id_penerbit = $this->request->getPost('id_penerbit') ?: $bukuLama['id_penerbit'];
        if ($this->request->getPost('penerbit_baru')) {
            $id_penerbit = $penerbitModel->insert([
                'nama_penerbit' => $this->request->getPost('penerbit_baru')
            ]);
        }

        // rak (SAFE)
        $id_rak = $this->request->getPost('id_rak');
        if ($id_rak === '' || $id_rak === null) {
            $oldRak = $bukuRakModel->where('id_buku', $id)->first();
            $id_rak = $oldRak['id_rak'] ?? null;
        }

        // tahun terbit (SAFE)
        $tahun_terbit = $this->request->getPost('tahun_terbit') ?: $bukuLama['tahun_terbit'];

        // cover
        $cover = $this->request->getFile('cover');
        $namaCover = $this->request->getPost('old_cover') ?: $bukuLama['cover'];

        if ($cover && $cover->isValid() && !$cover->hasMoved()) {
            $namaCover = $cover->getRandomName();
            $cover->move('uploads/buku', $namaCover);
        }

        // update buku
        $this->bukuModel->update($id, [
            'judul'        => $this->request->getPost('judul'),
            'isbn'         => $this->request->getPost('isbn'),
            'id_kategori'  => $id_kategori,
            'id_penulis'   => $id_penulis,
            'id_penerbit'  => $id_penerbit,
            'tahun_terbit' => $tahun_terbit,
            'jumlah'       => $this->request->getPost('jumlah'),
            'tersedia'     => $this->request->getPost('tersedia'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
            'cover'        => $namaCover
        ]);

        // update rak
        $bukuRakModel->where('id_buku', $id)->delete();

        if ($id_rak) {
            $bukuRakModel->insert([
                'id_buku' => $id,
                'id_rak'  => $id_rak
            ]);
        }

        return redirect()->to('/buku')->with('success', 'Data berhasil diupdate');
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
 public function detail($id)
{
    $buku = $this->bukuModel
        ->select('
            buku.*,
            rak.nama_rak,
            rak.lokasi,
            penerbit.nama_penerbit,
            kategori.nama_kategori,
            penulis.nama_penulis
        ')
        ->join('buku_rak', 'buku_rak.id_buku = buku.id_buku', 'left')
        ->join('rak', 'rak.id_rak = buku_rak.id_rak', 'left')
        ->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left')
        ->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left') // 🔥 tambah
        ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left') // 🔥 tambah
        ->where('buku.id_buku', $id)
        ->first();

    if (!$buku) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Buku tidak ditemukan');
    }

    return view('buku/detail', [
        'buku' => $buku
    ]);
}
public function print()
{
    $db = \Config\Database::connect();

    $builder = $db->table('buku');
    $builder->select('buku.*, kategori.nama_kategori, penulis.nama_penulis, penerbit.nama_penerbit');
    $builder->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left');
    $builder->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left');
    $builder->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left');

    $data['buku'] = $builder->get()->getResultArray();

    return view('buku/print', $data);
}
}
