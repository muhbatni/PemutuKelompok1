<?php
namespace App\Controllers;

class InstrumenPemutu extends BaseController
{
  public function index()
  {
    $data["title"] = "Instrumen Pemutu";
    echo view('layouts/header.php', $data);
    echo view('akreditasi/instrumen_pemutu/form.php');
    echo view('layouts/footer.php');
  }

}
?>