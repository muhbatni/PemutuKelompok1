<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
  public function index()
  {
    $data["user_type"] = "Mahasiswa";
    $data["title"] = "Dashboard";
    echo view('layouts/header.php', $data);
    echo view('layouts/tables.php');
    echo view('layouts/footer.php');
  
    $data["title"] = "Dashboard";
    echo view('layouts/header.php', $data);
    echo view('dashboard/form.php');
    echo view('layouts/footer.php');
  }

}
?>
