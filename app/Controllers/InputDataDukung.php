<?php
namespace App\Controllers;

use App\Models\PelaksanaanAuditModel;
use App\Models\PernyataanModel;
use App\Models\DataDukungModel;

class InputDataDukung extends BaseController
{
  public function index()
  {
    // Get pelaksanaan data for dropdown
    $pelaksanaanModel = new PelaksanaanAuditModel();
    $data['pelaksanaans'] = $pelaksanaanModel->select('id, id')->findAll();

    // Get pernyataan data for dropdown
    $pernyataanModel = new PernyataanModel();
    $data['pernyataans'] = $pernyataanModel->select('id, pernyataan')->findAll();

    // Get pelaksanaan data for dropdown
    $pelaksanaanModel = new DataDukungModel();
    $data['pelaksanaans'] = $pelaksanaanModel->getPelaksanaanList();

    if ($this->request->getMethod() == 'POST') {
      $model = new DataDukungModel();
      
      // Prepare data array
      $data = [
          'id_pelaksanaan' => $this->request->getPost('id_pelaksanaan'),
          'id_pernyataan' => $this->request->getPost('id_pernyataan'),
          'deskripsi' => $this->request->getPost('deskripsi')
      ];

      // Handle file upload
      $dokumen = $this->request->getFile('dokumen');
      if ($dokumen && $dokumen->isValid() && !$dokumen->hasMoved()) {
          $uploadPath = WRITEPATH . 'uploads/data_dukung/';
          if (!is_dir($uploadPath)) {
              mkdir($uploadPath, 0777, true);
          }

          // Gunakan nama asli file
          $fileName = $dokumen->getName();
          
          // Cek apakah file dengan nama yang sama sudah ada
          if (file_exists($uploadPath . $fileName)) {
              $fileInfo = pathinfo($fileName);
              $fileName = $fileInfo['filename'] . '_' . time() . '.' . $fileInfo['extension'];
          }
          
          $dokumen->move($uploadPath, $fileName);
          $data['dokumen'] = $fileName;
      }

      // Save to database
      $saveResult = $model->insert($data);

      if ($saveResult) {
          session()->setFlashdata('success', 'Data berhasil disimpan');
          return redirect()->to(base_url('public/audit/data-dukung'));
      } else {
          session()->setFlashdata('error', 'Terjadi kesalahan saat menyimpan data');
          return redirect()->to(base_url('public/audit/input-data-dukung'));
      }
    }

    $data["title"] = "Tambah Data Dukung";
    echo view('layouts/header.php', $data);
    echo view('audit/data_dukung/form.php', $data);
    echo view('layouts/footer.php');
  }
  public function getPelaksanaanInfo($id)
  {
    $dataDukungModel = new \App\Models\DataDukungModel();
    $info = $dataDukungModel->getPelaksanaanInfo($id);

    return $this->response->setJSON($info);
  }
  public function edit($id)
{
    // Get data dukung by id
    $model = new DataDukungModel();
    $dataDukung = $model->find($id);
    
    if (!$dataDukung) {
        session()->setFlashdata('error', 'Data tidak ditemukan');
        return redirect()->to(base_url('public/audit/data-dukung'));
    }

    // Get pelaksanaan data for dropdown
    $pelaksanaanModel = new PelaksanaanAuditModel();
    $data['pelaksanaans'] = $pelaksanaanModel->select('id')->findAll();

    // Get pernyataan data for dropdown
    $pernyataanModel = new PernyataanModel();
    $data['pernyataans'] = $pernyataanModel->select('id, pernyataan')->findAll();

    $data['dataDukung'] = $dataDukung;
    $data['title'] = 'Edit Data Dukung';

    echo view('layouts/header.php', $data);
    echo view('audit/data_dukung/form.php', $data);
    echo view('layouts/footer.php');
}

public function update($id)
{
    $model = new DataDukungModel();
    
    // Prepare data array
    $data = [
        'id_pelaksanaan' => $this->request->getPost('id_pelaksanaan'),
        'id_pernyataan' => $this->request->getPost('id_pernyataan'),
        'deskripsi' => $this->request->getPost('deskripsi')
    ];

    // Handle file upload if new file is selected
    $dokumen = $this->request->getFile('dokumen');
    if ($dokumen && $dokumen->isValid() && !$dokumen->hasMoved()) {
        $uploadPath = WRITEPATH . 'uploads/data_dukung/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Get old file name to delete
        $oldData = $model->find($id);
        if ($oldData && !empty($oldData['dokumen'])) {
            $oldFile = $uploadPath . $oldData['dokumen'];
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        // Save new file
        $fileName = $dokumen->getName();
        if (file_exists($uploadPath . $fileName)) {
            $fileInfo = pathinfo($fileName);
            $fileName = $fileInfo['filename'] . '_' . time() . '.' . $fileInfo['extension'];
        }
        
        $dokumen->move($uploadPath, $fileName);
        $data['dokumen'] = $fileName;
    }

    // Update database
    $updateResult = $model->update($id, $data);

    if ($updateResult) {
        session()->setFlashdata('success', 'Data berhasil diupdate');
        return redirect()->to(base_url('public/audit/data-dukung'));
    } else {
        session()->setFlashdata('error', 'Terjadi kesalahan saat mengupdate data');
        return redirect()->to(base_url('public/audit/input-data-dukung/edit/' . $id));
    }
}
}
?>