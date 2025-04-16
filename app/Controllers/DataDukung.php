<?php
namespace App\Controllers;

class DataDukung extends BaseController
{
  public function index()
  {
    $data["title"] = "Data Dukung";
    echo view('layouts/header.php', $data);
    echo view('data_dukung/form.php');
    echo view('layouts/footer.php');
  }

}
?>