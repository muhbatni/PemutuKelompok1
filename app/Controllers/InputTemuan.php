<?php
namespace App\Controllers;

class InputTemuan extends BaseController
{
  public function index()
  {
    $data["title"] = "Inpu Temuan";
    echo view('layouts/header.php', $data);
    echo view('audit/temuan/form.php');
    echo view('layouts/footer.php');
  }

}
?>