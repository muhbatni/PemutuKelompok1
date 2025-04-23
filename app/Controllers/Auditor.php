<?php
namespace App\Controllers;

use App\Models\AuditorModel;

class Auditor extends BaseController
{
    public function index()
    {
        $model = new AuditorModel();
        $data['auditor'] = $model->getAll();
        $data['title'] = 'Data Auditor';

        echo view('layouts/header', $data);
        echo view('audit/input_auditor/tables.php', $data); 
        echo view('layouts/footer');
    }
}
?>