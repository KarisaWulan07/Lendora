<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{
    protected $users;

    public function __construct()
    {
        $this->users = new UsersModel();
    }

    // ================= SECURITY =================
    private function checkAdmin()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/login')->send();
            exit;
        }
    }

    public function create()
    {
        $this->checkAdmin();
        return view('users/create');
    }

    // ================= STORE =================
    public function store()
    {
        $this->checkAdmin();

        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama'     => 'required',
            'email'    => 'required|valid_email',
            'username' => 'required|is_unique[users.username]',
            'password' => 'required|min_length[4]',
            'role'     => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('error', implode('<br>', $validation->getErrors()));
        }

        // ================= FOTO =================
        $foto = $this->request->getFile('foto');
        $namaFoto = null;

        $folder = FCPATH . 'uploads/users';
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move($folder, $namaFoto);
        }

        // ================= SIMPAN USER =================
        $this->users->save([
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
            'foto'     => $namaFoto
        ]);

        $db = \Config\Database::connect();
        $id_user = $this->users->getInsertID();
        $role = $this->request->getPost('role');

        // ================= RELASI =================
        if ($role == 'anggota') {
            $db->table('anggota')->insert([
                'user_id' => $id_user,
                'nis' => null,
                'alamat' => null,
                'no_hp' => null,
                'tanggal_daftar' => date('Y-m-d')
            ]);
        }

        if ($role == 'petugas') {
            $db->table('petugas')->insert([
                'user_id' => $id_user,
                'jabatan' => null
            ]);
        }

        return redirect()->to('/users')->with('success', 'User berhasil ditambahkan!');
    }

    // ================= INDEX =================
    public function index()
    {
        $this->checkAdmin();

        $keyword = $this->request->getGet('keyword');
        $role = $this->request->getGet('role');

        $builder = $this->users;

        if ($keyword) {
            $builder = $builder->like('nama', $keyword);
        }

        if ($role) {
            $builder = $builder->where('role', $role);
        }

        $data['users'] = $builder->paginate(10);
        $data['pager'] = $this->users->pager;

        return view('users/index', $data);
    }

    // ================= EDIT =================
public function edit($id = null)
{
    if ($id == null) {
        return redirect()->to('/users');
    }

    $data['user'] = $this->users->find($id);

    if (!$data['user']) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User tidak ditemukan");
    }

    return view('users/edit', $data);
}
    // ================= UPDATE =================
    public function update($id)
    {
        $this->checkAdmin();

        $user = $this->users->find($id);
        $fotoBaru = $this->request->getFile('foto');
        $namaFoto = $user['foto'];

        if ($fotoBaru && $fotoBaru->isValid() && $fotoBaru->getName() != '') {

            if (!empty($user['foto']) && file_exists(FCPATH . 'uploads/users/' . $user['foto'])) {
                unlink(FCPATH . 'uploads/users/' . $user['foto']);
            }

            $namaFoto = $fotoBaru->getRandomName();
            $fotoBaru->move(FCPATH . 'uploads/users', $namaFoto);
        }

        $data = [
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'role'     => $this->request->getPost('role'),
            'foto'     => $namaFoto
        ];

        if ($this->request->getPost('password') != "") {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->users->update($id, $data);

        return redirect()->to('/users')->with('success', 'Data user berhasil diupdate!');
    }

    // ================= DELETE =================
    public function delete($id)
    {
        $this->checkAdmin();

        $user = $this->users->find($id);

        if (!empty($user['foto']) && file_exists(FCPATH . 'uploads/users/' . $user['foto'])) {
            unlink(FCPATH . 'uploads/users/' . $user['foto']);
        }

        $this->users->delete($id);

        return redirect()->to('/users')->with('success', 'User berhasil dihapus!');
    }

    // ================= DETAIL =================
    public function detail($id)
    {
        $this->checkAdmin();

        $user = $this->users->find($id);

        if (!$user) {
            return redirect()->to('/users')->with('error', 'Data tidak ditemukan');
        }

        return view('users/detail', ['user' => $user]);
    }

    // ================= PRINT =================
    public function print()
    {
        $keyword = $this->request->getGet('keyword');
        $role = $this->request->getGet('role');

        $builder = $this->users;

        if ($keyword) {
            $builder = $builder->like('nama', $keyword);
        }

        if ($role) {
            $builder = $builder->where('role', $role);
        }

        $data['users'] = $builder->findAll();

        return view('users/print', $data);
    }

    // ================= WA =================
    public function wa($id)
    {
        $user = $this->users->find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $pesan = "DATA USER\n\n";
        $pesan .= "ID: " . $user['id'] . "\n";
        $pesan .= "Nama: " . $user['nama'] . "\n";
        $pesan .= "Email: " . $user['email'] . "\n";
        $pesan .= "Username: " . $user['username'] . "\n";
        $pesan .= "Role: " . ucfirst($user['role']) . "\n";

        $url = "https://wa.me/6285175017991?text=" . urlencode($pesan);

        return redirect()->to($url);
    }

}