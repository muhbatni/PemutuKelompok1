<?php
namespace App\Controllers;

use App\Models\TemuanModel;

class Temuan extends BaseController
{
  public function index()
{
    $model = new TemuanModel();
    $unitModel = new \App\Models\UnitModel();

    $temuan = $model->findAll();

    // Tambahkan nama unit ke setiap baris temuan
    foreach ($temuan as &$row) {
        $unit = $unitModel->getUnitById($row['id_unit']);
        $row['nama_unit'] = $unit ? $unit['nama'] : '-';
    }

    $data = [
        'title' => 'Daftar Temuan',
        'temuan' => $temuan,
    ];

    echo view('layouts/header', $data);
    echo view('audit/temuan/tables.php', $data);
    echo view('layouts/footer');
}


}
?>