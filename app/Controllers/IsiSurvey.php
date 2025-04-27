<?php
namespace App\Controllers;

use App\Models\SurveyModel;
use \Config\Database;
class IsiSurvey extends BaseController
{
  protected $surveyModel;
  public function __construct()
  {
    $this->surveyModel = new SurveyModel();
  }
  public function index()
  {
    $data['surveys'] = $this->surveyModel->paginate(10);
    $data['pager'] = $this->surveyModel->pager;
    echo view('layouts/header.php', ["title" => "Isi Survey"]);
    echo view('survey_kepuasan/isi_survey/index.php', $data);
    echo view('layouts/footer.php');
  }
}
?>