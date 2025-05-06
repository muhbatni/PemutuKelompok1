<?php
namespace App\Controllers;

use App\Models\DashboardModel;

class DashboardPeriode extends BaseController
{
  protected $dashboardModel;

  public function __construct()
  {
    $this->dashboardModel = new DashboardModel();
  }

  public function index()
  {
    $tahun = $this->request->getGet('tahun');

    $data = [
      "user_type" => "Mahasiswa",
      "title" => "Dashboard",
      "periodeList" => $this->dashboardModel->getAllPeriode(),
      "unitPemutu" => $this->dashboardModel->getUnitPemutu($tahun),
      "selectedTahun" => $tahun ?? ''
    ];

    echo view('layouts/header.php', $data);
    echo view('akreditasi/dashboard/form.php', $data);
    echo view('layouts/footer.php', $data);
  }
}