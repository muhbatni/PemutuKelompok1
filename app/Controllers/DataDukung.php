<?php
namespace App\Controllers;

use App\Models\DataDukungModel;

class DataDukung extends BaseController
{
  public function index()
    {
        $model = new DataDukungModel();
        $data = [
            "title" => "Data Dukung",
            "dataDukung" => $model->getDataDukung()
        ];
        
    echo view('layouts/header.php', $data);
    echo view('audit/data_dukung/tables.php', $data);
    echo view('layouts/footer.php');
  }
  
}
?>