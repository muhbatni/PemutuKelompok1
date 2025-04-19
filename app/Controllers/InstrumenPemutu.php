<?php
namespace App\Controllers;

use App\Models\InstrumenPemutuModel;

class InstrumenPemutu extends BaseController
{
  public function index()
  {
    // Jika form disubmit (metode POST)
    if ($this->request->getMethod() == 'POST') {
      // Ambil data dari form
      $id_lembaga = $this->request->getPost('id_lembaga');
      $jenjang = $this->request->getPost('jenjang');
      $indikator = $this->request->getPost('indikator');
      $kondisi = $this->request->getPost('kondisi');
      $batas = $this->request->getPost('batas');

      if (!is_numeric($batas)) {
        return redirect()->back()->withInput()->with('error', 'Batas harus berupa angka.');
      }


      // Simpan data ke database
      $model = new InstrumenPemutuModel();
      $data = [
        'nomor' => $id_lembaga,
        'jenjang' => $jenjang,
        'indikator' => $indikator,
        'kondisi' => $kondisi,
        'batas' => $batas,
      ];
      $model->save($data);

      // Set flashdata untuk pemberitahuan sukses
      session()->setFlashdata('success', 'Berhasil disimpan!');
      return redirect()->to(base_url('public/akreditasi/instrumen-pemutu')); // Kembali ke halaman yang sama
    }

    $data["title"] = "Instrumen Pemutu";
    echo view('layouts/header.php', $data);
    echo view('akreditasi/instrumen_pemutu/form.php');
    echo view('layouts/footer.php');
  }

}
?>