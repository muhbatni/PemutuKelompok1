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

    // $data["title"] = "Standar Audit";
    echo view('layouts/header.php', $data);
    echo view('audit/standar_audit/tables.php', $data);
    echo view('layouts/footer.php');

  }

}
?>