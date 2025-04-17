<?php

namespace App\Controllers;

class DashboardPeriode extends BaseController
{
  public function index()
  {
    $data["user_type"] = "Mahasiswa";
    $data["title"] = "Dashboard";
    echo view('layouts/header.php', $data);
    echo view('akreditasi/dashboard/form.php');
    echo view('layouts/footer.php');
  }

}
?>