<?php
namespace App\Controllers;

use App\Models\PelaksanaanAuditModel;
use App\Models\AuditStandarModel;
use App\Models\PernyataanModel;
use App\Models\AuditorModel;
use App\Models\IsianAuditModel;
use App\Models\TemuanModel;

class PelaksanaanAudit extends BaseController
{
  protected $pelaksanaanAuditModel;
  protected $auditStandarModel;
  protected $pernyataanModel;
  protected $auditorModel;
  protected $isianAuditModel;
  protected $temuanModel;

  public function __construct()
  {
    $this->pelaksanaanAuditModel = new PelaksanaanAuditModel();
    $this->auditStandarModel = new AuditStandarModel();
    $this->pernyataanModel = new PernyataanModel();
    $this->auditorModel = new AuditorModel();
    $this->isianAuditModel = new IsianAuditModel();
    $this->temuanModel = new TemuanModel();
  }

  public function index()
  {
    $data['pelaksanaan_audit'] = $this->pelaksanaanAuditModel->getPelaksanaanAudit();
    $data["title"] = "Pelaksanaan Audit";

    echo view('layouts/header.php', $data);
    echo view('audit/pelaksanaan_audit/tables.php', $data);
    echo view('layouts/footer.php');
  }

  public function edit($id_standar_audit)
  {
    $id_audit = $this->auditStandarModel->getAuditIdByStandar($id_standar_audit);

    $pelaksanaan = $this->pelaksanaanAuditModel->getPelaksanaanAuditById($id_standar_audit);
    $firstStandar = !empty($pelaksanaan) ? $pelaksanaan[0] : null;
    $standar_audit_id = $firstStandar['id_standar_audit'] ?? $id_standar_audit;

    $standar = $this->auditStandarModel->getStandarByAudit($id_audit);
    $pernyataan = $this->pelaksanaanAuditModel->getPernyataanByStandar($id_standar_audit);
    $auditor_list = $this->pelaksanaanAuditModel->getAuditorList();
    $unit_list = $this->pelaksanaanAuditModel->getUnitList();

    $data = [
      'title' => 'Pelaksanaan Audit',
      'standar' => $standar,
      'pernyataan' => $pernyataan,
      'auditor_list' => $auditor_list,
      'unit_list' => $unit_list,
      'id_audit' => $id_audit,
      'standar_audit_id' => $standar_audit_id
    ];

    echo view('layouts/header', $data);
    echo view('audit/pelaksanaan_audit/edit', $data);
    echo view('layouts/footer');
  }


  public function simpan()
  {
    $db = \Config\Database::connect();
    $db->transBegin(); // Mulai transaksi

    try {
      // 1. Insert ke a_pelaksanaan_audit
      $pelaksanaanModel = new PelaksanaanAuditModel();
      $pelaksanaanData = [
        'id_unit' => $this->request->getPost('id_unit'),
        'id_auditor' => $this->request->getPost('id_auditor'),
        'id_standar_audit' => $this->request->getPost('id_standar_audit'),
      ];

      
      $pelaksanaanModel->insert($pelaksanaanData);
      $idPelaksanaan = $pelaksanaanModel->getInsertID();

      // 2. Insert ke a_isian_audit
      $isianModel = new IsianAuditModel();
      $isianData = [
        'id_pelaksanaan' => $idPelaksanaan,
        'id_pernyataan' => $this->request->getPost('id_pernyataan'),
        'capaian' => $this->request->getPost('capaian'),
        'kondisi' => $this->request->getPost('kondisi'),
        'akar' => $this->request->getPost('akar'),
        'akibat' => $this->request->getPost('akibat'),
        'rekom' => $this->request->getPost('rekom'),
        'tanggapan' => $this->request->getPost('tanggapan'),
        'rencana_perbaikan' => $this->request->getPost('rencana_perbaikan'),
        'tanggal_perbaikan' => $this->request->getPost('tanggal_perbaikan'),
        'rencana_pencegahan' => $this->request->getPost('rencana_pencegahan'),
        'tanggal_pencegahan' => $this->request->getPost('tanggal_pencegahan'),
        'is_temuan' => $this->request->getPost('is_temuan') === 'on' ? true : false

      ];
      $isianModel->insert($isianData);
      $idIsian = $isianModel->getInsertID();

      // 3. Insert ke a_temuan jika is_temuan == true
      if ($this->request->getPost('is_temuan')) {
        $temuanModel = new TemuanModel();
        $temuanData = [
          'id_unit' => $this->request->getPost('id_unit'),
          'id_isian_audit' => $idIsian,
          'kondisi' => $this->request->getPost('kondisi'),
          'rencana_perbaikan' => $this->request->getPost('rencana_perbaikan'),
          'tanggal_perbaikan' => $this->request->getPost('tanggal_perbaikan'),
          'catatan' => $this->request->getPost('catatan'),
          'status' => $this->request->getPost('status'),
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s'),
        ];
        $temuanModel->insert($temuanData);
      }

      $db->transCommit(); // Simpan semua

      return redirect()->back()->with('success', 'Data berhasil disimpan.');


    } catch (\Exception $e) {
      $db->transRollback(); // Gagal, batalkan semua
      return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
    }
  }

  public function getAuditor()
  {
    $auditor = $this->auditorModel->getAll();
    return $this->response->setJSON($auditor);
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