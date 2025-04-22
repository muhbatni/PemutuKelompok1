<?php
namespace App\Controllers;

class Auditor extends BaseController
{
  public function index()
  {
    $data["title"] = "Auditor";
    echo view('layouts/header.php', $data);
    echo view('audit/input_auditor/tables.php');
    echo view('layouts/footer.php');

  }

}
?>