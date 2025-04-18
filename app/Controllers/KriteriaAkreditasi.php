<?php
namespace App\Controllers;

class KriteriaAkreditasi extends BaseController
{
  public function index()
  {
    $data["title"] = "Kriteria Akreditasi";
    echo view('layouts/header.php', $data);
    echo view('akreditasi/kriteria_akreditasi/form.php');
    echo view('layouts/footer.php');
  }

}
?>