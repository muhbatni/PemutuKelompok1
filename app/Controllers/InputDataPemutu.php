<?php
namespace App\Controllers;

class InputDataPemutu extends BaseController
{
  public function index()
  {
    $data["title"] = "Input Data Pemutu";
    echo view('layouts/header.php', $data);
    echo view('akreditasi/input_data_pemutu/form.php');
    echo view('layouts/footer.php');
  }

}
?>