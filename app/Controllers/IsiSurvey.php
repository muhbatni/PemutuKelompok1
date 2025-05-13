<?php
namespace App\Controllers;

use App\Models\SurveyModel;
use App\Models\PertanyaanSurveyModel;
use App\Models\IsiSurveyModel;
use Exception;
use CodeIgniter\Exceptions\PageNotFoundException;
class IsiSurvey extends BaseController
{
  protected $surveyModel;
  protected $pertanyaanSurveyModel;
  protected $isiSurveyModel;

  public function __construct()
  {
    $this->surveyModel = new SurveyModel();
    $this->pertanyaanSurveyModel = new PertanyaanSurveyModel();
    $this->isiSurveyModel = new IsiSurveyModel();
  }
  public function index()
  {
    $data['surveys'] = $this->surveyModel->getActiveSurveys();
    echo view('layouts/header.php', ["title" => "Isi Survey"]);
    echo view('survey_kepuasan/isi_survey/index.php', $data);
    echo view('layouts/footer.php');
  }

  public function isiSurvey($segment)
  {
    $explodedSegment = explode('-', $segment);
    $kode = $explodedSegment[0];
    $id = $explodedSegment[1];
    $survey = $this->surveyModel->getSurveyByKodeId($kode, $id);
    if (!$survey) {
      return redirectWithMessage('isi-survey', 'error', 'Survey tidak ditemukan.');
    }

    $id_user = getDecodedToken()->uid;
    if (!$id_user) {
      return redirectWithMessage('isi-survey', 'error', 'Anda tidak bisa mengisi survey!');
    }

    if ($this->request->getMethod() === "POST") {
      $postData = $this->request->getPost();
      $data = [];
      foreach ($postData['answers'] as $id_pertanyaan => $jawaban) {
        $data[] = [
          'id_pertanyaan' => $id_pertanyaan,
          'jawaban' => $jawaban,
          'id_user' => $id_user,
          'id_periode' => $survey['id_periode']
        ];
      }
      try {
        $this->isiSurveyModel->insertBatch($data);
        return redirectWithMessage('isi-survey', 'success', 'Survey berhasil diisi!');
      } catch (Exception $exception) {
        log_message('error', 'Database error: ' . $exception->getMessage());
        return redirectWithMessage('isi-survey', 'error', 'Survey gagal diisi!');
      }
    }

    $questions = $this->pertanyaanSurveyModel->where('id_survey', $id)
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