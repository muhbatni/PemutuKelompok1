<?php
namespace App\Controllers;

use App\Models\StandarModel; 

class StandarAudit extends BaseController
{
  public function index()
  {

  $model = new StandarModel();
  $data["title"] = "Standar Audit";
  $data["standar"] = $model->findAll(); // ambil data dari DB

      // hapus data 
  if ($this->request->getGet('delete')) {
    $id = $this->request->getGet('delete');
    $model->delete($id);
    session()->setFlashdata('success', 'Data input standar berhasil dihapus!');
    return redirect()->to(base_url('public/audit/standar'));
  }
    echo view('layouts/header.php', $data);
    echo view('audit/standar_audit/tables.php', $data);
    echo view('layouts/footer.php');

  }
}
?>