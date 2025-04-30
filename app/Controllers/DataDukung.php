<?php
namespace App\Controllers;

use App\Models\DataDukungModel;

class DataDukung extends BaseController
{
  public function index()
    {
        $model = new DataDukungModel();
        $data = [
            "title" => "Data Dukung",
            "dataDukung" => $model->getDataDukung()
        ];

        if ($this->request->getGet('delete')) {
          $id = $this->request->getGet('delete');
          $model->delete($id);
          session()->setFlashdata('success', 'Data berhasil dihapus!');
          return redirect()->to(base_url('public/audit/data-dukung'));
      }
        
    echo view('layouts/header.php', $data);
    echo view('audit/data_dukung/tables.php', $data);
    echo view('layouts/footer.php');
  }
  
}
?>