<?php

namespace App\Controllers;

use App\Models\PeriodeModel;

class DashboardPeriode extends BaseController
{
  public function index()
  {
    $periodeModel = new PeriodeModel();
    $periodeList = $periodeModel->findAll();

    $data = [
      "user_type" => "Mahasiswa",
      "title" => "Dashboard",
      "periodeList" => $periodeList,
    ];

    echo view('layouts/header.php', $data);
    echo view('akreditasi/dashboard/form.php', $data);
    echo view('layouts/footer.php', $data);
  }
}
?>