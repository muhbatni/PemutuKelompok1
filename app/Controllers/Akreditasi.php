<?php
namespace App\Controllers;
use App\Models\UnitModel;
use App\Models\LembagaAkreditasiModel;
use App\Models\AkreditasiModel;

class Akreditasi extends BaseController
{

  public function input()
{
  // Ambil data unit
  $unitModel = new UnitModel();
  $data['units'] = $unitModel->getUnits();

  // Ambil data lembaga akreditasi
  $lembagaModel = new LembagaAkreditasiModel();
  $data['lembagas'] = $lembagaModel->getLembagas();

  // Ambil data akreditasi
  $akreditasiModel = new AkreditasiModel();
  $data['dataAkreditasi'] = $akreditasiModel->getAkreditasiData();

  // Jika ada ID di URL untuk edit
  $editData = null;
  if ($this->request->getGet('id')) {
    $id = $this->request->getGet('id');
    // Ambil data berdasarkan ID
    $editData = $akreditasiModel->find($id);
    if ($editData) {
      $data['editData'] = $editData;
      if (!empty($editData['file'])) {
        $data['uploadedFile'] = $editData['file'];
    }
    }

    // Ambil nama unit dan lembaga berdasarkan ID yang diambil
    $unitName = '';
    foreach ($data['units'] as $unit) {
      if ($unit['id'] == $editData['id_unit']) {
        $unitName = $unit['nama'];
        break;
      }
    }

    // Ambil nama lembaga
    $lembagaName = '';
    foreach ($data['lembagas'] as $lembaga) {
      if ($lembaga['id'] == $editData['id_lembaga']) {
        $lembagaName = $lembaga['nama'];
        break;
      }
    }

    // Mengirim data unit dan lembaga ke view
    $data['unitName'] = $unitName;
    $data['lembagaName'] = $lembagaName;
    $data['dataAkreditasi'] = $editData;
  }

  // Kirim data ke view, jika tidak ada edit data, set dataAkreditasi ke null
  if (!isset($data['dataAkreditasi'])) {
    $data['dataAkreditasi'] = null;
  }

  // Jika form disubmit
  if ($this->request->getMethod() == 'POST') {
    $id = $this->request->getPost('id');

    $existingData = null;
    if ($id) {
      $existingData = $akreditasiModel->find($id);
    }

    // Mengambil data dari form
    $dataForm = [
      'id_unit' => $this->request->getPost('id_unit'),
      'id_lembaga' => $this->request->getPost('id_lembaga'),
      'status' => $this->request->getPost('status'),
      'tanggal_berlaku' => $this->request->getPost('tanggal_berlaku'),
      'tanggal_habis' => $this->request->getPost('tanggal_habis'),
      'nilai' => $this->request->getPost('nilai_akreditasi'),
      'is_active' => $this->request->getPost('is_active') === '1' ? true : false,
    ];

    $file = $this->request->getFile('file_upload');
    if ($file && $file->isValid() && !$file->hasMoved()) {
      $uploadPath = WRITEPATH . 'uploads/akreditasi/';
      if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0777, true);
      }
      $fileName = $file->getRandomName();
      $file->move($uploadPath, $fileName);
      $dataForm['file'] = $fileName;
    }

    $id = $this->request->getPost('id');
    if ($id) {
      $akreditasiModel->update($id, $dataForm);
      session()->setFlashdata('success', 'Data berhasil diperbarui!');
    } else {
      // Jika tidak ada ID, maka insert data baru
      $akreditasiModel->insert($dataForm);
      session()->setFlashdata('success', 'Data berhasil disimpan!');
    }

    return redirect()->to(base_url('public/akreditasi'));
  }

  $data["title"] = "Data Akreditasi";
  echo view('layouts/header.php', $data);
  echo view('akreditasi/form.php', $data);
  echo view('layouts/footer.php');
}

  public function index()
  {

    $unitModel = new UnitModel();
    $lembagaModel = new LembagaAkreditasiModel();
    $akreditasiModel = new AkreditasiModel();
  
    $data['units'] = $unitModel->getUnits();
    $data['lembagas'] = $lembagaModel->getLembagas();
    $akreditasiModel = new AkreditasiModel();
    $data['dataAkreditasi'] = $akreditasiModel->getAkreditasiData();

    // Jika ada ID di URL untuk edit
    if ($this->request->getGet('delete')) {
      $id = $this->request->getGet('delete');
      $deleteResult = $akreditasiModel->delete($id);

      if ($deleteResult) {
        session()->setFlashdata('success', 'Data berhasil dihapus!');
      } else {
        session()->setFlashdata('error', 'Terjadi kesalahan saat menghapus data!');
      }

      return redirect()->to(base_url('public/akreditasi'));
    }

    $data["title"] = "Akreditasi";
    echo view('layouts/header.php', $data);
    echo view('akreditasi/tables.php', $data);
    echo view('layouts/footer.php');
  }

  public function download($filename)
  {
    // Tentukan path folder tempat file disimpan
    $path = WRITEPATH . 'uploads/akreditasi/' . $filename;

    // Periksa apakah file ada di server
    if (file_exists($path)) {
      // Atur header untuk mengunduh file
      return $this->response->download($path, null)->setFileName($filename);
    } else {
      // Jika file tidak ditemukan
      throw new \CodeIgniter\Exceptions\PageNotFoundException("File tidak ditemukan.");
    }
  }
}
?>