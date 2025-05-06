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

        // Handle multiple file uploads
        $files = $this->request->getFiles();
        $uploadedFiles = [];
        
        if(isset($files['dokumen'])) {
            foreach($files['dokumen'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $uploadPath = WRITEPATH . 'uploads/audit/data_dukung/';
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }

                    $fileName = $file->getName();
                    
                    // Handle duplicate filenames
                    if (file_exists($uploadPath . $fileName)) {
                        $fileInfo = pathinfo($fileName);
                        $fileName = $fileInfo['filename'] . '_' . time() . '_' . rand(100, 999) . '.' . $fileInfo['extension'];
                    }
                    
                    $file->move($uploadPath, $fileName);
                    $uploadedFiles[] = $fileName;
                }
            }
            
            if (!empty($uploadedFiles)) {
                $data['dokumen'] = implode('|', $uploadedFiles);
            }
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

  public function getPernyataanInfo($id)
    {
    $model = new DataDukungModel();
    $info = $model->getPernyataanInfo($id);
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

    // Handle multiple file uploads if new files are selected
    $files = $this->request->getFiles();
    $uploadedFiles = [];
    
    if(isset($files['dokumen'])) {
        // Get old data to delete existing files
        $oldData = $model->find($id);
        if ($oldData && !empty($oldData['dokumen'])) {
            $uploadPath = WRITEPATH . 'uploads/audit/data_dukung/';
            $oldFiles = explode('|', $oldData['dokumen']);
            
            // Delete old files
            foreach($oldFiles as $oldFile) {
                $filePath = $uploadPath . $oldFile;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        // Upload new files
        foreach($files['dokumen'] as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $uploadPath = WRITEPATH . 'uploads/audit/data_dukung/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $fileName = $file->getName();
                
                // Handle duplicate filenames
                if (file_exists($uploadPath . $fileName)) {
                    $fileInfo = pathinfo($fileName);
                    $fileName = $fileInfo['filename'] . '_' . time() . '_' . rand(100, 999) . '.' . $fileInfo['extension'];
                }
                
                $file->move($uploadPath, $fileName);
                $uploadedFiles[] = $fileName;
            }
        }
        
        if (!empty($uploadedFiles)) {
            $data['dokumen'] = implode('|', $uploadedFiles);
        }
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
public function delete($id)
  {
      $model = new DataDukungModel();
      
      // Get data first to check if file exists
      $dataDukung = $model->find($id);
      
      if ($dataDukung) {
          // Delete file if exists
          if (!empty($dataDukung['dokumen'])) {
              $uploadPath = WRITEPATH . 'uploads/audit/data_dukung/';
              $filePath = $uploadPath . $dataDukung['dokumen'];
              if (file_exists($filePath)) {
                  unlink($filePath);
              }
          }
          
          // Delete from database
          if ($model->delete($id)) {
              session()->setFlashdata('success', 'Data berhasil dihapus');
          } else {
              session()->setFlashdata('error', 'Gagal menghapus data');
          }
      } else {
          session()->setFlashdata('error', 'Data tidak ditemukan');
      }
      
      return redirect()->to(base_url('public/audit/data-dukung'));
  }
}
?>