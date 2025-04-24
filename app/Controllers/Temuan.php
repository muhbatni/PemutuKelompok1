<?php
namespace App\Controllers;

class Temuan extends BaseController
{
  public function index()
  {
    $data["title"] = "Temuan";
    echo view('layouts/header.php', $data);
    echo view('audit/temuan/tables.php');
    echo view('layouts/footer.php');
  }

}
?>