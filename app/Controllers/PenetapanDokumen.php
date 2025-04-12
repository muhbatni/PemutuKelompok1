<?php
namespace App\Controllers;

class PenetapanDokumen extends BaseController
{
  public function index()
  {
    $data["title"] = "Penetapan Dokumen";
    echo view('layouts/header.php', $data);
    echo view('penetapan_dokumen/index.php');
    echo view('layouts/footer.php');
  }

}
?>