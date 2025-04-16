<?php
namespace App\Controllers;

class InputDataPemutu extends BaseController
{
  public function index()
  {
    $data["title"] = "Input Data Pemutu";
    echo view('layouts/header.php', $data);
    echo view('input-datapemutu/form.php');
    echo view('layouts/footer.php');
  }

}
?>