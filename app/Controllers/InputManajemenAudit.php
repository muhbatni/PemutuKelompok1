<?php
namespace App\Controllers;

use App\Models\ManajemenAuditModel;
use App\Models\AuditStandarModel;
use App\Models\PeriodeModel;
use App\Models\StandarModel;

class InputManajemenAudit extends BaseController
{
  public function index()
  {

    $periodeModel = new PeriodeModel();
    $data['periodes'] = $periodeModel->getPeriodes();

    $standarModel = new StandarModel();
    $data['standars'] = $standarModel->getStandars();

    if ($this->request->getMethod() == 'POST') {
      $auditData = [
        'id_periode' => $this->request->getPost('id_periode'),
        'kode' => $this->request->getPost('kode'),
        'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
        'tanggal_selesai' => $this->request->getPost('tanggal_selesai')
      ];

      if (empty($auditData['id_periode']) || empty($auditData['kode']) || empty($auditData['tanggal_mulai']) || empty($auditData['tanggal_selesai'])) {
        session()->setFlashdata('Error', 'Semua field harus diisi');
        return redirect()->to('/input-manajemen-audit'); // Ganti dengan URL yang sesuai
      }

      if (strtotime($auditData['tanggal_selesai']) < strtotime($auditData['tanggal_mulai'])) {
        session()->setFlashdata('Error', 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.');
        return redirect()->to('/input-manajemen-audit')->withInput();
      }

      $model = new ManajemenAuditModel();
      $saveResult = $model->insert($auditData);
      $id_audit = $model->getInsertID();

      if ($saveResult && $id_audit) {
        $selectedStandars = $this->request->getPost('id_standar');

        if (!is_array($selectedStandars)) {
          $selectedStandars = [$selectedStandars];  // Jika hanya satu nilai yang dipilih, jadikan array
        }

        if (!empty($selectedStandars)) {
          $auditStandarModel = new AuditStandarModel();
          foreach ($selectedStandars as $id_standar) {
            $auditStandarModel->insert([
              'id_audit' => $id_audit,
              'id_standar' => $id_standar
            ]);
          }
        }

        session()->setFlashdata('Success', 'Data berhasil disimpan');
      } else {
        session()->setFlashdata('Error', 'Terjadi kesalahan saat menyimpan data.');
      }
      return redirect()->to(base_url('public/audit/manajemen-audit'));
    }


    $data["title"] = "Input Pelaksanaan Audit";
    echo view('layouts/header.php', $data);
    echo view('audit/manajemen_audit/form.php', $data);
    echo view('layouts/footer.php');
  }

  public function edit($id)
  {
    $auditModel = new ManajemenAuditModel();
    $auditStandarModel = new AuditStandarModel();
    $standarModel = new StandarModel();
    $periodeModel = new PeriodeModel();

    $data['audit'] = $auditModel->find($id);
    $data['periodes'] = $periodeModel->getPeriodes();
    $data['standars'] = $standarModel->getStandars();
    $data['selectedStandars'] = array_column(
      $auditStandarModel->where('id_audit', $id)->findAll(),
      'id_standar'
    );

    $data["title"] = "Edit Pelaksanaan Audit";
    echo view('layouts/header.php', $data);
    echo view('audit/manajemen_audit/form.php', $data);
    echo view('layouts/footer.php');
  }

  public function update($id)
  {
    $auditData = [
      'id_periode' => $this->request->getPost('id_periode'),
      'kode' => $this->request->getPost('kode'),
      'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
      'tanggal_selesai' => $this->request->getPost('tanggal_selesai')
    ];

    if (strtotime($auditData['tanggal_selesai']) < strtotime($auditData['tanggal_mulai'])) {
      session()->setFlashdata('Error', 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.');
      return redirect()->to('/input-manajemen-audit')->withInput();
    }

    $auditModel = new ManajemenAuditModel();
    $auditModel->update($id, $auditData);

    // Hapus data audit_standar yang ada
    $auditStandarModel = new AuditStandarModel();
    $auditStandarModel->where('id_audit', $id)->delete();

    // Simpan data audit_standar yang baru
    $selectedStandars = $this->request->getPost('id_standar') ?? [];
    foreach ($selectedStandars as $id_standar) {
      $auditStandarModel->insert([
        'id_audit' => $id,
        'id_standar' => $id_standar
      ]);
    }

    session()->setFlashdata('Success', 'Data berhasil diupdate');
    return redirect()->to(base_url('public/audit/manajemen-audit'));

  }

  public function delete($id)
  {
    $auditModel = new ManajemenAuditModel();
    $auditStandarModel = new AuditStandarModel();

    // Hapus data audit_standar yang terkait
    $auditStandarModel->where('id_audit', $id)->delete();

    // Hapus data audit
    $auditModel->delete($id);

    session()->setFlashdata('Success', 'Data berhasil dihapus');
    return redirect()->to(base_url('public/audit/manajemen-audit'));
  }
}
?>