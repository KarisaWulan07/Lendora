<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function prosesLogin()
    {
        $session = session();
        $model = new UsersModel();

        $user = $model->getUsersByUsername($this->request->getPost('username'));

        if (!$user) {
            return redirect()->to('/login')->with('error', 'User tidak ditemukan');
        }

        if (!password_verify($this->request->getPost('password'), $user['password'])) {
            return redirect()->to('/login')->with('error', 'Password salah');
        }

        $session->set([
            'id' => $user['id'],
            'nama' => $user['nama'],
            'role' => $user['role'],
            'foto' => $user['foto'],
            'logged_in' => true
        ]);

        return redirect()->to('/dashboard');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function prosesRegister()
    {
        $users = new UsersModel();
        $db = \Config\Database::connect();

        $role = $this->request->getPost('role');

        $users->save([
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $role,
            'status' => 'aktif'
        ]);

        $id_user = $users->getInsertID();

        if ($role == 'anggota') {
            $db->table('anggota')->insert([
                'user_id' => $id_user,
                'nis' => $this->request->getPost('nis'),
                'alamat' => $this->request->getPost('alamat'),
                'no_hp' => $this->request->getPost('no_hp'),
                'tanggal_daftar' => date('Y-m-d')
            ]);
        }

        if ($role == 'petugas') {
            $db->table('petugas')->insert([
                'user_id' => $id_user,
                'jabatan' => $this->request->getPost('jabatan')
            ]);
        }

        return redirect()->to('/login')->with('success', 'Register berhasil, silakan login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}