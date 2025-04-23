<?php
namespace App\Controllers;

use App\Models\InstrumenPemutuModel;

class InstrumenPemutu extends BaseController
{
  public function index()
  {

    $lembagaModel = new \App\Models\LembagaAkreditasiModel();
    $data['lembagas'] = $lembagaModel->getLembagas();

    $instrumenModel = new \App\Models\InstrumenPemutuModel();
    $data['instrumen_pemutu'] = $instrumenModel->getInstrumenWithLembaga();


    // Hapus data jika ada parameter 'delete' dari GET
$id = $this->request->getGet('delete');
if (!is_null($id) && $id !== '') {
    $instrumenModel->delete($id);
    session()->setFlashdata('success', 'Data berhasil dihapus!');
    return redirect()->to(base_url('public/akreditasi/instrumen-pemutu'));
}


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
        'id_lembaga' => $id_lembaga,
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