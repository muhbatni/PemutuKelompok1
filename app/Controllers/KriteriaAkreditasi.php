<?php
namespace App\Controllers;

class KriteriaAkreditasi extends BaseController
{
  public function index()
  {
    $data["title"] = "Kriteria Akreditasi";
    echo view('layouts/header.php', $data);
    echo view('kriteria-akreditasi/form.php');
    echo view('layouts/footer.php');
  }

}
?>