<?php
namespace App\Controllers;

use App\Models\AuditorModel;
use App\Models\UserModel;

class InputAuditor extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->findAll(); 
        $data["title"] = "Auditor";
        echo view('layouts/header.php', $data);
        echo view('audit/input_auditor/form.php',$data);
        echo view('layouts/footer.php');
    }

    public function simpan()
    {
        $model = new AuditorModel();

        $file = $this->request->getFile('dokumen');
        $newName = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName(); 
            $file->move('uploads/', $newName);
        }

        // Ambil data lain dari form
        $data = [
            'id' => $this->request->getPost('id'),
            'dokumen' => $newName,
            'id_user' => $this->request->getPost('id_user'),
        ];

        $model->simpanAuditor($data);

        return redirect()->to('/inputauditor')->with('success', 'Data berhasil disimpan.');
    }
}
