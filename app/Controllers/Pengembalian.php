<?php

namespace App\Controllers;

use App\Models\PengembalianModel;
use App\Models\PeminjamanModel;

class Pengembalian extends BaseController
{
    protected $pengembalian;
    protected $peminjaman;

    public function __construct()
    {
        $this->pengembalian = new PengembalianModel();
        $this->peminjaman = new PeminjamanModel();
    }

    // ================= INDEX + SEARCH =================
    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $data['pengembalian'] = $this->pengembalian
                ->like('id_peminjaman', $keyword)
                ->orLike('tanggal_dikembalikan', $keyword)
                ->findAll();
        } else {
            $data['pengembalian'] = $this->pengembalian->findAll();
        }

        return view('pengembalian/index', $data);
    }

    // ================= CREATE =================
    public function create()
    {
        return view('pengembalian/create');
    }

    // ================= STORE (AUTO DENDA + UPDATE STATUS) =================
    public function store()
{
    $id_peminjaman = $this->request->getPost('id_peminjaman');

    $pinjam = $this->peminjaman->find($id_peminjaman);

    if (!$pinjam) {
        return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan');
    }

    $tanggal_kembali = date('Y-m-d');

    $denda = 0;
    if ($pinjam['tanggal_kembali'] && $tanggal_kembali > $pinjam['tanggal_kembali']) {
        $terlambat = (strtotime($tanggal_kembali) - strtotime($pinjam['tanggal_kembali'])) / (60 * 60 * 24);
        $denda = $terlambat * 1000;
    }

    // simpan pengembalian
    $this->pengembalian->insert([
        'id_peminjaman' => $id_peminjaman,
        'tanggal_dikembalikan' => $tanggal_kembali,
        'denda' => $denda
    ]);

    // 🔥 UPDATE STATUS (FIX)
    $this->peminjaman
        ->set('status', 'dikembalikan')
        ->where('id_peminjaman', $id_peminjaman)
        ->update();

    return redirect()->to('/pengembalian')
        ->with('success', 'Pengembalian berhasil');
}

    // ================= EDIT =================
    public function edit($id)
    {
        $data['kembali'] = $this->pengembalian->find($id);
        return view('pengembalian/edit', $data);
    }

    public function update($id)
    {
        $this->pengembalian->update($id, [
            'id_peminjaman' => $this->request->getPost('id_peminjaman'),
            'tanggal_dikembalikan' => $this->request->getPost('tanggal_dikembalikan'),
            'denda' => $this->request->getPost('denda')
        ]);

        return redirect()->to('/pengembalian');
    }

    // ================= DELETE =================
    public function delete($id)
    {
        $this->pengembalian->delete($id);
        return redirect()->to('/pengembalian');
    }
}