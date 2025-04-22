<?php
namespace App\Controllers;
use App\Models\UnitModel;
use App\Models\LembagaAkreditasiModel;

class InputDataPemutu extends BaseController
{
  public function index()
  {
    $unitModel = new UnitModel();
    $data['units'] = $unitModel->getUnits();
    $lembagaModel = new LembagaAkreditasiModel();
    $data['lembagas'] = $lembagaModel->getLembagas();
    $data["title"] = "In
    put Data Pemutu";
    echo view('layouts/header.php', $data);
    echo view('akreditasi/input_data_pemutu/form.php');
    echo view('layouts/footer.php');
  }

}
?>