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

    //ambil data m_lembaga_akreditasi
    $lembagaModel = new \App\Models\LembagaAkreditasiModel();
    $data['lembagas'] = $lembagaModel->getLembagas();

    echo view('layouts/header.php', $data);
    echo view('akreditasi/form.php', $data);
    echo view('layouts/footer.php');
  }

}
?>