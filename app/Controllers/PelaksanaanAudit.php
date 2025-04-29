<?php
namespace App\Controllers;

use App\Models\PelaksanaanAuditModel;
use App\Models\AuditStandarModel;
use App\Models\PernyataanModel;


class PelaksanaanAudit extends BaseController
{
  public function index()
  {

    $model = new PelaksanaanAuditModel();
    $data['pelaksanaan_audit'] = $model->getPelaksanaanAudit();
    $data["title"] = "Pelaksanaan Audit";

    echo view('layouts/header.php', $data);
    echo view('audit/pelaksanaan_audit/tables.php', $data);
    echo view('layouts/footer.php');
  }

  public function edit($id_audit)
  {
    // Load Model yang dibutuhkan
    $auditStandarModel = new AuditStandarModel();
    $pernyataanModel = new PernyataanModel(); // ini contoh nama model indikator

    // Ambil semua standar yang terkait dengan audit ini
    $standar = $auditStandarModel->getStandarByAudit($id_audit);

    // Ambil semua indikator yang terkait dengan standar-standar itu
    $pernyataan = $pernyataanModel->getPernyataanByAudit($id_audit);

    $data = [
      'title' => 'Pelaksanaan Audit',
      'standar' => $standar,
      'indikator' => $pernyataan,
      'id_audit' => $id_audit
    ];

    echo view('layouts/header', $data);
    echo view('audit/pelaksanaan_audit/edit', $data);
    echo view('layouts/footer');
  }


}
?>