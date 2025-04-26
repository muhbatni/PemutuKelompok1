<?php
namespace App\Controllers;

use App\Models\StandarModel;

class InputStandarAudit extends BaseController
{
  public function index()
  {
    // Jika form disubmit (POST)
    if ($this->request->getMethod() === 'POST') {
      $model = new StandarModel();

      // Ambil input parent dan konversi jika kosong
    $parent = $this->request->getPost('parent');
    $parent = ($parent === null || $parent === '') ? null : $parent;


    // Ambil data dari form
    $data = [
      'nama' => $this->request->getPost('judul'),
      'id_parent' => $parent,
      'dokumen' => $this->request->getPost('deskripsi'),
      'is_aktif' => $this->request->getPost('is_aktif') == '1' ? true : false
    ];

    // Simpan ke DB
    $model->insert($data);

    // Redirect langsung ke halaman tables setelah berhasil disimpan
      return redirect()->to(base_url('public/audit/standar'))->with('success', 'Data berhasil ditambahkan!');
  }

  // Tampilkan form (GET)
    $data["title"] = "Input Standar Audit";
    echo view('layouts/header.php', $data);
    echo view('audit/standar_audit/form.php');
    echo view('layouts/footer.php');

  }


}
?>