<?php
namespace App\Controllers;

use App\Models\DokumenPenetapanModel;

class DokumenPenetapan extends BaseController
{
  public function index()
  {
    $model = new DokumenPenetapanModel();

    // Hapus data
    if ($this->request->getGet('delete')) {
      $id = $this->request->getGet('delete');
      $data = $model->find($id);
      if ($data && !empty($data['dokumen'])) {
        $filePath = WRITEPATH . 'uploads/akreditasi/dokumen-penetapan/' . $data['dokumen'];
        if (file_exists($filePath)) {
          unlink($filePath); // hapus file fisik
        }
      }
      $model->delete($id);
      session()->setFlashdata('success', 'Dokumen berhasil dihapus!');
      return redirect()->to(base_url('public/akreditasi/dokumen-penetapan'));
    }

    // Edit data
    $editData = null;
    if ($this->request->getGet('edit')) {
      $id = $this->request->getGet('edit');
      $editData = $model->find($id);
    }

    // Simpan data (create/update)
    if ($this->request->getMethod() == 'POST') {
      $id = $this->request->getPost('id');
      $data = [
        'nomor' => $this->request->getPost('nomor'),
        'tanggal' => $this->request->getPost('tanggal'),
        'nama' => $this->request->getPost('nama'),
        'deskripsi' => $this->request->getPost('deskripsi'),
      ];

      $dokumen = $this->request->getFile('dokumen');
      if ($dokumen && $dokumen->isValid() && !$dokumen->hasMoved()) {
        $uploadPath = WRITEPATH . 'uploads/akreditasi/dokumen-penetapan/';
        if (!is_dir($uploadPath)) {
          mkdir($uploadPath, 0777, true);
        }

        $fileName = $dokumen->getRandomName();
        $dokumen->move($uploadPath, $fileName);
        $data['dokumen'] = $fileName;

        // Jika update, hapus file lama
        if ($id) {
          $oldData = $model->find($id);
          if ($oldData && !empty($oldData['dokumen'])) {
            $oldPath = $uploadPath . $oldData['dokumen'];
            if (file_exists($oldPath)) {
              unlink($oldPath);
            }
          }
        }
      }

      if ($id) {
        $model->update($id, $data);
        session()->setFlashdata('success', 'Dokumen berhasil diperbarui!');
      } else {
        $model->save($data);
        session()->setFlashdata('success', 'Dokumen berhasil disimpan!');
      }

      return redirect()->to(base_url('public/akreditasi/dokumen-penetapan'));
    }

    // Ambil semua data dokumen
    $data['title'] = "Dokumen Penetapan";
    $data['dokumen_penetapan'] = $model->findAll();
    $data['edit'] = $editData;

    echo view('layouts/header.php', $data);
    echo view('akreditasi/dokumen_penetapan/form.php');
    echo view('layouts/footer.php');
  }
}