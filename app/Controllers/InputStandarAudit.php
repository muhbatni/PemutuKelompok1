<?php
namespace App\Controllers;

use App\Models\StandarModel;
use App\Libraries\APIClient;

class InputStandarAudit extends BaseController
{
    public function index()
    {
        if ($this->request->getMethod() === 'POST') {
            $model = new StandarModel();
            $data['standar'] = $model->orderBy('id', 'ASC')->findAll();

            $parent = $this->request->getPost('id_parent'); // nama harus sama seperti di form
            $parent = ($parent === null || $parent === '') ? null : $parent;

            $data = [
                'nama' => $this->request->getPost('judul'),
                'dokumen' => $this->request->getPost('dokumen'),
                'is_aktif' => $this->request->getPost('is_aktif') == '1' ? true : false
            ];

            if ($parent) {
                if ($model->getStandarsById($parent)) {
                    $data['id_parent'] = $parent;
                }
            }

            $dokumen = $this->request->getFile('dokumen');
            if ($dokumen && $dokumen->isValid() && !$dokumen->hasMoved()) {
                $uploadPath = WRITEPATH . 'uploads/dokumen/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                // Menggunakan nama asli file
                $fileName = $dokumen->getClientName();
                $dokumen->move($uploadPath, $fileName);
                $data['dokumen'] = $fileName;
            }

            $model->insert($data);

            return redirect()->to(base_url('public/audit/standar'))->with('success', 'Data berhasil ditambahkan!');
        }

        // Jika GET
        $model = new StandarModel();
        $data['standars'] = $model->orderBy('id', 'ASC')->findAll(); // Tambahkan ini
        $data['title'] = "Input Standar Audit";
        $data['isEdit'] = false;
        $data['edit'] = null;

        echo view('layouts/header.php', $data);
        echo view('audit/standar_audit/form.php', $data);
        echo view('layouts/footer.php');
    }

    public function edit($id)
    {
        $model = new StandarModel();
        $standar = $model->find($id);

        if (!$standar) {
            return redirect()->to(base_url('public/audit/input-standar'))->with('error', 'Standar tidak ditemukan!');
        }

        $data['title'] = "Edit Standar Audit";
        $data['standar'] = $standar;
        $data['edit'] = $standar;
        $data['isEdit'] = true;
        $data['standars'] = $model->orderBy('id', 'ASC')->findAll(); // Untuk dropdown parent

        echo view('layouts/header.php', $data);
        echo view('audit/standar_audit/form.php', $data);
        echo view('layouts/footer.php');
    }

    public function update($id)
    {
        $model = new StandarModel();
        $parent = $this->request->getPost('id_parent'); // nama harus sama seperti di form
        $parent = ($parent === null || $parent === '') ? null : $parent;

        $data = [
            'nama' => $this->request->getPost('judul'),
            'is_aktif' => $this->request->getPost('is_aktif') == '1' ? true : false
        ];
        if ($parent) {
            if ($model->getStandarsById($parent)) {
                $data['id_parent'] = $parent;
            }
        }

        $dokumen = $this->request->getFile('dokumen');

        if ($dokumen && $dokumen->isValid() && !$dokumen->hasMoved()) {
            $uploadPath = WRITEPATH . 'uploads/dokumen/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $fileName = $dokumen->getClientName();
            $dokumen->move($uploadPath, $fileName);
            $data['dokumen'] = $fileName;
        }

        $updateStatus = $model->update($id, $data);

        if ($updateStatus === false) {
            session()->setFlashdata('error', 'Data gagal diperbarui.');
            return redirect()->to(base_url('public/audit/input-standar/edit/' . $id));
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