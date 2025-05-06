<?php
namespace App\Controllers;

use App\Models\LembagaModel;

class Lembaga extends BaseController
{

    protected $lembagaModel;

    public function __construct()
    {
        $this->lembagaModel = new LembagaModel();
    }

    public function input()
    {
        $model = new LembagaModel();
        $id = $this->request->getGet('id');
        $editData = null;
    
        // Ambil data jika mode edit
        if ($id) {
            $editData = $model->find($id);
            if (!$editData) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
            }
        }
    
        // Jika form disubmit
        if ($this->request->getMethod() === 'post') {
            $data = [
                'nama'      => $this->request->getPost('nama'),
                'deskripsi' => $this->request->getPost('deskripsi'),
            ];
    
            if ($this->request->getPost('id')) {
                $model->update($this->request->getPost('id'), $data);
                session()->setFlashdata('success', 'Data berhasil diperbarui.');
            } else {
                $model->save($data);
                session()->setFlashdata('success', 'Data berhasil ditambahkan.');
            }
    
            return redirect()->to(base_url('akreditasi/lembaga'));
        }
    
        // Tampilkan form
        $data = [
            'title'     => $id ? 'Edit Lembaga Akreditasi' : 'Tambah Lembaga Akreditasi',
            'editData'  => $editData, // INI YANG DIBUTUHKAN OLEH VIEW
        ];
    
        echo view('layouts/header', $data);
        echo view('akreditasi/lembaga/form', $data);
        echo view('layouts/footer');
    }    
    
    public function index()
    {
        $model = new LembagaModel();
        $idEdit = $this->request->getGet('edit');
        $dataEdit = null;

        // Proses simpan / update
        if ($this->request->getMethod() === 'POST') {
            $id = $this->request->getPost('id');

            $dataInput = [
                'nama' => $this->request->getPost('nama'),
                'deskripsi' => $this->request->getPost('deskripsi'),
            ];

            if ($id) {
                $model->update($id, $dataInput);
                session()->setFlashdata('success', 'Data berhasil diperbarui!');
            } else {
                $model->save($dataInput);
                session()->setFlashdata('success', 'Data berhasil disimpan!');
            }

            return redirect()->to(base_url('public/akreditasi/lembaga'));
        }

        // Proses hapus
        if ($this->request->getGet('delete')) {
            $model->delete($this->request->getGet('delete'));
            session()->setFlashdata('success', 'Data berhasil dihapus!');
            return redirect()->to(base_url('public/akreditasi/lembaga'));
        }

        // Ambil data untuk form edit jika ada
        if ($idEdit) {
            $dataEdit = $model->find($idEdit);
        }

        $data = [
            "title" => "Formulir Lembaga Akreditasi",
            "lembaga" => $model->orderBy('id','ASC')->findAll(),
            "editData" => $dataEdit,
        ];

        echo view('layouts/header.php', $data);
        echo view('akreditasi/lembaga/tables.php', $data);
        echo view('layouts/footer.php');
    }
}
