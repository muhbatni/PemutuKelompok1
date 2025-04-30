<?php
namespace App\Controllers;

use App\Models\SurveyModel;
use \Config\Database;
use App\Models\PertanyaanSurveyModel;
use CodeIgniter\Exceptions\PageNotFoundException;
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
    $data['surveys'] = $this->surveyModel->getActiveSurveys();
    echo view('layouts/header.php', ["title" => "Isi Survey"]);
    echo view('survey_kepuasan/isi_survey/index.php', $data);
    echo view('layouts/footer.php');
  }

  public function isiSurvey($id)
  {
    $survey = $this->surveyModel->find($id);

    if (!$survey) {
      throw new PageNotFoundException("Survey tidak ditemukan.");
    }

    $pertanyaanModel = new PertanyaanSurveyModel();
    $questions = $pertanyaanModel->where('id_survey', $id)
      ->where('is_aktif', true)
      ->orderBy('urutan', 'ASC')
      ->findAll();

    $data['survey'] = $survey;
    $data['questions'] = $questions;

    echo view('layouts/header.php', ["title" => "Isi Survey"]);
    echo view('survey_kepuasan/isi_survey/form.php', $data);
    echo view('layouts/footer.php');
  }
}
?>