<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\UsersModel;
use App\Models\DetailPeminjamanModel;

class Peminjaman extends BaseController
{
    protected $peminjaman;
    protected $users;

    public function __construct()
    {
        $this->peminjaman = new PeminjamanModel();
        $this->users = new UsersModel();
    }

    // ================= LIST =================
    public function index()
    {
        $data['peminjaman'] = $this->peminjaman
            ->select('peminjaman.*, anggota.nama as nama_anggota, petugas.nama as nama_petugas')
            ->join('users as anggota', 'anggota.id = peminjaman.id_anggota')
            ->join('users as petugas', 'petugas.id = peminjaman.id_petugas')
            ->findAll();

        return view('peminjaman/index', $data);
    }

    // ================= FORM =================
    public function create()
    {
        $data = [
            'anggota' => $this->users->where('role', 'anggota')->findAll(),
            'petugas' => $this->users->where('role', 'petugas')->findAll(),
        ];

        return view('peminjaman/create', $data);
    }

public function store()
{
    $peminjamanModel = new \App\Models\PeminjamanModel();
    $detailModel = new \App\Models\DetailPeminjamanModel();

    $id_anggota = $this->request->getPost('id_anggota');

    if (!$id_anggota) {
        return redirect()->back()->with('error', 'ID Anggota wajib diisi');
    }

    $tanggal_pinjam = date('Y-m-d');
    $tanggal_kembali = date('Y-m-d', strtotime('+7 days'));

    $id_peminjaman = $peminjamanModel->insert([
        'id_anggota' => $id_anggota,
        'id_petugas' => session()->get('id'),
        'tanggal_pinjam' => $tanggal_pinjam,
        'tanggal_kembali' => $tanggal_kembali,
        'status' => 'dipinjam'
    ]);

    $bukuInput = $this->request->getPost('id_buku');
    $listBuku = explode("\n", $bukuInput);

    foreach ($listBuku as $buku) {
        $buku = trim($buku);

        if ($buku != '') {
            $detailModel->insert([
                'id_peminjaman' => $id_peminjaman,
                'id_buku' => $buku,
                'jumlah' => 1
            ]);
        }
    }

    return redirect()->to('/peminjaman');
}
    // ================= DETAIL =================
    public function detail($id)
    {
        $data['peminjaman'] = $this->peminjaman
            ->select('peminjaman.*, anggota.nama as nama_anggota, petugas.nama as nama_petugas')
            ->join('users as anggota', 'anggota.id = peminjaman.id_anggota')
            ->join('users as petugas', 'petugas.id = peminjaman.id_petugas')
            ->where('id_peminjaman', $id)
            ->first();

        return view('peminjaman/detail', $data);
    }

    // ================= KEMBALIKAN =================
    public function kembali($id)
{
    $model = new \App\Models\PeminjamanModel();

    $model->update($id, [
        'tanggal_kembali' => date('Y-m-d'),
        'status' => 'dikembalikan'
    ]);

    return redirect()->to('/peminjaman')
        ->with('success', 'Buku berhasil dikembalikan');
}

    // ================= DELETE =================
    public function delete($id)
    {
        $this->peminjaman->delete($id);
        return redirect()->to('/peminjaman');
    }
}