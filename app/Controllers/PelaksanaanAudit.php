<?php
namespace App\Controllers;

use App\Models\PelaksanaanAuditModel;
use App\Models\AuditStandarModel;
use App\Models\PernyataanModel;
use App\Models\AuditorModel;
use App\Models\IsianAuditModel;
use App\Models\TemuanModel;
use App\Models\ManajemenAuditModel;

class PelaksanaanAudit extends BaseController
{
  protected $pelaksanaanAuditModel;
  protected $auditStandarModel;
  protected $manajemenAuditModel;
  protected $pernyataanModel;
  protected $auditorModel;
  protected $isianAuditModel;
  protected $temuanModel;

  public function __construct()
  {
    $this->pelaksanaanAuditModel = new PelaksanaanAuditModel();
    $this->auditStandarModel = new AuditStandarModel();
    $this->pernyataanModel = new PernyataanModel();
    $this->manajemenAuditModel = new ManajemenAuditModel();
    $this->auditorModel = new AuditorModel();
    $this->isianAuditModel = new IsianAuditModel();
    $this->temuanModel = new TemuanModel();
  }

  public function index()
  {
    $id_audit = $this->request->getGet('id');
    $data['list_audit'] = $this->pelaksanaanAuditModel->getListAuditForDropdown();

    if ($id_audit) {
      $data['pelaksanaan_audit'] = $this->pelaksanaanAuditModel->getPelaksanaanAudit($id_audit);
      $data['list_standar_audit'] = $this->auditStandarModel->getByAuditId($id_audit);
    } else {
      // Ambil semua data jika tidak ada filter
      $data['pelaksanaan_audit'] = $this->pelaksanaanAuditModel->getPelaksanaanAudit(null);
      $data['list_standar_audit'] = [];
    }

    $data["title"] = "Pelaksanaan Audit";
    echo view('layouts/header.php', $data);
    echo view('audit/pelaksanaan_audit/tables.php', $data);
    echo view('layouts/footer.php');
  }

  public function edit($id_standar_audit)
  {

    $isExistingData = !empty($pelaksanaan); // true jika data sudah ada → artinya sedang edit

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
      'standar_audit_id' => $standar_audit_id,
      'firstStandar' => $firstStandar,
      'isExistingData' => !empty($firstStandar) // ⬅️ kuncinya di sini
    ];

    echo view('layouts/header', $data);
    echo view('audit/pelaksanaan_audit/edit', $data);
    echo view('layouts/footer');
  }


  public function simpan()
  {
    $db = \Config\Database::connect();
    $db->transBegin();

    try {
      $id_unit = $this->request->getPost('id_unit');
      $id_auditor = $this->request->getPost('id_auditor');
      $id_standar_audit = $this->request->getPost('id_standar_audit');

      // Validasi input
      if (
        empty($id_unit) || $id_unit === 'undefined' ||
        empty($id_auditor) || $id_auditor === 'undefined' ||
        empty($id_standar_audit) || $id_standar_audit === 'undefined'
      ) {
        return redirect()->back()->with('error', 'Auditor, Unit, dan Standar Audit wajib dipilih!');
      }

      // 1. Insert/update pelaksanaan audit (auditor & unit)
      $pelaksanaanModel = new PelaksanaanAuditModel();
      $pelaksanaanData = [
        'id_unit' => $id_unit,
        'id_auditor' => $id_auditor,
        'id_standar_audit' => $id_standar_audit,
      ];
      $pelaksanaan = $pelaksanaanModel
        ->where('id_unit', $id_unit)
        ->where('id_auditor', $id_auditor)
        ->where('id_standar_audit', $id_standar_audit)
        ->first();
      if ($pelaksanaan) {
        $idPelaksanaan = $pelaksanaan['id'];
        $pelaksanaanModel->update($idPelaksanaan, $pelaksanaanData);
      } else {
        $pelaksanaanModel->insert($pelaksanaanData);
        $idPelaksanaan = $pelaksanaanModel->getInsertID();
      }

      // 2. Insert isian audit jika ada data isian
      if ($this->request->getPost('id_pernyataan')) {
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

        // 3. Insert temuan jika is_temuan dicentang
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
      }

      $db->transCommit();
      return redirect()->back()->with('success', 'Data berhasil disimpan.');
    } catch (\Exception $e) {
      $db->transRollback();
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