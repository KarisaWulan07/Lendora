<?php

namespace App\Controllers;

use App\Models\DendaModel;

class Denda extends BaseController
{
    protected $dendaModel;

    public function __construct()
    {
        $this->dendaModel = new DendaModel();
    }

    // =====================
    // LIST DENDA
    // =====================
  public function index()
{
    $model = new DendaModel();

    $search = $this->request->getGet('search');
    $role = session()->get('role');
    $id_user = session()->get('id');

    $builder = $model
        ->select('
            denda.*,
            peminjaman.id_peminjaman,
            users.nama as nama_anggota,
            petugas.nama as nama_petugas
        ')
        ->join('pengembalian', 'pengembalian.id_pengembalian = denda.id_pengembalian', 'left')
        ->join('peminjaman', 'peminjaman.id_peminjaman = pengembalian.id_peminjaman', 'left')

        // 👤 anggota
        ->join('users', 'users.id = peminjaman.id_anggota', 'left')

        // 🧑‍💼 petugas/admin verifikasi
        ->join('users as petugas', 'petugas.id = denda.id_petugas_verif', 'left');

    // =====================
    // FILTER ANGGOTA
    // =====================
    if ($role == 'anggota') {
        $builder->where('peminjaman.id_anggota', $id_user);
    }

    // =====================
    // SEARCH
    // =====================
    if ($search) {
        $builder->groupStart()
            ->like('users.nama', $search)
            ->orLike('peminjaman.id_peminjaman', $search)
            ->groupEnd();
    }

    return view('denda/index', [
        'denda' => $builder->findAll(),
        'search' => $search
    ]);
}
    // =====================
    // BAYAR PAGE
    // =====================
    public function bayar($id)
    {
        $model = new DendaModel();

        $denda = $model
            ->select('denda.*, users.nama as nama_anggota')
            ->join('pengembalian', 'pengembalian.id_pengembalian = denda.id_pengembalian', 'left')
            ->join('peminjaman', 'peminjaman.id_peminjaman = pengembalian.id_peminjaman', 'left')
            ->join('users', 'users.id = peminjaman.id_anggota', 'left')
            ->find($id);

        if (!$denda) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        return view('denda/bayar', [
            'denda' => $denda
        ]);
    }

    // =====================
    // CASH (ANGGOTA ONLY)
    // =====================
    public function prosesCash()
    {
        $role = session()->get('role');

        if ($role != 'anggota') {
            return redirect()->to('/denda')
                ->with('error', 'Hanya anggota yang bisa membayar');
        }

        $model = new DendaModel();

        $id = $this->request->getPost('id_denda');

        $model->update($id, [
            'status_denda' => 'lunas',
            'metode_pembayaran' => 'cash',
            'id_petugas_verif' => session()->get('id')
        ]);

        return redirect()->to('/denda')->with('success', 'Pembayaran cash berhasil');
    }

    // =====================
    // QRIS PAGE
    // =====================
    public function qris($id)
    {
        $model = new DendaModel();

        $denda = $model
            ->select('denda.*, peminjaman.id_peminjaman')
            ->join('pengembalian', 'pengembalian.id_pengembalian = denda.id_pengembalian', 'left')
            ->join('peminjaman', 'peminjaman.id_peminjaman = pengembalian.id_peminjaman', 'left')
            ->find($id);

        if (!$denda) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        return view('denda/qris', [
            'denda' => $denda
        ]);
    }

    // =====================
    // VERIFIKASI (ADMIN / PETUGAS)
    // =====================
   public function verifikasi($id)
{
    $role = session()->get('role');

    if (!in_array($role, ['admin','petugas'])) {
        return redirect()->to('/denda')
            ->with('error', 'Tidak diizinkan');
    }

    $model = new \App\Models\DendaModel();

    $model->update($id, [
        'status_denda' => 'lunas',
        'id_petugas_verif' => session()->get('id'),
        'tanggal_verifikasi' => date('Y-m-d H:i:s')
    ]);

    return redirect()->to('/denda')
        ->with('success', 'Diverifikasi');
}

    // =====================
    // TOLAK
    // =====================
    public function tolak($id)
    {
        $model = new DendaModel();

        $model->update($id, [
            'status_denda' => 'ditolak'
        ]);

        return redirect()->to('/denda')->with('success', 'Pembayaran ditolak');
    }
    public function konfirmasiBayar()
{
    $model = new \App\Models\DendaModel();

    $id = $this->request->getPost('id_denda');
    $file = $this->request->getFile('bukti');

    $namaFile = null;

    if ($file && $file->isValid() && !$file->hasMoved()) {

        if (!in_array($file->getExtension(), ['jpg','jpeg','png'])) {
            return redirect()->back()->with('error', 'File harus gambar!');
        }

        $namaFile = $file->getRandomName();
        $file->move('uploads/bukti', $namaFile);
    }

    $model->update($id, [
        'status_denda' => 'menunggu',
        'metode_pembayaran' => 'QRIS',
        'bukti_pembayaran' => $namaFile
    ]);

    return redirect()->to('/denda')->with('success', 'Bukti berhasil dikirim');
}
}