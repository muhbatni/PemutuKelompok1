<?php
namespace App\Controllers;

class SyaratUnggul extends BaseController
{
  public function index()
  {
    $data["title"] = "Syarat Unggul";
    echo view('layouts/header.php', $data);
    echo view('syarat-unggul/form.php');
    echo view('layouts/footer.php');
  }

}
?>