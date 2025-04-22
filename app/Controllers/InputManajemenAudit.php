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
      
      $model = new ManajemenAuditModel();
      $saveResult = $model->insert($auditData);
      $id_audit = $model->getInsertID();
      
      if ($saveResult && $id_audit) {
        $selectedStandars = $this->request->getPost('id_standar');

        if (!is_array($selectedStandars)) {
          $selectedStandars = [$selectedStandars];  // Jika hanya satu nilai yang dipilih, jadikan array
      }

        if(!empty($selectedStandars)){
          $auditStandarModel = new AuditStandarModel();
          foreach ($selectedStandars as $id_standar) {
            $auditStandarModel->insert([
              'id_audit' =>$id_audit,
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

}
?>