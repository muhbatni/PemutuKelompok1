<?php
namespace App\Controllers;

class Akreditasi extends BaseController
{
  public function index()
  {
    $data["title"] = "Akreditasi";
    echo view('layouts/header.php', $data);
    echo view('akreditasi/form.php');
    echo view('layouts/footer.php');
  }

}
?>