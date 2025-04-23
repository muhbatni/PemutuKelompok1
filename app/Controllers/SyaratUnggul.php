<?php
namespace App\Controllers;
use App\Models\LembagaAkreditasiModel;
use App\Models\SyaratUnggulModel;

class SyaratUnggul extends BaseController
{
  public function index()
  {
    //ambil data m_lembaga_akreditasi
    $lembagaModel = new LembagaAkreditasiModel();
    $data['lembagas'] = $lembagaModel->getLembagas();

    // Ambil data p_syarat_unggul
    $syaratUnggulModel = new SyaratUnggulModel();
    $data['dataSyarat'] = $syaratUnggulModel->getSyaratData();

    $editData = null;
    if ($this->request->getGet('id')) {
        $id = $this->request->getGet('id');
        // Get the data for the specified ID
        $editData = $syaratUnggulModel->find($id);
        $data['editData'] = $editData;
    }

    if ($this->request->getMethod() == 'POST') {
        $dataForm = [
            'id_lembaga' => $this->request->getPost('id_lembaga'),
            'nama' => $this->request->getPost('nama'),
        ];

        // Cek jika ada ID di POST, berarti edit data
        if ($this->request->getPost('id')) {
          $id = $this->request->getPost('id');
          // Update data jika ada ID
          $syaratUnggulModel->update($id, $dataForm);
          session()->setFlashdata('success', 'Data berhasil diperbarui!');
      } else {
          // Insert data jika tidak ada ID
          $syaratUnggulModel->insert($dataForm);
          session()->setFlashdata('success', 'Data berhasil disimpan!');
      }

        return redirect()->to(base_url('public/akreditasi/syarat-unggul'));
    }

    // Check for 'GET' method for deleting a syarat unggul
    if ($this->request->getGet('action') == 'delete' && $this->request->getGet('id')) {
        $id = $this->request->getGet('id');
        $deleteResult = $syaratUnggulModel->delete($id);

        if ($deleteResult) {
            session()->setFlashdata('success', 'Syarat Unggul berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Terjadi kesalahan saat menghapus data!');
        }

        return redirect()->to(base_url('public/akreditasi/syarat-unggul'));
    }

    $data["title"] = "Syarat Unggul";
    echo view('layouts/header.php', $data);
    echo view('akreditasi/syarat_unggul/form.php');
    echo view('layouts/footer.php');
  }

}
?>