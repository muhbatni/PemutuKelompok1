<?php
namespace App\Controllers;

class Periode extends BaseController
{
  public function index()
  {
    $data["title"] = "Periode";
    echo view('layouts/header.php', $data);
    echo view('periode/form.php');
    echo view('layouts/footer.php');
  }

}
?>