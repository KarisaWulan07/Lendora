<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\RakModel;
use App\Models\PeminjamanModel;
use App\Models\DendaModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $bukuModel   = new BukuModel();
        $rakModel    = new RakModel();
        $pinjamModel = new PeminjamanModel();
        $dendaModel  = new DendaModel();

        $today = date('Y-m-d');

        // =====================
        // STATISTIK
        // =====================
        $total_buku = $bukuModel->countAll();
        $total_rak  = $rakModel->countAll();

        $dipinjam = $pinjamModel
            ->where('status', 'dipinjam')
            ->countAllResults();

        $terlambat = $pinjamModel
            ->where('status', 'dipinjam')
            ->where('tanggal_kembali <', $today)
            ->countAllResults();

        $dendaData = $dendaModel->selectSum('jumlah')->first();
        $total_denda = $dendaData['jumlah'] ?? 0;

        // reset model biar aman
        $pinjamModel = new PeminjamanModel();

        // =====================
        // AKTIVITAS PEMINJAMAN (BARU PINJAM)
        // =====================
        $aktivitas_pinjam = $pinjamModel
            ->select('peminjaman.*, anggota.nama, buku.judul')
            ->join('anggota', 'anggota.id = peminjaman.id_anggota', 'left')
            ->join('buku', 'buku.id = peminjaman.id_buku', 'left')
            ->orderBy('peminjaman.id_peminjaman', 'DESC')
            ->limit(5)
            ->findAll();

        // =====================
        // OVERDUE
        // =====================
        $overdue = $pinjamModel
            ->where('status', 'dipinjam')
            ->where('tanggal_kembali <', $today)
            ->findAll();

        return view('dashboard/index', [
            'total_buku'       => $total_buku,
            'total_rak'        => $total_rak,
            'dipinjam'         => $dipinjam,
            'terlambat'        => $terlambat,
            'total_denda'      => $total_denda,
            'aktivitas_pinjam' => $aktivitas_pinjam,
            'overdue'          => $overdue
        ]);
    }
}