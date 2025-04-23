<?php
namespace App\Controllers;
use App\Models\UnitModel;
use App\Models\LembagaAkreditasiModel;
use App\Models\PeriodeModel;

class InputDataPemutu extends BaseController
{
  protected $unitModel;
  protected $lembagaModel;
  protected $periodeModel;

  public function __construct()
  {
    $this->unitModel = new UnitModel();
    $this->lembagaModel = new LembagaAkreditasiModel();
    $this->periodeModel = new PeriodeModel();
  }

  public function index()
  {
    $data = [
      'title' => 'Input Data Pemutu',
      'units' => $this->unitModel->getUnits(),
      'lembagas' => $this->lembagaModel->getLembagas(),
      'periodes' => $this->periodeModel->getPeriodes(), // Pastikan method ini ada di PeriodeModel
      'validation' => \Config\Services::validation()
    ];

    return view('layouts/header', $data)
      . view('akreditasi/input_data_pemutu/form')
      . view('layouts/footer');
  }

  // ... (method save dan lainnya tetap sama)
}