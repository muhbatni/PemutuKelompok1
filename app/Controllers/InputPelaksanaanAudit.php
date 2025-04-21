<?php
namespace App\Controllers;

class InputPelaksanaanAudit extends BaseController
{
  public function index()
  {

    $periodeModel = new \App\Models\PeriodeModel();
    $data['periodes'] = $periodeModel->getPeriodes();

    if ($this->request->getMethod() == 'POST'){
      $data = [
        'id_periode' => $this ->request->getPost('id_periode'),
        'kode' => $this ->request->getPost('kode'),
        'tanggal_mulai' => $this ->request->getPost('tanggal_mulai'),
        'tanggal_selesai' => $this ->request->getPost('tanggal_selesai')
      ];

      $model = new \App\Models\PelaksanaanAudit();
      $saveResult = $model->insert($data);

      if($saveResult){
        session()->setFlashdata('Success', 'Data berhasil disimpan');
      } else{
        session()->setFlashdata('Error', 'Terjadi kesalahan saat menyimpan data.');
      }
      return redirect()->to(base_url('audit/input-pelaksanaan'));
    }

    $data["title"] = "Input Pelaksanaan Audit";
    echo view('layouts/header.php', $data);
    echo view('audit/pelaksanaan_audit/form.php');
    echo view('layouts/footer.php');
  }

}
?>