<?php
namespace App\Controllers;

class Dashboard extends BaseController
{
  public function index()
  {
    $data["title"] = "Dashboard";
    echo view('layouts/header.php', $data);
    echo view('dashboard/index.php');
    echo view('layouts/footer.php');
  }

}
?>