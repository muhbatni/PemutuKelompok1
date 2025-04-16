<?php
namespace App\Controllers;

class InputPelaksanaanAudit extends BaseController
{
  public function index()
  {
    $data["title"] = "Input Pelaksanaan Audit";
    echo view('layouts/header.php', $data);
    echo view('pelaksanaan_audit/form.php');
    echo view('layouts/footer.php');
  }

}
?>