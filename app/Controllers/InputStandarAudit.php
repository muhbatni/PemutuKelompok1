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

  public function edit($id)
{
    $model = new StandarModel();
    $data['standar'] = $model->find($id);

    // Jika data tidak ditemukan, redirect ke halaman daftar standar
    if (!$data['standar']) {
      return redirect()->to(base_url('public/audit/input-standar'))->with('error', 'Standar tidak ditemukan!');
  }

    // Tampilkan form edit dengan data yang sudah ada
    $data["title"] = "Edit Standar Audit";
    echo view('layouts/header.php', $data);
    echo view('audit/standar_audit/form.php', $data); // Form edit
    echo view('layouts/footer.php');
}

public function update($id)
{
    $model = new StandarModel();

    // Ambil data dari form untuk update
    $parent = $this->request->getPost('parent');
    $parent = ($parent === null || $parent === '') ? null : $parent;

    // Data yang akan diupdate
    $data = [
        'nama' => $this->request->getPost('judul'),
        'id_parent' => $parent,
        'dokumen' => $this->request->getPost('deskripsi'),
        'is_aktif' => $this->request->getPost('is_aktif') == '1' ? true : false
    ];

    // Update data berdasarkan ID
    $updateStatus = $model->update($id, $data);

    // Periksa apakah data berhasil diperbarui
    if ($updateStatus === false) {
        // Jika gagal, tampilkan error
        session()->setFlashdata('error', 'Data gagal diperbarui.');
        return redirect()->to(base_url('public/audit/input-standar/edit/' . $id));
    }

    // Redirect setelah berhasil mengedit
    session()->setFlashdata('success', 'Data berhasil diperbarui!');
    return redirect()->to(base_url('public/audit/standar'));
}
}
?>