<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\PeminjamanModel;
use App\Models\PengembalianModel;
use App\Models\DendaModel;
use App\Models\RakModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $bukuModel = new BukuModel();
        $pinjamModel = new PeminjamanModel();
        $kembaliModel = new PengembalianModel();
        $dendaModel = new DendaModel();
        $rakModel = new RakModel();

        $data = [

            /* =========================
             * 📊 STATISTIK (URUT LOGIS)
             * ========================= */
            'total_buku' => $bukuModel->countAll(),
            'total_rak' => $rakModel->countAll(),

            'total_dipinjam' => $pinjamModel
                ->where('status', 'dipinjam')
                ->countAllResults(),

            'total_terlambat' => $pinjamModel
                ->where('status', 'terlambat')
                ->countAllResults(),

            'total_denda' => $dendaModel
                ->where('status_denda', 'belum')
                ->selectSum('jumlah_denda')
                ->first()['jumlah_denda'] ?? 0,

            /* =========================
             * 🔔 OVERDUE (PRIORITAS TINGGI)
             * ========================= */
            'overdue' => $pinjamModel
                ->where('tanggal_kembali <', date('Y-m-d'))
                ->where('status', 'dipinjam')
                ->findAll(5),

            /* =========================
             * 📅 AKTIVITAS TERBARU
             * ========================= */
            'aktivitas' => $pinjamModel
                ->orderBy('id_peminjaman', 'DESC')
                ->findAll(5),

            /* =========================
             * 👤 USER LOGIN
             * ========================= */
            'user' => [
                'nama' => session()->get('nama'),
                'role' => session()->get('role')
            ]
        ];

        return view('dashboard/index', $data);
    }
}