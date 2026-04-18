<?php

namespace App\Controllers;

use App\Models\PenerbitModel;

class Penerbit extends BaseController
{
    protected $penerbit;

    public function __construct()
    {
        $this->penerbit = new PenerbitModel();
    }

    public function index()
    {
        $data = [
            'penerbit' => $this->penerbit->findAll()
        ];

        return view('penerbit/index', $data);
    }

    public function create()
    {
        return view('penerbit/create');
    }

    public function store()
    {
        $this->penerbit->save([
            'nama_penerbit' => $this->request->getPost('nama_penerbit'),
            'alamat'        => $this->request->getPost('alamat')
        ]);

        return redirect()->to('/penerbit');
    }

    public function edit($id)
    {
        $data = [
            'penerbit' => $this->penerbit->find($id)
        ];

        return view('penerbit/edit', $data);
    }

    public function update($id)
    {
        $this->penerbit->update($id, [
            'nama_penerbit' => $this->request->getPost('nama_penerbit'),
            'alamat'        => $this->request->getPost('alamat')
        ]);

        return redirect()->to('/penerbit');
    }

    public function delete($id)
    {
        $this->penerbit->delete($id);
        return redirect()->to('/penerbit');
    }
}