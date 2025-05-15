<?php

namespace App\Controllers;

use App\Models\UnitModel;

class Registrasi extends BaseController
{
  protected $unitModel;

  public function __construct()
  {
    $this->unitModel = new UnitModel();
  }

  public function index()
  {
    $data['units'] = $this->unitModel->findAll();
    echo view("registrasi/index.php", $data);
  }
}