<?php
namespace App\Controllers;

use App\Models\InstrumenPemutuModel;
use App\Models\LembagaAkreditasiModel;

class InstrumenPemutu extends BaseController
{
    public function index()
    {
        $instrumenModel = new InstrumenPemutuModel();
        $lembagaModel = new LembagaAkreditasiModel();

        $data['lembagas'] = $lembagaModel->getLembagas();
        $data['instrumen_pemutu'] = $instrumenModel->getInstrumenWithLembaga();

        foreach ($data['instrumen_pemutu'] as &$row) {
          $row['jenjang_text'] = $instrumenModel->getJenjangText($row['jenjang']);
      }
      
      echo view('akreditasi/instrumen_pemutu/index', $data);
      
        // Proses hapus
        if ($this->request->getPost('id_delete')) {
            $idDelete = $this->request->getPost('id_delete');
            $instrumenModel->delete($idDelete);
            session()->setFlashdata('success', 'Data berhasil dihapus');
            return redirect()->to(base_url('public/akreditasi/instrumen-pemutu'));
        }

        // Proses edit / tambah
        $data['isEdit'] = false;
        $data['edit'] = [];
        $data['title'] = 'Instrumen Pemutu';

        if ($this->request->getGet('edit')) {
            $data['isEdit'] = true;
            $data['edit'] = $instrumenModel->find($this->request->getGet('edit'));
        }

        if ($this->request->getMethod() == 'POST' && !$this->request->getPost('id_delete')) {
            $id = $this->request->getPost('id');
            $saveData = [
                'id_lembaga' => $this->request->getPost('id_lembaga'),
                'jenjang' => $this->request->getPost('jenjang'),
                'indikator' => $this->request->getPost('indikator'),
                'kondisi' => $this->request->getPost('kondisi'),
                'batas' => $this->request->getPost('batas'),
            ];

            if (!is_numeric($saveData['batas'])) {
                return redirect()->back()->withInput()->with('error', 'Batas harus berupa angka.');
            }

            if ($id) {
                $saveData['id'] = $id;
            }

            $instrumenModel->save($saveData);
            session()->setFlashdata('success', $id ? 'Berhasil diperbarui!' : 'Berhasil disimpan!');
            return redirect()->to(base_url('public/akreditasi/instrumen-pemutu'));
        }

        
        echo view('layouts/header.php', $data);
        echo view('akreditasi/instrumen_pemutu/form.php');
        echo view('layouts/footer.php');
    }
}
