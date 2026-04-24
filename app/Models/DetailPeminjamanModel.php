<?php

namespace App\Models;
use CodeIgniter\Model;

class DetailPeminjamanModel extends Model
{
    protected $table = 'detail_peminjaman';
    protected $primaryKey = 'id_detail';

    protected $allowedFields = [
        'id_peminjaman',
        'id_buku',
        'jumlah'
    ];

    public function searchByBuku($keyword)
    {
        return $this->select('detail_peminjaman.*, buku.judul_buku')
            ->join('buku', 'buku.id_buku = detail_peminjaman.id_buku')
            ->like('buku.judul_buku', $keyword)
            ->findAll();
    }
}