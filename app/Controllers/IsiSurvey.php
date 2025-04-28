<?php
namespace App\Controllers;

use App\Models\SurveyModel;
use \Config\Database;
use App\Models\PertanyaanSurveyModel;
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

  public function isiSurvey($id)
  {
    // Ambil data survey berdasarkan ID
    $survey = $this->surveyModel->find($id);

    if (!$survey) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException("Survey dengan ID $id tidak ditemukan.");
    }

    // Ambil pertanyaan terkait survey dari tabel s_pertanyaan
    $pertanyaanModel = new PertanyaanSurveyModel();
    $questions = $pertanyaanModel->where('id_survey', $id)
      ->where('is_aktif', true) // Hanya pertanyaan aktif
      ->orderBy('urutan', 'ASC') // Urutkan berdasarkan kolom urutan
      ->findAll();

    $data['survey'] = $survey;
    $data['questions'] = $questions;

    echo view('layouts/header.php', ["title" => "Isi Survey"]);
    echo view('survey_kepuasan/isi_survey/form.php', $data);
    echo view('layouts/footer.php');
  }
}
?>