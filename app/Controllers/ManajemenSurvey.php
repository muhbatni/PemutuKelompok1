<?php
namespace App\Controllers;

use App\Models\SurveyModel;
use App\Models\PertanyaanSurveyModel;
use App\Models\PelaksanaanSurveyModel;
use App\Models\PeriodeModel;
use \Config\Database;

class ManajemenSurvey extends BaseController
{
  protected $surveyModel;
  protected $pelaksanaanSurveyModel;
  protected $pertanyaanSurveyModel;
  protected $periodeModel;
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
    $this->periodeModel = new PeriodeModel();
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
    $periodeModel = new PeriodeModel();
    $periode = $periodeModel->findAll();

    if ($this->request->getMethod() === "POST") {
      $validation = service('validation');
      $data = $this->request->getPost();
      $data['dokumen_pendukung_survey'] = $this->request->getFile('dokumen_pendukung_survey');
      if (!$validation->run($data, 'surveys')) {
        echo view("layouts/header.php", ["title" => "Manajemen Survey"]);
        echo view(
          "survey_kepuasan/manajemen_survey/create_survey.php",
          ['errors' => $validation->getErrors(), 'old' => $data, 'periode' => $periode]
        );
        echo view("layouts/footer.php");
        return null;
      }

      $data['dokumen_pendukung_survey'] = $this->request->getFile('dokumen_pendukung_survey');
      $file = $data['dokumen_pendukung_survey'];
      if ($file->isValid()) {
        $data['dokumen_pendukung_survey'] = handleUpload('survey/dokumen-pendukung', $file) ?? null;
      }

      $database = Database::connect();
      $database->transStart();
      $data['id_survey'] = createSurveyData($database, 's_survey', $this->surveyPlaceholder, [
        'kode' => $data['kode_survey'],
        'nama' => $data['nama_survey'],
        'dokumen_pendukung' => $data['dokumen_pendukung_survey'],
        'status' => $data['status_survey'],
      ]);
      if (!$data['id_survey']) {
        $database->transRollback();
        $database->close();
        return redirectWithMessage('survey/manajemen-survey', 'error', 'Gagal membuat survey!');
      }
      $result = createSurveyData($database, 's_pelaksanaan_survey', $this->pertanyaanSurveyPlaceholder, [
        'id' => $data['id_survey'],
        'id_periode' => $data['id_periode'],
        'tanggal_mulai' => $data['tanggal_mulai'],
        'tanggal_selesai' => $data['tanggal_selesai'],
        'deskripsi' => $data['deskripsi_survey'],
        'created_at' => date('Y-m-d H:i:s'),
      ]);
      if (!$result) {
        $database->transRollback();
        $database->close();
        return redirectWithMessage('survey/manajemen-survey', 'error', 'Gagal membuat survey!');
      }
      $result = createPertanyaanData($database, $data);
      if (!$result) {
        $database->transRollback();
        $database->close();
        return redirectWithMessage('survey/manajemen-survey', 'error', 'Gagal membuat survey!');
      }
      $database->transCommit();
      $database->close();
      return redirectWithMessage('survey/manajemen-survey', 'success', 'Survey berhasil dibuat!');
    }
    echo view('layouts/header.php', ["title" => "Manajemen Survey"]);
    echo view('survey_kepuasan/manajemen_survey/create_survey.php', ['periode' => $periode]);
    echo view('layouts/footer.php');
  }

  public function editSurvey($idSurvey)
  {
    if ($this->request->getMethod() === "POST") {
      $data = $this->request->getPost();
      $data['dokumen_pendukung_survey'] = $this->request->getFile('dokumen_pendukung_survey');
      $file = $data['dokumen_pendukung_survey'];
      if ($file->isValid()) {
        $data['dokumen_pendukung_survey'] = handleUpload('survey/dokumen-pendukung', $file) ?? null;
      }
      $database = Database::connect();
      $database->transStart();
      $data['id_survey'] = $idSurvey;
      editSurveydata($database, 's_survey', [
        'kode' => $data['kode_survey'],
        'nama' => $data['nama_survey'],
        'dokumen_pendukung' => $data['dokumen_pendukung_survey'],
        'status' => $data['status_survey'],
      ], $idSurvey);
      if (!$idSurvey) {
        $database->transRollback();
        $database->close();
        return redirectWithMessage('survey/manajemen-survey', 'error', 'Gagal mengupdate pertanyaan survey!');
      }
      $result = editSurveydata($database, 's_pelaksanaan_survey', [
        'id_periode' => $data['id_periode'],
        'tanggal_mulai' => $data['tanggal_mulai'],
        'tanggal_selesai' => $data['tanggal_selesai'],
        'deskripsi' => $data['deskripsi_survey'],
        'created_at' => date('Y-m-d H:i:s'),
      ], $idSurvey);
      if (!$result) {
        $database->transRollback();
        $database->close();
        return redirectWithMessage('survey/manajemen-survey', 'error', 'Gagal mengupdate pertanyaan survey!');
      }
      $result = editPertanyaanData($database, $data);
      if (!$result) {
        $database->transRollback();
        $database->close();
        return redirectWithMessage('survey/manajemen-survey', 'error', 'Gagal mengupdate pertanyaan survey!');
      }
      $database->transCommit();
      $database->close();
      return redirectWithMessage('survey/manajemen-survey', 'success', 'Survey berhasil diupdate!');
    }

    $data['survey'] = $this->surveyModel->find($idSurvey);
    if (!$data['survey']) {
      return redirectWithMessage('survey/manajemen-survey', 'error', 'Survey tidak ditemukan!');
    }
    $data['pelaksanaan_survey'] = $this->pelaksanaanSurveyModel->where('id', $idSurvey)->first();
    if (!$data['pelaksanaan_survey']) {
      return redirectWithMessage('survey/manajemen-survey', 'error', 'Pelaksanaan survey tidak ditemukan!');
    }
    $data['periode'] = $this->periodeModel->findAll();
    $data['pertanyaan'] = $this->pertanyaanSurveyModel->where('id_survey', $idSurvey)->orderBy('urutan', 'asc')->findAll();
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