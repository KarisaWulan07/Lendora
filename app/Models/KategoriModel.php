<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';

    protected $allowedFields = ['nama_kategori'];

    protected $useTimestamps = false;

    // Ambil semua kategori (untuk dropdown)
    public function getAll()
    {
        return $this->orderBy('nama_kategori', 'ASC')->findAll();
    }

    // Ambil 1 kategori
    public function getById($id)
    {
        return $this->where('id_kategori', $id)->first();
    }

    // Cek apakah kategori sudah dipakai di buku
    public function isUsed($id)
    {
        return $this->db->table('buku')
            ->where('id_kategori', $id)
            ->countAllResults() > 0;
    }
}