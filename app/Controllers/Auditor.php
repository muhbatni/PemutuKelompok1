<?php
namespace App\Controllers;

use App\Models\AuditorModel;

class Auditor extends BaseController
{
    public function index()
    {
        $model = new AuditorModel();
        
        if ($this->request->getGet('delete')) {
            $id = $this->request->getGet('delete');
            $model->delete($id);
            session()->setFlashdata('success', 'Data auditor berhasil dihapus!');
            return redirect()->to(base_url('audit/input_auditor'));
        }

        $data['auditor'] = $model->getAll();
        $data['title'] = 'Data Auditor';

        echo view('layouts/header', $data);
        echo view('audit/input_auditor/tables.php', $data); 
        echo view('layouts/footer');
    }
}
?>