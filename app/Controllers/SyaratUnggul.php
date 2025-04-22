<?php
namespace App\Controllers;
use App\Models\LembagaAkreditasiModel;
use App\Models\SyaratUnggulModel;

class SyaratUnggul extends BaseController
{
  public function index()
  {
  //   //ambil data m_lembaga_akreditasi
  //   $lembagaModel = new LembagaAkreditasiModel();
  //   $data['lembagas'] = $lembagaModel->getLembagas();

  //   if ($this->request->getMethod() == 'POST') {
  //     // Mengambil data dari form
  //     $data = [
  //         'id_lembaga' => $this->request->getPost('id_lembaga'),
  //         'nama' => $this->request->getPost('nama'),
  //     ];

  //     // Simpan data ke database
  //     $model = new SyaratUnggulModel();
  //     $saveResult = $model->insert($data);

  //     if ($saveResult) {
  //         session()->setFlashdata('success', 'Dokumen berhasil disimpan!');
  //     } else {
  //         session()->setFlashdata('error', 'Terjadi kesalahan saat menyimpan data.');
  //     }

  //     return redirect()->to(base_url('public/akreditasi/syarat-unggul'));  // Redirect kembali ke halaman syarat unggul
  // }

    $data["title"] = "Syarat Unggul";
    echo view('layouts/header.php', $data);
    echo view('akreditasi/syarat_unggul/form.php');
    echo view('layouts/footer.php');
  }

}
?>