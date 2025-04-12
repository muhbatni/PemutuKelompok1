<?php
namespace App\Controllers;

class DokumenPenetapan extends BaseController
{
  public function index()
  {
    $data["title"] = "Dokumen Penetapan";
    echo view('layouts/header.php', $data);
    echo view('dokumen_penetapan/index.php');
    echo view('layouts/footer.php');
  }

}
?>