<?php
namespace App\Controllers;

class PelaksanaanAudit extends BaseController
{
  public function index()
  {
    $data["title"] = "Pelaksanaan Audit";
    echo view('layouts/header.php', $data);
    echo view('audit/pelaksanaan_audit/tables.php');
    echo view('layouts/footer.php');
  }

}
?>