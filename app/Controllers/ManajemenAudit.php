<?php
namespace App\Controllers;

use App\Models\AuditStandarModel;


class ManajemenAudit extends BaseController
{
  public function index()
  {

    $model = new AuditStandarModel();
    $data['audit_standar'] = $model->getAuditWithStandar();

    $data["title"] = "Manajemen Audit";
    echo view('layouts/header.php', $data);
    echo view('audit/manajemen_audit/tables.php', $data);
    echo view('layouts/footer.php');
  }

}
?>