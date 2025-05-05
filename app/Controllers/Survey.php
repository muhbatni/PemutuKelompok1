<?php
namespace App\Controllers;

use App\Models\SurveyModel;
use App\Models\IsiSurveyModel;
use App\Models\PertanyaanSurveyModel;
use App\Models\PelaksanaanSurveyModel;
use App\Models\PeriodeModel;
use \Config\Database;

class Survey extends BaseController
{
  protected $surveyModel;
  protected $pelaksanaanSurveyModel;
  protected $pertanyaanSurveyModel;
  protected $isiSurveyModel;
  protected $periodeModel;
  protected $isianSurveyModel;
  protected $helpers = ['surveys'];

  protected $periodeData;

  private $surveyPlaceholder = [
    'kode' => null,
    'nama' => null,
    'dokumen_pendukung' => null,
    'status' => true,
  ];

  private $pelaksanaanSurveyPlaceholder = [
    'id_survey' => null,
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
    $this->isiSurveyModel = new IsiSurveyModel();
    $this->periodeData = $this->periodeModel->orderBy('id', 'asc')->findAll();
  }

  public function getIndex()
  {
    $data = $this->surveyModel->getPaginatedSurveys(10);
    echo view('layouts/header.php', ["title" => "Manajemen Survey"]);
    echo view('survey_kepuasan/manajemen_survey/index.php', $data);
    echo view('layouts/footer.php');
  }

  public function getCreate()
  {
    echo view('layouts/header.php', ["title" => "Manajemen Survey"]);
    echo view('survey_kepuasan/manajemen_survey/create_survey.php', ['periode' => $this->periodeData]);
    echo view('layouts/footer.php');
  }

  private function createSurvey($database, $data)
  {
    $data['id_survey'] = createSurveyData($database, 's_survey', $this->surveyPlaceholder, [
      'kode' => $data['kode_survey'],
      'nama' => $data['nama_survey'],
      'dokumen_pendukung' => $data['dokumen_pendukung_survey'],
      'status' => $data['status_survey'],
    ]);

    if (!$data['id_survey']) {
      throw new \Exception('Gagal membuat data survey!');
    }
    return $data['id_survey'];
  }

  private function createPelaksanaanSurvey($database, $data)
  {
    $result = createSurveyData($database, 's_pelaksanaan_survey', $this->pelaksanaanSurveyPlaceholder, [
      'id_survey' => $data['id_survey'],
      'id_periode' => $data['id_periode'],
      'tanggal_mulai' => $data['tanggal_mulai'],
      'tanggal_selesai' => $data['tanggal_selesai'],
      'deskripsi' => $data['deskripsi_survey'],
      'created_at' => date('Y-m-d H:i:s'),
    ]);

    if (!$result) {
      throw new \Exception('Gagal membuat data pelaksanaan survey!');
    }
    return $result;
  }

  private function createPertanyaanSurvey($database, $data)
  {
    $result = createPertanyaanData($database, $data);
    if (!$result) {
      throw new \Exception('Gagal membuat data pertanyaan survey!');
    }
    return $result;
  }

  private function editSurvey($database, $data)
  {
    $result = editSurveydata($database, 's_survey', [
      'kode' => $data['kode_survey'],
      'nama' => $data['nama_survey'],
      'dokumen_pendukung' => $data['dokumen_pendukung_survey'],
      'status' => $data['status_survey'],
    ], $data['id_survey']);
    if (!$result) {
      throw new \Exception('Gagal mengupdate survey!');
    }
    return $result;
  }

  private function editPelaksanaanSurvey($database, $data)
  {
    if (!$this->pelaksanaanSurveyModel->isPeriodSurveyExist($data['id_survey'], $data['id_periode'])) {
      $result = createSurveyData($database, 's_pelaksanaan_survey', $this->pelaksanaanSurveyPlaceholder, [
        'id_survey' => $data['id_survey'],
        'id_periode' => $data['id_periode'],
        'tanggal_mulai' => $data['tanggal_mulai'],
        'tanggal_selesai' => $data['tanggal_selesai'],
        'deskripsi' => $data['deskripsi_survey'],
        'created_at' => date('Y-m-d H:i:s'),
      ]);
      if (!$result) {
        throw new \Exception('Gagal membuat data pelaksanaan survey!');
      }
      return $result;
    }
    $result = editSurveydata($database, 's_pelaksanaan_survey', [
      'id_survey' => $data['id_survey'],
      'tanggal_mulai' => $data['tanggal_mulai'],
      'tanggal_selesai' => $data['tanggal_selesai'],
      'deskripsi' => $data['deskripsi_survey'],
      'created_at' => date('Y-m-d H:i:s'),
    ], $data['id_periode'], 'id_periode');
    if (!$result) {
      throw new \Exception('Gagal mengupdate data pelaksanaan survey!');
    }
    return $result;
  }

  private function editPertanyaanSurvey($database, $data)
  {
    $result = editPertanyaanData($database, $data);
    if (!$result) {
      throw new \Exception('Gagal mengupdate pertanyaan survey!');
    }
    return $result;
  }

  public function postCreate()
  {
    $validation = service('validation');
    $data = $this->request->getPost();
    $data['dokumen_pendukung_survey'] = $this->request->getFile('dokumen_pendukung_survey');
    if (!$validation->run($data, 'surveys')) {
      log_message('error', 'Validation failed: ' . json_encode($validation->getErrors()));
      echo view("layouts/header.php", ["title" => "Manajemen Survey"]);
      echo view(
        "survey_kepuasan/manajemen_survey/create_survey.php",
        ['errors' => $validation->getErrors(), 'old' => $data, 'periode' => $this->periodeData]
      );
      echo view("layouts/footer.php");
      return null;
    }

    $file = $data['dokumen_pendukung_survey'];
    if ($file->isValid()) {
      $data['dokumen_pendukung_survey'] = handleUpload("survey/dokumen_pendukung", $file);
    }

    $database = Database::connect();
    $database->transStart();
    try {
      $data['id_survey'] = $this->createSurvey($database, $data);
      $this->createPelaksanaanSurvey($database, $data);
      $this->createPertanyaanSurvey($database, $data);
      $database->transCommit();
      $database->close();
      return redirectWithMessage('survey', 'success', 'Survey berhasil dibuat!');
    } catch (\Exception $exception) {
      $database->transRollback();
      $database->close();
      log_message('error', 'Database error: ' . $exception->getMessage());
      return redirectWithMessage('survey', 'error', 'Gagal membuat survey: ' . $exception->getMessage());
    }
  }

  public function getDelete()
  {
    $uri = $this->request->getUri();
    $params = $uri->getQuery(['only' => ['id_survey']]);
    $params = explode('=', $params);
    if (count($params) < 2) {
      return redirectWithMessage('survey', 'error', 'Survey tidak ditemukan!');
    }
    $idSurvey = $params[1];
    if (!$this->surveyModel->delete($idSurvey)) {
      return redirect()->to(base_url('public/survey'))->with('error', 'Survey gagal dihapus!');
    }
    return redirect()->to(base_url('public/survey'))->with('success', 'Survey berhasil dihapus!');
  }

  public function getEdit()
  {
    $uri = $this->request->getUri();
    $params = $uri->getQuery(['only' => ['id_survey']]);
    $params = explode('=', $params);
    if (count($params) < 2) {
      return redirectWithMessage('survey', 'error', 'Survey tidak ditemukan!');
    }
    $idSurvey = $params[1];
    $data['survey'] = $this->surveyModel->find($idSurvey);
    if (!$data['survey']) {
      return redirectWithMessage('survey', 'error', 'Survey tidak ditemukan!');
    }
    $data['pelaksanaan_survey'] = $this->pelaksanaanSurveyModel->where('id_survey', $idSurvey)->first();
    if (!$data['pelaksanaan_survey']) {
      return redirectWithMessage('survey', 'error', 'Pelaksanaan survey tidak ditemukan!');
    }
    $data['periode'] = $this->periodeData;
    $data['pertanyaan'] = $this->pertanyaanSurveyModel->where('id_survey', $idSurvey)->orderBy('urutan', 'asc')->findAll();
    echo view('layouts/header.php', ["title" => "Manajemen Survey"]);
    echo view('survey_kepuasan/manajemen_survey/edit_survey.php', $data);
    echo view('layouts/footer.php');
  }

  public function postEdit()
  {
    $uri = $this->request->getUri();
    $params = $uri->getQuery(['only' => ['id_survey']]);
    $params = explode('=', $params);
    if (count($params) < 2) {
      return redirectWithMessage('survey', 'error', 'Survey tidak ditemukan!');
    }
    $idSurvey = $params[1];
    if (!$this->surveyModel->find($idSurvey)) {
      return redirectWithMessage('survey', 'error', 'Survey tidak ditemukan!');
    }
    $data = $this->request->getPost();
    $data['id_survey'] = $idSurvey;
    $data['dokumen_pendukung_survey'] = $this->request->getFile('dokumen_pendukung_survey');
    $file = $data['dokumen_pendukung_survey'];
    if ($file->isValid()) {
      $data['dokumen_pendukung_survey'] = handleUpload('survey/dokumen-pendukung', $file) ?? null;
    }
    $database = Database::connect();
    $database->transStart();
    try {
      $this->editSurvey($database, $data);
      $this->editPelaksanaanSurvey($database, $data);
      $this->editPertanyaanSurvey($database, $data);
      $database->transCommit();
      $database->close();
      return redirectWithMessage('survey', 'success', 'Survey berhasil diupdate!');
    } catch (\Exception $exception) {
      $database->transRollback();
      $database->close();
      log_message('error', 'Database error: ' . $exception->getMessage());
      return redirectWithMessage('survey', 'error', 'Gagal mengupdate survey: ' . $exception->getMessage());
    }
  }

  public function getView()
  {
    $uri = $this->request->getUri();
    $params = $uri->getQuery(['only' => ['id_survey']]);
    $params = explode('=', $params);
    if (count($params) < 2) {
      return redirectWithMessage('survey', 'error', 'Survey tidak ditemukan!');
    }
    $idSurvey = $params[1];
    $surveyData = $this->isiSurveyModel->getHasilSurveyById($idSurvey);
    if (!$surveyData) {
      return redirectWithMessage('survey', 'error', 'Data hasil survey masih kosong!');
    }
    $data['survey']['nama'] = $surveyData[0]['nama'];
    foreach ($surveyData as $survey) {
      if (!isset($data['survey']['data'][$survey['id_pertanyaan']])) {
        $data['survey']['data'][$survey['id_pertanyaan']] = [
          'teks' => $survey['teks'],
          'jenis' => $survey['jenis'],
          'id_pertanyaan' => $survey['id_pertanyaan'],
          'jawaban' => ($survey['jenis'] == 1) ? $this->isiSurveyModel->getOptionSummaryById($idSurvey, $survey['id_pertanyaan']) : []
        ];
      }
      if ($survey['jenis'] == 2) {
        $data['survey']['data'][$survey['id_pertanyaan']]['jawaban'][] = [
          'id_pengisi' => $survey['id_user'],
          'teks' => $survey['jawaban'],
        ];
      }
    }

    echo view('layouts/header.php', ["title" => "Manajemen Survey"]);
    echo view('survey_kepuasan/manajemen_survey/view_survey.php', $data);
    echo view('layouts/footer.php');
  }
}
?>