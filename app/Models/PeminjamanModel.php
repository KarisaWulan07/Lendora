<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table      = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';

    protected $allowedFields = [
        'id_anggota',
        'id_petugas',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'metode',
        'perpanjang'
        
    ];

    // OPTIONAL (kalau tabel kamu punya created_at / updated_at)
    protected $useTimestamps = false;

    // supaya insert() balik ID lebih stabil
    protected $returnType = 'array';
    public function getPeminjaman()
{
    return $this->db->table('peminjaman')
        ->select('
            peminjaman.*,
            anggota.nama AS nama_anggota,
            user.nama AS nama_petugas
        ')
        ->join('anggota', 'anggota.id = peminjaman.id_anggota', 'left')
        ->join('user', 'user.id_user = peminjaman.id_petugas', 'left')
        ->get()
        ->getResultArray();
}
}