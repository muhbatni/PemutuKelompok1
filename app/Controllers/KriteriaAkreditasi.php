<?php
namespace App\Controllers;

use App\Models\InstrumenPemutuModel;
use App\Models\KriteriaAkreditasiModel;
use App\Models\LembagaAkreditasiModel;

class KriteriaAkreditasi extends BaseController
{
    public function index()
    {      

        $kriteriaModel = new KriteriaAkreditasiModel();
        $lembagaModel = new LembagaAkreditasiModel();

        $data['lembagas'] = $lembagaModel->getLembagas();
        $data['kriteria'] = $kriteriaModel->getKriteriaWithLembaga();
      
        // Proses hapus
        if ($this->request->getPost('id_delete')) {
            $idDelete = $this->request->getPost('id_delete');
            $kriteriaModel->delete($idDelete);
            session()->setFlashdata('success', 'Data berhasil dihapus');
            return redirect()->to(base_url('public/akreditasi/kriteria'));
        }

        // Proses edit / tambah
        $data['isEdit'] = false;
        $data['edit'] = [];
        $data['title'] = 'Kriteria Akreditasi';

        if ($this->request->getGet('edit')) {
            $data['isEdit'] = true;
            $data['edit'] = $kriteriaModel->find($this->request->getGet('edit'));
        }

        if ($this->request->getMethod() == 'POST' && !$this->request->getPost('id_delete')) {
            $id = $this->request->getPost('id');
            $saveData = [
                'id_lembaga' => $this->request->getPost('id_lembaga'),
                'kode' => $this->request->getPost('kode'),
                'nama' => $this->request->getPost('nama'),
            ];

            if ($id) {
                $saveData['id'] = $id;
            }

            $kriteriaModel->save($saveData);
            session()->setFlashdata('success', $id ? 'Berhasil diperbarui!' : 'Berhasil disimpan!');
            return redirect()->to(base_url('public/akreditasi/kriteria'));
        }

        
        echo view('layouts/header.php', $data);
        echo view('akreditasi/kriteria_akreditasi/form', $data);
        echo view('layouts/footer.php');
    }
}
