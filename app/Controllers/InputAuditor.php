<?php
namespace App\Controllers;

class InputAuditor extends BaseController
{
  public function index()
  {
    $data["title"] = "Auditor";
    echo view('layouts/header.php', $data);
    echo view('input_auditor/form.php');
    echo view('layouts/footer.php');
  }

}
?>