<?php
namespace App\Controllers;

use App\Models\UnitModel;

class Unit extends BaseController
{
    public function index()
    {
        $model = new UnitModel();

        // Hapus data
        if ($this->request->getGet('delete')) {
            $id = $this->request->getGet('delete');
            $model->delete($id);
            session()->setFlashdata('success', 'Data unit berhasil dihapus!');
            return redirect()->to(base_url('public/akreditasi/unit'));
        }

        // Ambil data untuk edit
        $editData = null;
        if ($this->request->getGet('edit')) {
            $id = $this->request->getGet('edit');
            $editData = $model->find($id);
        }

        // Simpan (create / update)
        if ($this->request->getMethod() == 'POST') {
            $id = $this->request->getPost('id');
            $nama = $this->request->getPost('nama');
            $parent = $this->request->getPost('parent');

            if (empty($nama) || empty($parent)) {
                session()->setFlashdata('error', 'Nama Unit dan Parent wajib diisi!');
            } else {
                $data = [
                    'nama' => $nama,
                    'parent' => (int)$parent,
                ];

                if ($id) {
                    $model->update($id, $data);
                    session()->setFlashdata('success', 'Data unit berhasil diperbarui!');
                } else {
                    $model->save($data);
                    session()->setFlashdata('success', 'Data unit berhasil disimpan!');
                }

                return redirect()->to(base_url('public/akreditasi/unit'));
        }
    }

    // Ambil data periode yang ada untuk ditampilkan
    $data['title'] = 'Manajemen Unit';
    $data['unit'] = $model->findAll();
    $data['edit'] = $editData;  // Perbaiki di sini

    // Tampilkan form dan data di view yang sama
    echo view('layouts/header.php', $data);
    echo view('akreditasi/unit/form.php');
    echo view('layouts/footer.php');
    }

}
?>