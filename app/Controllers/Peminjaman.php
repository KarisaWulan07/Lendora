<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\DetailPeminjamanModel;
use App\Models\BukuModel;
use App\Models\UsersModel;

class Peminjaman extends BaseController
{
    // =====================
    // INDEX
    // =====================
    public function index()
{
    $model = new PeminjamanModel();

    $keyword = $this->request->getGet('keyword');
    $role = session()->get('role');
    $id_anggota = session()->get('id');

    $builder = $model
        ->select('
            peminjaman.*,
            anggota.nama as nama_anggota,
            petugas.nama as nama_petugas,
            GROUP_CONCAT(buku.judul SEPARATOR ", ") as buku,
            COALESCE(denda.status_denda, "-") as status_denda,
            COALESCE(denda.jumlah_denda, 0) as jumlah_denda
        ')
        ->join('users as anggota', 'anggota.id = peminjaman.id_anggota')
        ->join('users as petugas', 'petugas.id = peminjaman.id_petugas')
        ->join('detail_peminjaman', 'detail_peminjaman.id_peminjaman = peminjaman.id_peminjaman', 'left')
        ->join('buku', 'buku.id_buku = detail_peminjaman.id_buku', 'left')

        // 🔥 FIX DI SINI
        ->join('pengembalian', 'pengembalian.id_peminjaman = peminjaman.id_peminjaman', 'left')
        ->join('denda', 'denda.id_pengembalian = pengembalian.id_pengembalian', 'left')

        ->groupBy('peminjaman.id_peminjaman');

    if ($role == 'anggota') {
        $builder->where('peminjaman.id_anggota', $id_anggota);
    }

    if ($keyword) {
        $builder->groupStart()
            ->like('anggota.nama', $keyword)
            ->orLike('peminjaman.id_peminjaman', $keyword)
            ->groupEnd();
    }

    return view('peminjaman/index', [
        'peminjaman' => $builder->findAll(),
        'keyword' => $keyword
    ]);
}
    // =====================
    // CREATE
    // =====================
    public function create()
    {
        if (session()->get('role') != 'anggota') {
            return redirect()->to(base_url('peminjaman'));
        }

        $bukuModel = new BukuModel();
        $usersModel = new UsersModel();
        $db = \Config\Database::connect();

        $kategori = $db->table('kategori')->get()->getResultArray();
        $id_kategori = $this->request->getGet('id_kategori');

        $bukuQuery = $bukuModel
            ->select('buku.*, penulis.nama_penulis')
            ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left');

        if ($id_kategori) {
            $bukuQuery->where('buku.id_kategori', $id_kategori);
        }

        $buku = $bukuQuery->findAll();
        $petugas = $usersModel->where('role', 'petugas')->findAll();

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

        return view('peminjaman/create', [
            'buku' => $buku,
            'cart' => $cart,
            'petugas' => $petugas,
            'kategori' => $kategori,
            'id_kategori' => $id_kategori
        ]);
    }

    // =====================
    // ADD CART
    // =====================
    public function addCart($id)
    {
        $cart = session()->get('cart') ?? [];
        $cart[$id] = isset($cart[$id]) ? $cart[$id] + 1 : 1;
        session()->set('cart', $cart);

        return redirect()->back();
    }

    public function removeCart($id)
    {
        $cart = session()->get('cart') ?? [];
        unset($cart[$id]);
        session()->set('cart', $cart);

        return redirect()->back();
    }

    // =====================
    // STORE (FIX FINAL)
    // =====================
    public function store()
{
    if (session()->get('role') != 'anggota') {
        return redirect()->back();
    }

    $peminjaman = new PeminjamanModel();
    $detail = new DetailPeminjamanModel();
    $bukuModel = new BukuModel();
    $db = \Config\Database::connect();

    $cart = session()->get('cart') ?? [];

    if (empty($cart)) {
        return redirect()->back()->with('error', 'Pilih buku dulu!');
    }

    $id_petugas = $this->request->getPost('id_petugas');

    if (!$id_petugas) {
        return redirect()->back()->with('error', 'Petugas wajib dipilih!');
    }

    // CEK LIMIT AMAN
    $builder = $db->table('detail_peminjaman');
    $builder->select('SUM(detail_peminjaman.jumlah) as total');
    $builder->join('peminjaman', 'peminjaman.id_peminjaman = detail_peminjaman.id_peminjaman');
    $builder->where('peminjaman.id_anggota', session()->get('id'));
    $builder->where('peminjaman.status', 'dipinjam');

    $totalLama = $builder->get()->getRowArray();
    $totalLama = $totalLama['total'] ?? 0;

    if (($totalLama + array_sum($cart)) > 2) {
        return redirect()->back()->with('error', 'Maksimal 2 buku');
    }

    $db->transBegin();

    try {

        $id = $peminjaman->insert([
            'id_anggota' => session()->get('id'),
            'id_petugas' => $id_petugas,
            'tanggal_pinjam' => date('Y-m-d'),
            'tanggal_kembali' => date('Y-m-d', strtotime('+7 days')),
            'status' => 'dipinjam'
        ]);

        foreach ($cart as $id_buku => $qty) {

            $b = $bukuModel->find($id_buku);

            if ($b) {
                $detail->insert([
                    'id_peminjaman' => $id,
                    'id_buku' => $id_buku,
                    'jumlah' => $qty
                ]);

                $bukuModel->update($id_buku, [
                    'tersedia' => $b['tersedia'] - $qty
                ]);
            }
        }

        $db->transCommit();
        session()->remove('cart');

        return redirect()->to(base_url('peminjaman'))
            ->with('success', 'Peminjaman berhasil');

    } catch (\Exception $e) {
        $db->transRollback();
        return redirect()->back()->with('error', $e->getMessage());
    }
}
     // =====================
    // DETAIL
    // =====================
   public function detail($id)
{
    $peminjamanModel = new PeminjamanModel();
    $detailModel = new DetailPeminjamanModel();

    $peminjaman = $peminjamanModel
        ->select('peminjaman.*,
                  anggota.nama as nama_anggota,
                  petugas.nama as nama_petugas')
        ->join('users as anggota', 'anggota.id = peminjaman.id_anggota', 'left')
        ->join('users as petugas', 'petugas.id = peminjaman.id_petugas', 'left')
        ->where('peminjaman.id_peminjaman', $id)
        ->first();

    // 🔥 DEBUG kalau data kosong
    if (!$peminjaman) {
        return redirect()->to(base_url('peminjaman'))
            ->with('error', 'Data peminjaman tidak ditemukan');
    }

    $detail = $detailModel
        ->select('detail_peminjaman.*, buku.judul')
        ->join('buku', 'buku.id_buku = detail_peminjaman.id_buku')
        ->where('detail_peminjaman.id_peminjaman', $id)
        ->findAll();

    return view('peminjaman/detail', [
        'peminjaman' => $peminjaman,
        'detail' => $detail
    ]);
}
// =====================
// PRINT STRUK
// =====================
public function print($id)
{
    $peminjamanModel = new PeminjamanModel();
    $detailModel = new DetailPeminjamanModel();

    $peminjaman = $peminjamanModel
        ->select('peminjaman.*,
                  anggota.nama as nama_anggota,
                  petugas.nama as nama_petugas')
        ->join('users as anggota', 'anggota.id = peminjaman.id_anggota', 'left')
        ->join('users as petugas', 'petugas.id = peminjaman.id_petugas', 'left')
        ->where('peminjaman.id_peminjaman', $id)
        ->first();

    if (!$peminjaman) {
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    $detail = $detailModel
        ->select('detail_peminjaman.*, buku.judul')
        ->join('buku', 'buku.id_buku = detail_peminjaman.id_buku')
        ->where('detail_peminjaman.id_peminjaman', $id)
        ->findAll();

    return view('peminjaman/print', [
        'peminjaman' => $peminjaman,
        'detail' => $detail
    ]);
}
// =====================
// PERPANJANG
// =====================
public function perpanjang($id)
{
    $model = new PeminjamanModel();

    $data = $model->find($id);

    // 🔥 cek data ada
    if (!$data) {
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    // 🔥 TIDAK BOLEH kalau sudah dikembalikan
    if ($data['status'] == 'dikembalikan') {
        return redirect()->back()->with('error', 'Buku sudah dikembalikan, tidak bisa diperpanjang');
    }

    // 🔥 BATAS PERPANJANG (max 2x)
    if ($data['perpanjang'] >= 2) {
        return redirect()->back()->with('error', 'Maksimal perpanjang 2 kali');
    }

    // 🔥 tambah 3 hari dari tanggal kembali lama
    $tanggalBaru = date('Y-m-d', strtotime($data['tanggal_kembali'] . ' +3 days'));

    $model->update($id, [
        'tanggal_kembali' => $tanggalBaru,
        'perpanjang' => $data['perpanjang'] + 1
    ]);

    return redirect()->back()->with('success', 'Berhasil diperpanjang 3 hari');
}
// =====================
// KIRIM WA
// =====================
// ================= WA PEMINJAMAN =================
public function wa($id)
{
    $model = new PeminjamanModel();

    $data = $model
        ->select('peminjaman.*, anggota.nama as nama_anggota, petugas.nama as nama_petugas, GROUP_CONCAT(buku.judul SEPARATOR ", ") as buku')
        ->join('users as anggota', 'anggota.id = peminjaman.id_anggota', 'left')
        ->join('users as petugas', 'petugas.id = peminjaman.id_petugas', 'left')
        ->join('detail_peminjaman', 'detail_peminjaman.id_peminjaman = peminjaman.id_peminjaman', 'left')
        ->join('buku', 'buku.id_buku = detail_peminjaman.id_buku', 'left')
        ->where('peminjaman.id_peminjaman', $id)
        ->groupBy('peminjaman.id_peminjaman')
        ->first();

    if (!$data) {
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    // 🔥 pesan WA
    $pesan = "📚 DATA PEMINJAMAN\n\n";
    $pesan .= "ID: " . $data['id_peminjaman'] . "\n";
    $pesan .= "Nama: " . $data['nama_anggota'] . "\n";
    $pesan .= "Petugas: " . $data['nama_petugas'] . "\n";
    $pesan .= "Buku: " . $data['buku'] . "\n";
    $pesan .= "Tanggal Pinjam: " . $data['tanggal_pinjam'] . "\n";
    $pesan .= "Tanggal Kembali: " . $data['tanggal_kembali'] . "\n";
    $pesan .= "Status: " . ucfirst($data['status']) . "\n";

   $url = "https://wa.me/6285175017991?text=" . urlencode($pesan);
return redirect()->to($url);
}
// =====================
// DELETE
// =====================
public function delete($id)
{
    $peminjaman = new PeminjamanModel();
    $detail = new DetailPeminjamanModel();
    $bukuModel = new BukuModel();
    $db = \Config\Database::connect();

    $db->transBegin();

    try {

        // 🔥 ambil detail dulu (untuk balikin stok buku)
        $details = $detail->where('id_peminjaman', $id)->findAll();

        foreach ($details as $d) {
            $buku = $bukuModel->find($d['id_buku']);

            if ($buku) {
                $bukuModel->update($d['id_buku'], [
                    'tersedia' => $buku['tersedia'] + $d['jumlah']
                ]);
            }
        }

        // 🔥 hapus detail dulu
        $detail->where('id_peminjaman', $id)->delete();

        // 🔥 baru hapus peminjaman
        $peminjaman->delete($id);

        $db->transCommit();

        return redirect()->to(base_url('peminjaman'))
            ->with('success', 'Data berhasil dihapus');

    } catch (\Exception $e) {
        $db->transRollback();
        return redirect()->back()->with('error', $e->getMessage());
    }
}
}
   
