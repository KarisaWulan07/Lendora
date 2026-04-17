<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\DetailPeminjamanModel;

class Peminjaman extends BaseController
{
    protected $peminjamanModel;
    protected $detailModel;

    public function __construct()
    {
        $this->peminjamanModel = new PeminjamanModel();
        $this->detailModel = new DetailPeminjamanModel();
    }

    // 🔍 LIST + SEARCH
    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $data['peminjaman'] = $this->peminjamanModel
                ->like('id_peminjaman', $keyword)
                ->orLike('status', $keyword)
                ->findAll();
        } else {
            $data['peminjaman'] = $this->peminjamanModel->findAll();
        }

        return view('peminjaman/index', $data);
    }

    // ➕ FORM TAMBAH
    public function create()
    {
        return view('peminjaman/create');
    }

    // 💾 SIMPAN
    public function save()
    {
        $this->peminjamanModel->save([
            'id_anggota' => $this->request->getPost('id_anggota'),
            'id_petugas' => $this->request->getPost('id_petugas'),
            'tanggal_pinjam' => $this->request->getPost('tanggal_pinjam'),
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'status' => 'dipinjam'
        ]);

        return redirect()->to('/peminjaman');
    }

    // ✏️ EDIT
    public function edit($id)
    {
        $data['peminjaman'] = $this->peminjamanModel->find($id);
        return view('peminjaman/edit', $data);
    }

    // 🔄 UPDATE
    public function update($id)
    {
        $this->peminjamanModel->update($id, [
            'id_anggota' => $this->request->getPost('id_anggota'),
            'id_petugas' => $this->request->getPost('id_petugas'),
            'tanggal_pinjam' => $this->request->getPost('tanggal_pinjam'),
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'status' => $this->request->getPost('status')
        ]);

        return redirect()->to('/peminjaman');
    }

    // ❌ DELETE
    public function delete($id)
    {
        $this->peminjamanModel->delete($id);
        return redirect()->to('/peminjaman');
    }

    // 📄 DETAIL
    public function detail($id)
    {
        $data['peminjaman'] = $this->peminjamanModel->find($id);

        $data['detail'] = $this->detailModel
            ->select('detail_peminjaman.*, buku.judul')
            ->join('buku', 'buku.id_buku = detail_peminjaman.id_buku')
            ->where('id_peminjaman', $id)
            ->findAll();

        return view('peminjaman/detail', $data);
    }

    // ➕ FORM TAMBAH DETAIL
    public function tambahDetail($id)
    {
        return view('peminjaman/tambah_detail', ['id' => $id]);
    }

    // 💾 SIMPAN DETAIL MULTI
    public function saveDetail($id)
    {
        $input = $this->request->getPost('data_buku');
        $rows = explode("\n", $input);

        foreach ($rows as $row) {
            $pecah = explode('|', $row);

            if (count($pecah) == 2) {
                $this->detailModel->save([
                    'id_peminjaman' => $id,
                    'id_buku' => trim($pecah[0]),
                    'jumlah' => trim($pecah[1])
                ]);
            }
        }

        // update status
        $this->peminjamanModel->update($id, [
            'status' => 'dipinjam'
        ]);

        return redirect()->to('/peminjaman/detail/' . $id);
    }
}