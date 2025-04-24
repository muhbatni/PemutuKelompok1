<?php
namespace App\Controllers;

class DataDukung extends BaseController
{
  public function index()
  {
    $data["title"] = "Data Dukung";
    echo view('layouts/header.php', $data);
    echo view('audit/data_dukung/tables.php');
    echo view('layouts/footer.php');
  }

}
?>