<?php
namespace App\Controllers;
use App\Models\LembagaAkreditasiModel;
use App\Models\SyaratUnggulModel;

class SyaratUnggul extends BaseController
{
    public function input() {
        $lembagaModel = new LembagaAkreditasiModel();
        $data['lembagas'] = $lembagaModel->getLembagas();

        $syaratUnggulModel = new SyaratUnggulModel();
        $data['dataSyarat'] = $syaratUnggulModel->getSyaratData();

        $editData = null;
        $id = $this->request->getGet('id');
        if ($id) {
            $editData = $syaratUnggulModel->find($id);
            $data['editData'] = $editData;
        }

        if ($this->request->getMethod() == 'POST') {
            $id = $this->request->getPost('id');
            $dataForm = [
                'id_lembaga' => $this->request->getPost('id_lembaga'),
                'nama' => $this->request->getPost('nama'),
            ];

            if ($id) {
                $syaratUnggulModel->update($id, $dataForm);
                session()->setFlashdata('success', 'Data berhasil diperbarui!');
            } else {
                $syaratUnggulModel->insert($dataForm);
                session()->setFlashdata('success', 'Data berhasil disimpan!');
            }

            return redirect()->to(base_url('public/akreditasi/syarat-unggul'));
        }

        // Ambil id_lembaga dari query string hanya jika bukan edit
        $data['selected_lembaga'] = !$id ? $this->request->getGet('id_lembaga') : null;
        $data['isEdit'] = $id ? true : false;
        $data["title"] = "Data Syarat Unggul";

        echo view('layouts/header.php', $data);
        echo view('akreditasi/syarat_unggul/form.php', $data);
        echo view('layouts/footer.php');
    }

  public function index()
  {
    //ambil data m_lembaga_akreditasi
    $lembagaModel = new LembagaAkreditasiModel();
    $data['lembagas'] = $lembagaModel->getLembagas();

    // Ambil data p_syarat_unggul
    $syaratUnggulModel = new SyaratUnggulModel();
    $data['dataSyarat'] = $syaratUnggulModel->getSyaratData();

    // Check for 'GET' method for deleting a syarat unggul
    if ($this->request->getGet('delete')) {
        $id = $this->request->getGet('delete');
        $deleteResult = $syaratUnggulModel->delete($id);

        if ($deleteResult) {
            session()->setFlashdata('success', 'Data berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Terjadi kesalahan saat menghapus data!');
        }

        return redirect()->to(base_url('public/akreditasi/syarat-unggul'));
    }

    $data["title"] = "Syarat Unggul";
    echo view('layouts/header.php', $data);
    echo view('akreditasi/syarat_unggul/tables.php');
    echo view('layouts/footer.php');
  }

}
?>