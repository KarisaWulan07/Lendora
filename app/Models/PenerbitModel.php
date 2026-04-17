<?php

namespace App\Models;

use CodeIgniter\Model;

class PenerbitModel extends Model
{
    protected $table = 'penerbit';
    protected $primaryKey = 'id_penerbit';

    protected $allowedFields = [
        'nama_penerbit',
        'alamat'
    ];

    protected $useTimestamps = false;

    // Ambil semua penerbit
    public function getAll()
    {
        return $this->orderBy('nama_penerbit', 'ASC')->findAll();
    }

    // Ambil 1 penerbit
    public function getById($id)
    {
        return $this->where('id_penerbit', $id)->first();
    }

    // Cek dipakai di buku
    public function isUsed($id)
    {
        return $this->db->table('buku')
            ->where('id_penerbit', $id)
            ->countAllResults() > 0;
    }
}