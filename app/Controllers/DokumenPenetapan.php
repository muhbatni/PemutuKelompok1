<?php
namespace App\Controllers;

use App\Models\DokumenPenetapanModel;

class DokumenPenetapan extends BaseController
{

  protected $DokumenPenetapanModel;

  public function __construct()
  {
    $this->DokumenPenetapanModel = new DokumenPenetapanModel();
  }

  public function input()
  {
    $model = new DokumenPenetapanModel();

    // Ambil ID jika ada
    $id = $this->request->getGet('id');
    $edit = null;

    // Kalau ada ID, ambil data lama untuk ditampilkan di form
    if ($id) {
      $edit = $model->where('id', $id)->first();
      if (!$edit) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
      }
    }

    // Jika disubmit (POST)
    if ($this->request->getMethod() === 'POST') {
      $data = [
        'nomor' => $this->request->getPost('nomor'),
        'tanggal' => $this->request->getPost('tanggal'),
        'nama' => $this->request->getPost('nama'),
        'deskripsi' => $this->request->getPost('deskripsi'),
      ];

      // Tangani upload file
      $file = $this->request->getFile('dokumen');
      if ($file && $file->isValid() && !$file->hasMoved()) {
        $fileName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads/akreditasi/dokumen-penetapan/', $fileName);
        $data['dokumen'] = $fileName;

        // Hapus file lama jika update
        if ($id && !empty($edit['dokumen'])) {
          $oldPath = WRITEPATH . 'uploads/akreditasi/dokumen-penetapan/' . $edit['dokumen'];
          if (file_exists($oldPath)) {
            unlink($oldPath);
          }
        }
      }

      // Update jika ID ada, insert jika tidak
      if ($id) {
        $model->update($id, $data);
        session()->setFlashdata('success', 'Data berhasil diperbarui.');
      }

      return redirect()->to(base_url('akreditasi/dokumen-penetapan'));
    }

    // Tampilkan form
    $data = [
      'title' => $id ? 'Edit Dokumen Penetapan' : 'Tambah Dokumen Penetapan',
      'isEdit' => $id ? true : false,
      'edit' => $edit,
    ];

    echo view('layouts/header', $data);
    echo view('akreditasi/dokumen_penetapan/form', $data);
    echo view('layouts/footer');
  }

  // Fungsi untuk mengunduh file dokumen
  public function download($filename)
  {
    $path = WRITEPATH . 'uploads/akreditasi/dokumen-penetapan/' . $filename;
    if (!file_exists($path)) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan.');
    }

    return $this->response->download($path, null);
  }

  public function index()
  {
    $model = new DokumenPenetapanModel();

    // Hapus data
    if ($this->request->getGet('delete')) {
      $id = $this->request->getGet('delete');
      $data = $model->where('id', $id)->first();
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
          $oldData = $model->where('id', $id)->first();
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
    echo view('akreditasi/dokumen_penetapan/tables.php');
    echo view('layouts/footer.php');
  }
}