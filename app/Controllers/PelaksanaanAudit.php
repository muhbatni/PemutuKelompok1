<?php
namespace App\Controllers;

use App\Models\PelaksanaanAuditModel;
use App\Models\AuditStandarModel;
use App\Models\PernyataanModel;

class PelaksanaanAudit extends BaseController
{
  protected $pelaksanaanAuditModel;
  protected $auditStandarModel;
  protected $pernyataanModel;

  public function __construct()
  {
    $this->pelaksanaanAuditModel = new PelaksanaanAuditModel();
    $this->auditStandarModel = new AuditStandarModel();
    $this->pernyataanModel = new PernyataanModel();
  }

  public function index()
  {
    $data['pelaksanaan_audit'] = $this->pelaksanaanAuditModel->getPelaksanaanAudit();
    $data["title"] = "Pelaksanaan Audit";

    echo view('layouts/header.php', $data);
    echo view('audit/pelaksanaan_audit/tables.php', $data);
    echo view('layouts/footer.php');
  }

  public function edit($id_audit)
  {
    $standar = $this->auditStandarModel->getStandarByAudit($id_audit);
    $pernyataan = $this->pelaksanaanAuditModel->getPernyataanByStandar($id_audit);
    $auditor_list = $this->pelaksanaanAuditModel->getAuditorList(); // <--- TAMBAHKAN INI
    $unit_list = $this->pelaksanaanAuditModel->getUnitList(); // kalau butuh list unit juga

    $data = [
      'title' => 'Pelaksanaan Audit',
      'standar' => $standar,
      'pernyataan' => $pernyataan,
      'auditor_list' => $auditor_list, // <-- KIRIM KE VIEW
      'unit_list' => $unit_list,   // <-- optional kalau ada dropdown unit
      'id_audit' => $id_audit
    ];



    echo view('layouts/header', $data);
    echo view('audit/pelaksanaan_audit/edit', $data);
    echo view('layouts/footer');
  }

  public function getPernyataanByStandar($id_standar)
  {
    $data = $this->pernyataanModel->getPernyataanByStandarId($id_standar);
    return $this->response->setJSON($data);
  }

  public function getDetailPernyataan($id)
  {
    $data = $this->pernyataanModel->getDetailPernyataan($id);
    return $this->response->setJSON($data);
  }





}
?>