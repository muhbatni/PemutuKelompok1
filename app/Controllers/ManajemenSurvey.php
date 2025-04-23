<?php
namespace App\Controllers;

use App\Models\SurveyModel;
use App\Models\PertanyaanSurveyModel;
use App\Models\PelaksanaanSurveyModel;
use \Config\Database;

class ManajemenSurvey extends BaseController
{
  protected $surveyModel;
  protected $pelaksanaanSurveyModel;
  protected $pertanyaanSurveyModel;
  protected $helpers = ['surveys'];

  private $surveyPlaceholder = [
    'kode' => null,
    'nama' => null,
    'dokumen_pendukung' => null,
    'status' => true,
  ];

  private $pertanyaanSurveyPlaceholder = [
    'id' => null,
    'id_periode' => null,
    'tanggal_mulai' => null,
    'tanggal_selesai' => null,
    'deskripsi' => null,
    'created_at' => null,
  ];

  public function __construct()
  {
    $this->surveyModel = new SurveyModel();
    $this->pelaksanaanSurveyModel = new PelaksanaanSurveyModel();
    $this->pertanyaanSurveyModel = new PertanyaanSurveyModel();
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
      $validation = service('validation');
      $data = $this->request->getPost();
      $data['dokumen_pendukung_survey'] = $this->request->getFile('dokumen_pendukung_survey');
      if (!$validation->run($data, 'surveys')) {
        echo view("layouts/header.php", ["title" => "Manajemen Survey"]);
        echo view(
          "survey_kepuasan/manajemen_survey/create_survey.php",
          ['errors' => $validation->getErrors(), 'old' => $data]
        );
        echo view("layouts/footer.php");
        return null;
      }
      $database = Database::connect();
      $database->transStart();
      $data['id_survey'] = createSurveyData($database, 's_survey', $this->surveyPlaceholder);
      if (!$data['id_survey']) {
        $database->transRollback();
        $database->close();
        return;
      }
      $result = createSurveyData($database, 's_pelaksanaan_survey', $this->pertanyaanSurveyPlaceholder);
      if (!$result) {
        $database->transRollback();
        $database->close();
        return;
      }
      $result = createPertanyaanData($database, $data);
      if (!$result) {
        $database->transRollback();
        $database->close();
        return;
      }
      $database->transCommit();
      $database->close();
      return alert('survey/manajemen-survey', 'success', 'Survey berhasil dibuat!');
    }
    echo view('layouts/header.php', ["title" => "Manajemen Survey"]);
    echo view('survey_kepuasan/manajemen_survey/create_survey.php');
    echo view('layouts/footer.php');
  }

  public function editSurvey($id_survey)
  {
    if ($this->request->getMethod() === "POST") {
      $data = $this->request->getPost();
      $this->surveyModel->update($id_survey, [
        'kode' => $data['kode_survey'] ?: null,
        'nama' => $data['nama_survey'] ?: null,
        'dokumen_pendukung' => $data['dokumen_pendukung_survey'] ?: null,
        'status' => $data['status_survey'] === "true" ? true : false
      ]);
      return alert('survey/manajemen-survey', 'success', 'Survey berhasil diedit!');
    }

    $data['survey'] = $this->surveyModel->find($id_survey);
    if (!$data['survey']) {
      return alert('survey/manajemen-survey', 'error', 'Survey tidak ditemukan!');
    }

    $data['pertanyaan'] = $this->pertanyaanSurveyModel->where('id_survey', $id_survey)->findAll();

    echo view('layouts/header.php', ["title" => "Manajemen Survey"]);
    echo view('survey_kepuasan/manajemen_survey/edit_survey.php', $data);
    echo view('layouts/footer.php');
  }

  public function deleteSurvey($id_survey)
  {
    if (!$id_survey) {
      return;
    }
    if (!$this->surveyModel->delete($id_survey)) {
      return redirect()->to(base_url('public/survey/manajemen-survey'))->with('error', 'Survey gagal dihapus!');
    }
    return redirect()->to(base_url('public/survey/manajemen-survey'))->with('success', 'Survey berhasil dihapus!');
  }
}
?>