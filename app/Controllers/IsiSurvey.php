<?php
namespace App\Controllers;

use App\Models\SurveyModel;
use \Config\Database;
class IsiSurvey extends BaseController
{
  protected $surveyModel;
  protected $pelaksanaanSurveyModel;
  public function __construct()
  {
    $this->surveyModel = new SurveyModel();
    $this->pelaksanaanSurveyModel = new \App\Models\PelaksanaanSurveyModel();
  }
  public function index()
  {
    // $data['pager'] = $this->surveyModel->pager;
    $data['surveys'] = $this->surveyModel->getActiveSurveys();
    // $data['surveys'] = $this->surveyModel->paginate(10);

    echo view('layouts/header.php', ["title" => "Isi Survey"]);
    echo view('survey_kepuasan/isi_survey/index.php', $data);
    echo view('layouts/footer.php');
  }
}
?>