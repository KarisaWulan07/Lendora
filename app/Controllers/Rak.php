<?php

namespace App\Controllers;

use App\Models\RakModel;

class Rak extends BaseController
{
    protected $rakModel;

    public function __construct()
    {
        $this->rakModel = new RakModel();
    }

    // LIST + SEARCH
    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        $builder = $this->rakModel;

        if ($keyword) {
            $builder = $builder->like('nama_rak', $keyword)
                               ->orLike('lokasi', $keyword);
        }

        $data = [
            'rak' => $builder->findAll()
        ];

        return view('rak/index', $data);
    }

    // CREATE FORM
    public function create()
    {
        return view('rak/create');
    }

    // STORE
    public function store()
    {
        $this->rakModel->save([
            'nama_rak' => $this->request->getPost('nama_rak'),
            'lokasi'   => $this->request->getPost('lokasi'),
        ]);

        return redirect()->to('/rak');
    }

    // EDIT FORM
    public function edit($id)
    {
        $data = [
            'rak' => $this->rakModel->find($id)
        ];

        return view('rak/edit', $data);
    }

    // UPDATE
    public function update($id)
    {
        $this->rakModel->update($id, [
            'nama_rak' => $this->request->getPost('nama_rak'),
            'lokasi'   => $this->request->getPost('lokasi'),
        ]);

        return redirect()->to('/rak');
    }

    // DELETE
    public function delete($id)
    {
        $this->rakModel->delete($id);
        return redirect()->to('/rak');
    }
}