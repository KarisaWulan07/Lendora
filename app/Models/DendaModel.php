<?php

namespace App\Models;

use CodeIgniter\Model;

class DendaModel extends Model
{
    protected $table = 'denda';
    protected $primaryKey = 'id_denda';

  protected $allowedFields = [
    'id_pengembalian',
    'jumlah_denda',
    'status_denda',
    'metode_pembayaran',
    'bukti_pembayaran',
    'id_petugas_verif',   // 🔥 TAMBAH
    'tanggal_verifikasi'  // 🔥 TAMBAH
];
public function getDenda()
{
    return $this->db->table('denda')
        ->select('denda.*, user.nama as nama_petugas_verif')
        ->join('petugas', 'petugas.user_id = denda.id_petugas_verif', 'left')
        ->join('user', 'user.id_user = petugas.user_id', 'left')
        ->get()
        ->getResultArray();
}
}