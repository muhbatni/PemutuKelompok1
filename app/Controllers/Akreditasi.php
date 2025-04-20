<?php
namespace App\Controllers;

class Akreditasi extends BaseController
{
  public function index()
  {

    //ambil data m_unit
    $unitModel = new \App\Models\UnitModel();
    $data['units'] = $unitModel->getUnits();

    //ambil data m_lembaga_akreditasi
    $lembagaModel = new \App\Models\LembagaAkreditasiModel();
    $data['lembagas'] = $lembagaModel->getLembagas();

    if ($this->request->getMethod() == 'POST') {
      // Mengambil data dari form
      $data = [
          'id_unit'        => $this->request->getPost('id_unit'),
          'id_lembaga'     => $this->request->getPost('id_lembaga'),
          'status'         => $this->request->getPost('status'),
          'tanggal_berlaku' => $this->request->getPost('tanggal_berlaku'),
          'tanggal_habis'  => $this->request->getPost('tanggal_habis'),
      ];
  
      // Simpan data ke database
      $model = new \App\Models\AkreditasiModel();
      $saveResult = $model->insert($data);

    if ($saveResult) {
        // Jika berhasil
        session()->setFlashdata('success', 'Dokumen berhasil disimpan!');
    } else {
        // Jika gagal
        session()->setFlashdata('error', 'Terjadi kesalahan saat menyimpan data.');
    }

    // Redirect ke halaman akreditasi
    return redirect()->to(base_url('public/akreditasi'));
  }  

    $data["title"] = "Akreditasi";
    echo view('layouts/header.php', $data);
    echo view('akreditasi/form.php', $data);
    echo view('layouts/footer.php');
  }

}
?>