<?php

namespace App\Controllers;

use App\Models\PengembalianModel;
use App\Models\PeminjamanModel;
use App\Models\DetailPeminjamanModel;
use App\Models\BukuModel;
use App\Models\DendaModel;

class Pengembalian extends BaseController
{
    public function index()
    {
        $model = new PengembalianModel();

        $search = trim($this->request->getGet('search') ?? '');

        $builder = $model
            ->select('
                pengembalian.id_pengembalian,
                pengembalian.id_peminjaman,
                pengembalian.tanggal_dikembalikan,
                pengembalian.denda,

                users.nama AS nama_anggota,

                COALESCE(denda.jumlah_denda, 0) as jumlah_denda,
                COALESCE(denda.status_denda, "-") as status_denda
            ')
                ->join('peminjaman', 'peminjaman.id_peminjaman = pengembalian.id_peminjaman', 'left')
                ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
                ->join('users', 'users.id = peminjaman.id_anggota', 'left')
            ->join('denda', 'denda.id_pengembalian = pengembalian.id_pengembalian', 'left');

        // 🔥 SEARCH (tetap)
        if ($search !== '') {
            $builder->groupStart()
                ->like('pengembalian.id_pengembalian', $search)
                ->orLike('peminjaman.id_peminjaman', $search)
                ->orLike('users.nama', $search)
            ->groupEnd();
        }

        $data['pengembalian'] = $builder->findAll();

        return view('pengembalian/index', $data);
    }

    public function create()
    {
        $peminjaman = new PeminjamanModel();

        $data['peminjaman'] = $peminjaman
            ->where('status', 'dipinjam')
            ->findAll();

        return view('pengembalian/create', $data);
    }

    public function store()
    {
        $pengembalian = new PengembalianModel();
        $peminjaman   = new PeminjamanModel();
        $detail       = new DetailPeminjamanModel();
        $buku         = new BukuModel();
        $dendaModel   = new DendaModel();

        $id_peminjaman = $this->request->getPost('id_peminjaman');

        if (!$id_peminjaman) {
            return redirect()->back()->with('error', 'Peminjaman tidak dipilih');
        }

        $pinjam = $peminjaman->find($id_peminjaman);

        if (!$pinjam) {
            return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan');
        }

        $today = date('Y-m-d');

        // 🔥 HITUNG DENDA
        $denda = 0;
        if ($today > $pinjam['tanggal_kembali']) {
            $selisih = (strtotime($today) - strtotime($pinjam['tanggal_kembali'])) / 86400;
            $denda = $selisih * 1000;
        }

        // 🔥 SIMPAN PENGEMBALIAN
        $insert = $pengembalian->insert([
            'id_peminjaman' => $id_peminjaman,
            'tanggal_dikembalikan' => $today,
            'denda' => $denda
        ]);

        if (!$insert) {
            return redirect()->back()->with('error', json_encode($pengembalian->errors()));
        }

        $id_pengembalian = $pengembalian->getInsertID();

        // 🔥 SIMPAN DENDA
        if ($denda > 0) {
            $dendaModel->insert([
                'id_pengembalian' => $id_pengembalian,
                'jumlah_denda' => $denda,
                'status_denda' => 'belum',
                'metode_pembayaran' => null
            ]);
        }

        // 🔥 UPDATE STATUS PEMINJAMAN
        $peminjaman->update($id_peminjaman, [
            'status' => 'dikembalikan'
        ]);

        // 🔥 KEMBALIKAN STOK BUKU
        $list = $detail->where('id_peminjaman', $id_peminjaman)->findAll();

        foreach ($list as $d) {
            $b = $buku->find($d['id_buku']);

            if ($b) {
                $buku->update($d['id_buku'], [
                    'tersedia' => $b['tersedia'] + $d['jumlah']
                ]);
            }
        }

        return redirect()->to(base_url('pengembalian'))
            ->with('success', 'Berhasil dikembalikan');
    }

    public function delete($id)
    {
        $pengembalian = new PengembalianModel();
        $peminjaman   = new PeminjamanModel();
        $dendaModel   = new DendaModel();

        $data = $pengembalian->find($id);

        if ($data) {

            $dendaModel->where('id_pengembalian', $id)->delete();

            $peminjaman->update($data['id_peminjaman'], [
                'status' => 'dipinjam'
            ]);

            $pengembalian->delete($id);
        }

        return redirect()->to(base_url('pengembalian'))
            ->with('success', 'Data dihapus');
    }

    public function edit($id)
    {
        $model = new PengembalianModel();

        $data['kembali'] = $model->find($id);

        if (!$data['kembali']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        return view('pengembalian/edit', $data);
    }

    public function update($id)
    {
        $model = new PengembalianModel();

        $model->update($id, [
            'tanggal_dikembalikan' => $this->request->getPost('tanggal_dikembalikan')
        ]);

        return redirect()->to(base_url('pengembalian'))
            ->with('success', 'Data diupdate');
    }
}