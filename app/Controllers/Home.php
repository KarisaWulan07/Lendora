<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\RakModel;
use App\Models\PeminjamanModel;
use App\Models\DendaModel;

class Home extends BaseController
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

        $dipinjam = $pinjamModel->where('status', 'dipinjam')->countAllResults();

        $terlambat = $pinjamModel
            ->where('status', 'dipinjam')
            ->where('tanggal_kembali <', $today)
            ->countAllResults();

        // FIX DENDANYA
        $total_denda = $dendaModel
            ->selectSum('jumlah_denda')
            ->first()['jumlah_denda'] ?? 0;

        // reset model biar aman
        $pinjamModel = new PeminjamanModel();

        // =====================
        // AKTIVITAS PINJAM (FIX JOIN)
        // =====================
        $aktivitas_pinjam = $pinjamModel
            ->select('peminjaman.id_peminjaman, peminjaman.tanggal_pinjam, peminjaman.status, peminjaman.id_anggota')
            ->orderBy('id_peminjaman', 'DESC')
            ->limit(5)
            ->findAll();

        // =====================
        // OVERDUE (FIX SEDERHANA TANPA JOIN ERROR)
        // =====================
        $overdue = $pinjamModel
            ->where('status', 'dipinjam')
            ->where('tanggal_kembali <', $today)
            ->orderBy('id_peminjaman', 'DESC')
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