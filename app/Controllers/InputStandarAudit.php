<?php
namespace App\Controllers;

class InputStandarAudit extends BaseController
{
  public function index()
  {
    $data["title"] = "Input Standar Audit";
    echo view('layouts/header.php', $data);
    echo view('audit/standar_audit/form.php');
    echo view('layouts/footer.php');

  }

}
?>