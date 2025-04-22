<?php
namespace App\Controllers;

use App\Models\StandarAuditModel;

class InputStandarAudit extends BaseController
{
  public function index()
  {
    // Jika form disubmit (POST)
    if ($this->request->getMethod() === 'POST') {
      $model = new StandarAuditModel();

    // Ambil data dari form
    $data = [
      'nama' => $this->request->getPost('judul'),
      'id_parent' => $this->request->getPost('parent'),
      'dokumen' => $this->request->getPost('deskripsi'),
      'is_aktif' => $this->request->getPost('is_aktif') == '1' ? true : false
    ];

    // Simpan ke DB
    $model->insert($data);

    // Redirect dengan flashdata sukses
    return redirect()->to(base_url('public/audit/input-standar'))->with('success', 'Data berhasil ditambahkan!');
  }

  // Tampilkan form (GET)
    $data["title"] = "Input Standar Audit";
    echo view('layouts/header.php', $data);
    echo view('audit/standar_audit/form.php');
    echo view('layouts/footer.php');

  }

}
?>