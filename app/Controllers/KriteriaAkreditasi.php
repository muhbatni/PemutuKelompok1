<?php
namespace App\Controllers;

use App\Models\KriteriaAkreditasiModel;

class KriteriaAkreditasi extends BaseController
{
  public function index()
  {

    $lembagaModel = new \App\Models\LembagaAkreditasiModel();
    $data['lembagas'] = $lembagaModel->getLembagas();
    // Jika form disubmit (metode POST)
    if ($this->request->getMethod() == 'POST') {
      // Ambil data dari form
      $InputIdLembaga = $this->request->getPost('id_lembaga');
      $InputKode = $this->request->getPost('kode');
      $InputNama = $this->request->getPost('nama');

      // Simpan data ke database
      $model = new KriteriaAkreditasiModel();
      $data = [
        'id_lembaga' => $InputIdLembaga,
        'kode' => $InputKode,
        'nama' => $InputNama,
      ];
      $model->save($data);

      // Set flashdata untuk pemberitahuan sukses
      session()->setFlashdata('success', 'Berhasil disimpan!');
      return redirect()->to(base_url('public/akreditasi/kriteria')); // Kembali ke halaman yang sama
    }

    $data["title"] = "Kriteria Akreditasi";
    echo view('layouts/header.php', $data);
    echo view('akreditasi/kriteria_akreditasi/form.php');
    echo view('layouts/footer.php');
  }

}
?>