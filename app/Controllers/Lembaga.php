<?php
namespace App\Controllers;

use App\Models\LembagaModel;

class Lembaga extends BaseController
{
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
            "lembaga" => $model->findAll(),
            "editData" => $dataEdit,
        ];

        echo view('layouts/header.php', $data);
        echo view('akreditasi/lembaga/form.php', $data);
        echo view('layouts/footer.php');
    }
}
