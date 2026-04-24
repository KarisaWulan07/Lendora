<?php

namespace App\Controllers;

use App\Models\DendaModel;

class Denda extends BaseController
{
    // =====================
    // LIST DENDA
    // =====================
    public function index()
{
    $model = new \App\Models\DendaModel();

    $search = $this->request->getGet('search');
    $role = session()->get('role');
    $id_user = session()->get('id');

    $builder = $model
        ->select('
            denda.*,
            peminjaman.id_peminjaman,
            users.nama as nama_anggota
        ')
        ->join('pengembalian', 'pengembalian.id_pengembalian = denda.id_pengembalian', 'left')
        ->join('peminjaman', 'peminjaman.id_peminjaman = pengembalian.id_peminjaman', 'left')
        ->join('users', 'users.id = peminjaman.id_anggota', 'left');

    // 🔥 FILTER KHUSUS ANGGOTA
    if ($role == 'anggota') {
        $builder->where('peminjaman.id_anggota', $id_user);
    }

    // 🔍 SEARCH
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
    // KONFIRMASI SUDAH BAYAR (ANGGOTA)
    // =====================
    public function konfirmasi()
{
    $id = $this->request->getPost('id_denda');
    $file = $this->request->getFile('bukti');

    // 🔥 VALIDASI FILE
    if (!$file->isValid()) {
        return redirect()->back()->with('error', 'Upload gagal');
    }

    if (!in_array($file->getExtension(), ['jpg', 'jpeg', 'png'])) {
        return redirect()->back()->with('error', 'Format harus gambar (jpg/png)');
    }

    // 🔥 GENERATE NAMA FILE
    $namaFile = $file->getRandomName();

    // 🔥 SIMPAN FILE
    $file->move('uploads/bukti', $namaFile);

    // 🔥 UPDATE DATABASE
    $this->dendaModel->update($id, [
        'status' => 'menunggu',
        'metode_pembayaran' => 'qris',
        'bukti_pembayaran' => $namaFile
    ]);

    return redirect()->to('denda')
        ->with('success', 'Bukti dikirim, menunggu verifikasi admin');
}

    // =====================
    // ADMIN - VERIFIKASI LUNAS
    // =====================
    public function lunas($id)
    {
        $model = new DendaModel();

        $model->update($id, [
            'status_bayar' => 'lunas'
        ]);

        return redirect()->to('denda')
            ->with('success', 'Pembayaran diset LUNAS');
    }

    // =====================
    // ADMIN - TOLAK PEMBAYARAN
    // =====================
   public function tolak($id)
{
    $model = new DendaModel();

    $model->update($id, [
        'status_denda' => 'ditolak'
    ]);

    return redirect()->to('denda')
        ->with('success', 'Pembayaran ditolak');
}
    // =====================
    // (OPSIONAL) FORM QRIS
    // =====================
    public function qris($id)
{
    $model = new \App\Models\DendaModel();

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
    public function bayar($id)
{
    $model = new \App\Models\DendaModel();

    $denda = $model->find($id);

    if (!$denda) {
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    return view('denda/bayar', [
        'denda' => $denda
    ]);
}
public function prosesBayar()
{
    $model = new \App\Models\DendaModel();

    $id = $this->request->getPost('id_denda');
    $metode = strtolower($this->request->getPost('metode'));

    $file = $this->request->getFile('bukti');
    $namaFile = null;

    // 🔥 kalau upload bukti
    if ($file && $file->isValid() && !$file->hasMoved()) {

        $namaFile = $file->getRandomName();
        $file->move('uploads/', $namaFile);
    }

    // 🔥 status otomatis
    if ($metode == 'cash') {
        $status = 'lunas';
    } else {
        $status = 'menunggu';
    }

    $model->update($id, [
        'metode_pembayaran' => $metode,
        'status_denda' => $status,
        'bukti_pembayaran' => $namaFile
    ]);

    return redirect()->to('/denda')->with('success', 'Pembayaran berhasil dikirim');
}
public function approve($id)
{
    $model = new \App\Models\DendaModel();

    $model->update($id, [
        'status_denda' => 'lunas'
    ]);

    return redirect()->to('/denda')->with('success', 'Pembayaran disetujui');
}
public function konfirmasiBayar()
{
    $model = new \App\Models\DendaModel();

    $id = $this->request->getPost('id_denda');
    $file = $this->request->getFile('bukti');

    $namaFile = null;

    if ($file && $file->isValid() && !$file->hasMoved()) {

        // ✅ VALIDASI FILE DI SINI
        if (!in_array($file->getExtension(), ['jpg','jpeg','png'])) {
            return redirect()->back()->with('error', 'File harus gambar!');
        }

        // (opsional) batas ukuran 2MB
        if ($file->getSize() > 2 * 1024 * 1024) {
            return redirect()->back()->with('error', 'Ukuran max 2MB!');
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
public function verifikasi($id)
{
    $model = new \App\Models\DendaModel();

    $model->update($id, [
        'status_denda' => 'lunas',
        'id_petugas_verif' => session()->get('id') // simpan siapa yang verif
    ]);

    return redirect()->to('/denda')->with('success', 'Denda berhasil diverifikasi');
}
public function prosesCash()
{
    $model = new \App\Models\DendaModel();

    $id = $this->request->getPost('id_denda');

    $model->update($id, [
        'status_denda' => 'lunas',
        'metode_pembayaran' => 'cash',
        'id_petugas_verif' => session()->get('id')
    ]);

    return redirect()->to('/denda')->with('success', 'Pembayaran cash berhasil');
}

}