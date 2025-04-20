<?php
namespace App\Controllers;

use App\Models\SurveyModel;
class ManajemenSurvey extends BaseController
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

    echo view('layouts/header.php', ["title" => "Manajemen Survey"]);
    echo view('survey_kepuasan/manajemen_survey/index.php', $data);
    echo view('layouts/footer.php');
  }

  public function createSurvey()
  {
    if ($this->request->getMethod() === "POST") {
      $data = [
        'kode' => $this->request->getPost('kode_survey') ?: null,
        'nama' => $this->request->getPost('nama_survey') ?: null,
        'dokumen_pendukung' => $this->request->getPost('dokumen_pendukung_survey'),
        'status' => $this->request->getPost('status_survey') === "true" ? true : false
      ];
      $this->surveyModel->insert($data);
      return redirect()->to(base_url('public/survey/manajemen-survey'))->with('success', 'Survey berhasil dibuat!');
    }
    echo view('layouts/header.php', ["title" => "Manajemen Survey"]);
    echo view('survey_kepuasan/manajemen_survey/create_survey.php');
    echo view('layouts/footer.php');
  }

  public function editSurvey($id_survey)
  {
    if ($this->request->getMethod() === "POST") {
      $data = [
        'kode' => $this->request->getPost('kode_survey') ?: null,
        'nama' => $this->request->getPost('nama_survey') ?: null,
        'dokumen_pendukung' => $this->request->getPost('dokumen_pendukung_survey'),
        'status' => $this->request->getPost('status_survey') === "true" ? true : false
      ];
      $this->surveyModel->update($id_survey, $data);
      return redirect()->to(base_url('public/survey/manajemen-survey'))->with('success', 'Survey berhasil diedit!');
    }
    $data['survey'] = $this->surveyModel->find($id_survey);
    if (!$data['survey']) {
      return redirect()->to(base_url('public/survey/manajemen-survey'))->with('error', 'Survey tidak ditemukan!');
    }
    echo view('layouts/header.php', ["title" => "Manajemen Survey"]);
    echo view('survey_kepuasan/manajemen_survey/edit_survey.php', $data);
    echo view('layouts/footer.php');
  }

  public function deleteSurvey($id_survey)
  {
    $survey = $this->surveyModel->find($id_survey);
    if ($survey) {
      $this->surveyModel->delete($id_survey);
      return redirect()->to(base_url('public/survey/manajemen-survey'))->with('success', 'Survey berhasil dihapus!');
    }
    return redirect()->to(base_url('public/survey/manajemen-survey'))->with('error', 'Survey tidak ditemukan!');
  }
}
?>