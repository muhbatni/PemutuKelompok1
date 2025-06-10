<?php
namespace App\Controllers;

use App\Libraries\APIClient;

class InputStandarAudit extends BaseController
{
  public function index()
  {

    if ($this->request->getMethod() === 'POST') {
      $id_parent = $this->request->getPost('id_parent');
      $id_parent = ($id_parent === null || $id_parent === '') ? null : $id_parent;

      $nama = $this->request->getPost('judul');
      $is_aktif = $this->request->getPost('is_aktif') === '1' ? true : false;

      $dokumenFile = $this->request->getFile('dokumen');
      $fileName = '';

      if ($dokumenFile && $dokumenFile->isValid() && !$dokumenFile->hasMoved()) {
        $uploadPath = WRITEPATH . 'uploads/dokumen/';
        if (!is_dir($uploadPath)) {
          mkdir($uploadPath, 0777, true);
        }

        $fileName = $dokumenFile->getClientName();
        $dokumenFile->move($uploadPath, $fileName);
      }

      // Kirim ke APIClient
      $response = APIClient::createStandarWithParams(
        $id_parent,
        $nama,
        $fileName,
        $is_aktif
      );

      if (!$response || isset($response['error'])) {
        echo "<pre>";
        echo "DATA YANG DIKIRIM:\n";
        print_r([
          'id_parent' => $id_parent,
          'nama' => $nama,
          'dokumen' => $fileName,
          'is_aktif' => $is_aktif
        ]);
        echo "\nRESPON DARI API:\n";
        print_r($response);
        echo "</pre>";
        exit;
      }

      return redirect()->to(base_url('public/audit/standar'))->with('success', 'Data berhasil ditambahkan!');
    }

    // Ambil daftar standar yang sudah ada untuk pilihan parent
    $data['standars'] = APIClient::getAllStandar();
    $data['title'] = "Input Standar Audit";
    $data['isEdit'] = false;
    $data['edit'] = null;

    echo view('layouts/header.php', $data);
    echo view('audit/standar_audit/form.php', $data);
    echo view('layouts/footer.php');
  }

  public function edit($id)
  {
    $standar = APIClient::getStandar($id);

    if (!$standar || isset($standar['error'])) {
      return redirect()->to(base_url('public/audit/input-standar'))->with('error', 'Standar tidak ditemukan!');
    }

    $allStandars = APIClient::getAllStandar();

    $data['title'] = "Edit Standar Audit";
    $data['standar'] = $standar;
    $data['edit'] = $standar;
    $data['isEdit'] = true;
    $data['standars'] = $allStandars;

    echo view('layouts/header.php', $data);
    echo view('audit/standar_audit/form.php', $data);
    echo view('layouts/footer.php');
  }

  public function update($id)
  {
    $parent = $this->request->getPost('id_parent');
    $parent = ($parent === null || $parent === '') ? null : $parent;

    $nama = $this->request->getPost('judul');
    $isAktif = $this->request->getPost('is_aktif') == '1' ? true : false;

    $dokumen = $this->request->getFile('dokumen');
    $dokumenName = null;

    if ($dokumen && $dokumen->isValid() && !$dokumen->hasMoved()) {
      $uploadPath = WRITEPATH . 'uploads/dokumen/';
      if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0777, true);
      }

      $dokumenName = $dokumen->getClientName();
      $dokumen->move($uploadPath, $dokumenName);
    }

    // Data yang dikirim ke API
    $data = [
      'nama' => $nama,
      'is_aktif' => $isAktif,
      'id_parent' => $parent,
    ];

    if ($dokumenName) {
      $data['dokumen'] = $dokumenName;
    }

    $response = APIClient::updateStandar($id, $data);

    if (!$response || isset($response['error'])) {
      echo "<pre>";
      echo "DATA YANG DIKIRIM:\n";
      print_r([
        'id_parent' => $parent,
        'nama' => $nama,
        'dokumen' => $dokumenName,
        'is_aktif' => $isAktif
      ]);
      echo "\nRESPON DARI API:\n";
      print_r($response);
      echo "</pre>";
      exit;
    }


    if (isset($response['error'])) {
      session()->setFlashdata('error', 'Gagal memperbarui data: ' . $response['error']);
      return redirect()->to(base_url("public/audit/input-standar/edit/$id"));
    }

    session()->setFlashdata('success', 'Data berhasil diperbarui!');
    return redirect()->to(base_url('public/audit/standar'));
  }

  public function download($fileName)
  {
    $filePath = WRITEPATH . 'uploads/dokumen/' . $fileName;

    if (file_exists($filePath)) {
      return $this->response->download($filePath, null)->setFileName($fileName);
    }

    return redirect()->to(base_url('public/audit/standar'))->with('error', 'File tidak ditemukan!');
  }

}
?>