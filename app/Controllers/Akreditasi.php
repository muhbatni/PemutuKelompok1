<?php
namespace App\Controllers;

class Akreditasi extends BaseController
{
  public function index()
  {
    $data["title"] = "Akreditasi";

    //ambil data m_unit
    $unitModel = new \App\Models\UnitModel();
    $data['units'] = $unitModel->getUnits();

    echo view('layouts/header.php', $data);
    echo view('akreditasi/form.php', $data);
    echo view('layouts/footer.php');
  }

}
?>