<?php
namespace App\Controllers;

class SyaratUnggul extends BaseController
{
  public function index()
  {
    $data["title"] = "Syarat Unggul";
    echo view('layouts/header.php', $data);
    echo view('akreditasi/syarat_unggul/form.php');
    echo view('layouts/footer.php');
  }

}
?>