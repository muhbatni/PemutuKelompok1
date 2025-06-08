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
    $data['id_audit'] = $id_audit; // Menambahkan id_audit ke data yang akan dikirim ke view
    $data['list_audit'] = $this->pelaksanaanAuditModel->getListAuditForDropdown();
    $data['auditor_list'] = $this->pelaksanaanAuditModel->getAuditorList();
    $data['unit_list'] = $this->pelaksanaanAuditModel->getUnitList();


    if ($id_audit) {
      $data['pelaksanaan_audit'] = $this->pelaksanaanAuditModel->getPelaksanaanAudit($id_audit);
    } else {
      // Ambil semua data jika tidak ada filter
      $data['pelaksanaan_audit'] = $this->pelaksanaanAuditModel->getPelaksanaanAudit(null);
    }

    $data["title"] = "Pelaksanaan Audit";
    echo view('layouts/header.php', $data);
    echo view('audit/pelaksanaan_audit/tables.php', $data);
    echo view('layouts/footer.php');
  }

  public function edit($id_standar_audit)
  {
    // Pastikan variabel $pelaksanaan terdefinisi sebelum digunakan di $isExistingData
    $pelaksanaan = $this->pelaksanaanAuditModel->getPelaksanaanAuditById($id_standar_audit);
    $firstStandar = !empty($pelaksanaan) ? $pelaksanaan[0] : null;

    $isExistingData = !empty($firstStandar); // true jika data sudah ada → artinya sedang edit

    $id_audit = $this->auditStandarModel->getAuditIdByStandar($id_standar_audit);

    // Ambil id_pelaksanaan dari $firstStandar
    $pelaksanaan_audit_id = $firstStandar['id'] ?? null; // REVISI: Ambil ID Pelaksanaan Audit

    $standar_audit_id = $firstStandar['id_standar_audit'] ?? $id_standar_audit;

    $standar = $this->auditStandarModel->getStandarByAudit($id_audit);

    $auditor_list = $this->pelaksanaanAuditModel->getAuditorList();
    $unit_list = $this->pelaksanaanAuditModel->getUnitList();

    $data = [
      'title' => 'Pelaksanaan Audit',
      'standar' => $standar,
      'auditor_list' => $auditor_list,
      'unit_list' => $unit_list,
      'id_audit' => $id_audit,
      'standar_audit_id' => $standar_audit_id,
      'firstStandar' => $firstStandar,
      'isExistingData' => $isExistingData,
      'pelaksanaan_audit_id' => $pelaksanaan_audit_id // REVISI: Kirim ID Pelaksanaan ke view
    ];

    echo view('layouts/header', $data);
    echo view('audit/pelaksanaan_audit/edit', $data);
    echo view('layouts/footer');
  }

  public function simpanunitauditor()
  {
    $db = \Config\Database::connect();
    $db->transBegin();

    try {
      $id_unit = $this->request->getPost('id_unit');
      $id_auditor = $this->request->getPost('id_auditor');
      $id_audit = $this->request->getPost('id_audit');

      // Validasi input
      if (empty($id_unit) || empty($id_auditor) || empty($id_audit)) {
        return redirect()->back()->with('error', 'Audit, Auditor, dan Unit wajib dipilih!');
      }

      // Ambil semua standar audit berdasarkan id_audit
      $standarModel = new AuditStandarModel();
      $standarList = $standarModel->where('id_audit', $id_audit)->findAll();

      if (empty($standarList)) {
        return redirect()->back()->with('error', 'Tidak ada standar audit yang terkait dengan audit ini.');
      }

      $pelaksanaanModel = new PelaksanaanAuditModel();
      $pernyataanModel = new PernyataanModel();
      $isianModel = new IsianAuditModel();

      foreach ($standarList as $standar) {
        $id_standar_audit_junction = $standar['id'];
        $id_standar_murni = $standar['id_standar'];

        $pelaksanaanData = [
          'id_unit' => $id_unit,
          'id_auditor' => $id_auditor,
          'id_standar_audit' => $id_standar_audit_junction,
        ];

        // Cek apakah pelaksanaan sudah ada
        $existing = $pelaksanaanModel
          ->where('id_unit', $id_unit)
          ->where('id_auditor', $id_auditor)
          ->where('id_standar_audit', $id_standar_audit_junction)
          ->first();

        $idPelaksanaan = null;
        if ($existing) {
          $idPelaksanaan = $existing['id'];
          $pelaksanaanModel->update($idPelaksanaan, $pelaksanaanData);
        } else {
          $pelaksanaanModel->insert($pelaksanaanData);
          $idPelaksanaan = $pelaksanaanModel->getInsertID();
        }

        if ($idPelaksanaan) {
          $pernyataanlist = $pernyataanModel->getPernyataanByStandarId($id_standar_murni);

          foreach ($pernyataanlist as $pernyataan) {
            $existingIsian = $isianModel
              ->where('id_pelaksanaan', $idPelaksanaan)
              ->where('id_pernyataan', $pernyataan['id'])
              ->first();

            if (!$existingIsian) {
              $isianData = [
                'id_pelaksanaan' => $idPelaksanaan,
                'id_pernyataan' => $pernyataan['id'],
                'capaian' => null,
                'kondisi' => null,
                'akar' => null,
                'akibat' => null,
                'rekom' => null,
                'tanggapan' => null,
                'rencana_perbaikan' => null,
                'tanggal_perbaikan' => null,
                'rencana_pencegahan' => null,
                'tanggal_pencegahan' => null,
                'is_temuan' => false
              ];
              $isianModel->insert($isianData);
            }
          }
        }
      }

      $db->transCommit();
      return redirect()->back()->with('success', 'Data berhasil disimpan.');
    } catch (\Exception $e) {
      $db->transRollback();
      return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
    }
  }


  public function simpan()
  {
    $db = \Config\Database::connect();
    $db->transBegin();

    try {
      $id_pernyataan = $this->request->getPost('id_pernyataan');
      $id_pelaksanaan = $this->request->getPost('id_pelaksanaan');

      // Validasi input
      if (empty($id_pernyataan) || empty($id_pelaksanaan)) {
        return redirect()->back()->with('error', 'Data isian tidak lengkap. Harap pilih pernyataan dan pastikan data pelaksanaan sudah ada.');
      }

      $isianModel = new IsianAuditModel();

      $existingIsian = $isianModel
        ->where('id_pelaksanaan', $id_pelaksanaan)
        ->where('id_pernyataan', $id_pernyataan)
        ->first();

      $isianData = [
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

      $idIsian = null;
      if ($existingIsian) {
        $isianModel->update($existingIsian['id'], $isianData);
        $idIsian = $existingIsian['id'];
      } else {
        $isianData['id_pelaksanaan'] = $id_pelaksanaan;
        $isianData['id_pernyataan'] = $id_pernyataan;
        $isianModel->insert($isianData);
        $idIsian = $isianModel->getInsertID();
      }

      $temuanModel = new TemuanModel();
      if ($isianData['is_temuan']) {
        $existingTemuan = $temuanModel->where('id_isian_audit', $idIsian)->first();
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
        if ($existingTemuan) {
          $temuanModel->update($existingTemuan['id'], $temuanData);
        } else {
          $temuanModel->insert($temuanData);
        }
      } else {
        $temuanModel->where('id_isian_audit', $idIsian)->delete();
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

  public function getIsianAuditData($id_pelaksanaan, $id_pernyataan)
  {
    $isianModel = new IsianAuditModel();
    $data = $isianModel
      ->where('id_pelaksanaan', $id_pelaksanaan)
      ->where('id_pernyataan', $id_pernyataan)
      ->first();

    log_message('debug', 'getIsianAuditData called with id_pelaksanaan: ' . $id_pelaksanaan . ' and id_pernyataan: ' . $id_pernyataan);
    log_message('debug', 'Data returned by isianModel->first(): ' . json_encode($data));

    return $this->response->setJSON($data);
  }





}
?>