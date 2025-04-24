<?php

namespace App\Controllers;

use App\Models\IsianPemutuModel;
use App\Models\UnitPemutuModel;
use App\Models\LembagaAkreditasiModel;

class IsianPemutu extends BaseController
{
  public function index()
  {
    echo view('layouts/header.php', $data);
    echo view('akreditasi/isian_pemutu/form.php');
    echo view('layouts/footer.php');
  }
}
?>