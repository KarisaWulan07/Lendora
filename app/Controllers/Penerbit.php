<?php

namespace App\Controllers;

use App\Models\PenerbitModel;

class Penerbit extends BaseController
{
    protected $penerbitModel;

    public function __construct()
    {
        $this->penerbitModel = new PenerbitModel();
    }

    // READ + SEARCH
    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $data['penerbit'] = $this->penerbitModel
                ->like('nama_penerbit', $keyword)
                ->orLike('alamat', $keyword)
                ->findAll();
        } else {
            $data['penerbit'] = $this->penerbitModel->findAll();
        }

        return view('penerbit/index', $data);
    }

    // CREATE FORM
    public function create()
    {
        return view('penerbit/create');
    }

    // STORE
    public function store()
    {
        $this->penerbitModel->save([
            'nama_penerbit' => $this->request->getPost('nama_penerbit'),
            'alamat'        => $this->request->getPost('alamat'),
        ]);

        return redirect()->to(base_url('penerbit'));
    }

    // EDIT FORM
    public function edit($id)
    {
        $data['penerbit'] = $this->penerbitModel->find($id);
        return view('penerbit/edit', $data);
    }

    // UPDATE
    public function update($id)
    {
        $this->penerbitModel->update($id, [
            'nama_penerbit' => $this->request->getPost('nama_penerbit'),
            'alamat'        => $this->request->getPost('alamat'),
        ]);

        return redirect()->to(base_url('penerbit'));
    }

    // DELETE
    public function delete($id)
    {
        $this->penerbitModel->delete($id);
        return redirect()->to(base_url('penerbit'));
    }
}