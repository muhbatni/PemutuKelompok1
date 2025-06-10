<?php
namespace App\Controllers;

use App\Models\SurveyModel;
use App\Models\IsiSurveyModel;
use App\Models\PertanyaanSurveyModel;
use App\Models\PelaksanaanSurveyModel;
use App\Models\PeriodeModel;
use CodeIgniter\Database\Query;
use \Config\Database;
use App\Models\KriteriaAkreditasiModel;
use Exception;
use Throwable;

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
  protected $kriteriaAkreditasiModel;
  protected $kriteriaAkreditasiData;

  private $surveyPlaceholder = [
    'kode' => null,
    'nama' => null,
    'dokumen_pendukung' => null,
    'status' => true,
    'id_kriteria' => null,
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
    $this->kriteriaAkreditasiModel = new KriteriaAkreditasiModel();
    $this->kriteriaAkreditasiData = $this->kriteriaAkreditasiModel->orderBy('id', 'asc')->findAll();
  }

  public function getIndex()
  {
    $data = $this->surveyModel->getPaginatedSurveys(10);
    $data['periode'] = $this->periodeModel->orderBy('id', 'asc')->findAll();
    $data['kriteria'] = $this->kriteriaAkreditasiData;
    echo view('layouts/header.php', ["title" => "Manajemen Survey"]);
    echo view('survey_kepuasan/manajemen_survey/index.php', $data);
    echo view('layouts/footer.php');
  }

  public function getCreate()
  {
    echo view('layouts/header.php', ["title" => "Manajemen Survey"]);
    echo view('survey_kepuasan/manajemen_survey/create_survey.php', ['periode' => $this->periodeData, 'kriteria' => $this->kriteriaAkreditasiData]);
    echo view('layouts/footer.php');
  }

  private function createSurvey($database, $data)
  {
    $data['id_survey'] = createSurveyData($database, 's_survey', $this->surveyPlaceholder, [
      'kode' => $data['kode_survey'],
      'nama' => $data['nama_survey'],
      'dokumen_pendukung' => $data['dokumen_pendukung_survey'],
      'status' => $data['status_survey'],
      'id_kriteria' => empty($data['id_kriteria']) ? null : $data['id_kriteria'],
    ]);

    if (!$data['id_survey']) {
      throw new Exception('Gagal membuat data survey!');
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
      throw new Exception('Gagal membuat data pelaksanaan survey!');
    }
    return $result;
  }

  private function createPertanyaanSurvey($database, $data)
  {
    $result = createPertanyaanData($database, $data);
    if (!$result) {
      throw new Exception('Gagal membuat data pertanyaan survey!');
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
      'id_kriteria' => $data['id_kriteria'],
    ], $data['id_survey']);
    if (!$result) {
      throw new Exception('Gagal mengupdate survey!');
    }
    return $result;
  }

  private function editPelaksanaanSurvey($database, $data)
  {
    $result = editSurveydata($database, 's_pelaksanaan_survey', [
      'tanggal_mulai' => $data['tanggal_mulai'],
      'tanggal_selesai' => $data['tanggal_selesai'],
      'deskripsi' => $data['deskripsi_survey'],
      'created_at' => date('Y-m-d H:i:s'),
    ], $data['id_periode'], 'id_periode');
    if (!$result) {
      log_message('error', 'Edit Pelaksanaan Survey: ' . json_encode($result));
      throw new Exception('Gagal mengupdate data pelaksanaan survey!');
    }
    return $result;
  }

  private function editPertanyaanSurvey($database, $data)
  {
    $result = editPertanyaanData($database, $data);
    if (!$result) {
      throw new Exception('Gagal mengupdate pertanyaan survey!');
    }
    return $result;
  }

  public function postCreate()
  {
    $validation = service('validation');
    $data = $this->request->getPost();
    $data['dokumen_pendukung_survey'] = $this->request->getFile('dokumen_pendukung_survey');
    if (!$validation->run($data, 'create_surveys')) {
      log_message('error', 'Validation failed: ' . json_encode($validation->getErrors()));
      echo view("layouts/header.php", ["title" => "Manajemen Survey"]);
      echo view(
        "survey_kepuasan/manajemen_survey/create_survey.php",
        ['errors' => $validation->getErrors(), 'old' => $data, 'periode' => $this->periodeData, 'kriteria' => $this->kriteriaAkreditasiData]
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
      $this->createPertanyaanSurvey($database, $data);
      $database->transCommit();
      $database->close();
      return redirectWithMessage('survey', 'success', 'Survey berhasil dibuat!');
    } catch (Throwable $exception) {
      $database->transRollback();
      $database->close();
      log_message('error', 'Database error: ' . $exception->getMessage());
      return redirectWithMessage('survey', 'error', 'Gagal membuat survey: ' . $exception->getMessage());
    }
  }

  public function getDelete()
  {
    $params = $this->request->getGet();
    if (!isset($params['id_survey'])) {
      return redirectWithMessage("survey", 'error', 'Survey tidak ditemukan');
    }
    $idSurvey = $params['id_survey'];
    if (!$this->surveyModel->delete($idSurvey)) {
      return redirect()->to(base_url('public/survey'))->with('error', 'Survey gagal dihapus!');
    }
    return redirect()->to(base_url('public/survey'))->with('success', 'Survey berhasil dihapus!');
  }

  public function getEdit()
  {
    $params = $this->request->getGet();
    if (!isset($params['id_survey'])) {
      return redirectWithMessage("survey", 'error', 'Survey tidak ditemukan');
    }
    $idSurvey = $params['id_survey'];
    $data['survey'] = $this->surveyModel->find($idSurvey);
    if (!$data['survey']) {
      return redirectWithMessage('survey', 'error', 'Survey tidak ditemukan!');
    }
    $data['pelaksanaan_survey'] = $this->pelaksanaanSurveyModel->where('id_survey', $idSurvey)->first();
    if (!$data['pelaksanaan_survey']) {
      return redirectWithMessage('survey', 'error', 'Pelaksanaan survey tidak ditemukan!');
    }
    $data['periode'] = $this->pelaksanaanSurveyModel
      ->select('s_pelaksanaan_survey.id_periode AS id, m_periode.tahun')
      ->join('m_periode', 'm_periode.id = s_pelaksanaan_survey.id_periode')
      ->where('s_pelaksanaan_survey.id_survey', $idSurvey)
      ->findAll();
    if (!$data['periode']) {
      return redirectWithMessage('survey', 'error', 'Periode survey tidak ditemukan!');
    }
    $data['kriteria'] = $this->kriteriaAkreditasiData;
    $data['pertanyaan'] = $this->pertanyaanSurveyModel->where('id_survey', $idSurvey)->orderBy('urutan', 'asc')->findAll();
    echo view('layouts/header.php', ["title" => "Manajemen Survey"]);
    echo view('survey_kepuasan/manajemen_survey/edit_survey.php', $data);
    echo view('layouts/footer.php');
  }

  public function postEdit()
  {
    $params = $this->request->getPostGet();
    if (!isset($params['id_survey'])) {
      return redirectWithMessage("survey", 'error', 'Survey tidak ditemukan');
    }
    $idSurvey = $params['id_survey'];
    if (!$this->surveyModel->find($idSurvey)) {
      return redirectWithMessage('survey', 'error', 'Survey tidak ditemukan!');
    }
    $validation = service('validation');
    $data = $this->request->getPost();
    if (!$validation->run($data, 'edit_surveys')) {
      log_message('error', 'Validation failed: ' . json_encode($validation->getErrors()));
      echo view("layouts/header.php", ["title" => "Manajemen Survey"]);
      echo view(
        "survey_kepuasan/manajemen_survey/edit_survey.php",
        ['errors' => $validation->getErrors(), 'old' => $data, 'idSurvey' => $idSurvey, 'periode' => $this->periodeData, 'kriteria' => $this->kriteriaAkreditasiData]
      );
      echo view("layouts/footer.php");
      return null;
    }
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
    } catch (Throwable $exception) {
      $database->transRollback();
      $database->close();
      log_message('error', 'Database error: ' . $exception->getMessage());
      return redirectWithMessage("survey/edit?id_survey=$idSurvey", 'error', 'Gagal mengupdate survey: ' . $exception->getMessage());
    }
  }

  public function getView()
  {
    $params = $this->request->getGet();
    $database = Database::connect();
    $idSurvey = $params['id_survey'];
    $data['periode'] = $database->table('m_periode')->select('id_periode, tahun')->distinct(true)
      ->join('s_isian_survey', 'm_periode.id = s_isian_survey.id_periode')
      ->join('s_pertanyaan', 's_pertanyaan.id = s_isian_survey.id_pertanyaan')
      ->where('id_survey', $idSurvey)->get()->getResult();
    if (!$data['periode']) {
      return redirectWithMessage('survey', 'error', 'Data hasil survey masih kosong!');
    }
    $idPeriode = $data['periode'][0]->id_periode;
    if (isset($params['id_periode'])) {
      $idPeriode = $params['id_periode'];
    }
    $surveyData = $this->isiSurveyModel->getHasilSurvey($idSurvey, $idPeriode);
    if (!$surveyData) {
      return redirectWithMessage('survey', 'error', 'Data hasil survey masih kosong!');
    }
    $data['survey']['id'] = $surveyData[0]['id'];
    $data['survey']['nama'] = $surveyData[0]['nama'];
    foreach ($surveyData as $survey) {
      if (!isset($data['survey']['data'][$survey['id_pertanyaan']])) {
        $data['survey']['data'][$survey['id_pertanyaan']] = [
          'teks' => $survey['teks'],
          'jenis' => $survey['jenis'],
          'id_pertanyaan' => $survey['id_pertanyaan'],
          'jawaban' => ($survey['jenis'] == 1) ? $this->isiSurveyModel->getOptionSummaryById($idSurvey, $survey['id_pertanyaan'], $idPeriode) : []
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

  public function postCreatePelaksanaan()
  {
    try {
      $params = $this->request->getPostGet();
      if (!isset($params['id_survey'])) {
        throw new Exception("Survey tidak ditemukan!");
      }
      $idSurvey = $params['id_survey'];
      $idPeriode = $this->request->getPost('id_periode');
      $database = Database::connect();
      $isExist = $this->pelaksanaanSurveyModel->isPeriodSurveyExist($idSurvey, $idPeriode);
      if ($isExist) {
        throw new Exception("Pelaksanaan survey sudah ada pada periode ini!");
      }
      $survey = $this->surveyModel->find($idSurvey);
      // $data = $database->table('s_pelaksanaan_survey s')
      //   ->select("s.id_survey, s.id_periode, s.deskripsi AS deskripsi_survey, s.tanggal_mulai, s.tanggal_selesai")
      //   ->where('id_survey', $idSurvey)->get()->getRowArray();
      if (!$survey) {
        throw new Exception("Survey tidak ditemukan!");
      }
      $data['id_periode'] = $idPeriode;
      $data['id_survey'] = $idSurvey;
      $data['tanggal_mulai'] = $this->request->getPost('tanggal_mulai');
      $data['tanggal_selesai'] = $this->request->getPost('tanggal_selesai');
      $data['deskripsi_survey'] = $this->request->getPost('deskripsi_survey');
      if (empty($data['tanggal_mulai']) || empty($data['tanggal_selesai'])) {
        throw new Exception("Tanggal mulai dan selesai tidak boleh kosong!");
      }
      $this->createPelaksanaanSurvey($database, $data);
      $database->close();
      return redirectWithMessage('pelaksanaan-survey', 'success', 'Pelaksanaan survey berhasil dibuat!');
    } catch (Throwable $exception) {
      log_message('error', 'Database error: ' . $exception->getMessage());
      return redirectWithMessage('pelaksanaan-survey', 'error', $exception->getMessage());
    }
  }

  public function getDownload()
  {
    try {
      $params = $this->request->getGet();
      if (!isset($params['id_survey']) || !isset($params['id_periode'])) {
        return redirectWithMessage('survey', 'error', 'Survey atau periode tidak ditemukan!');
      }
      $idSurvey = $params['id_survey'];
      $idPeriode = $params['id_periode'];
      $surveyData = $this->isiSurveyModel->getHasilSurvey($idSurvey, $idPeriode);
      if (!$surveyData) {
        return redirectWithMessage('survey', 'error', 'Data hasil survei masih kosong!');
      }
      $database = Database::connect();
      $results = $database->table('s_isian_survey i')
        ->select('p.teks AS pertanyaan, p.jenis AS jenis_pertanyaan, i.jawaban AS jawaban')
        ->join('s_pertanyaan p', 'p.id = i.id_pertanyaan')
        ->join('s_survey s', 's.id = p.id_survey')
        ->where('s.id', $idSurvey)
        ->where('i.id_periode', $idPeriode)
        ->get()->getResult();
      $filename = "hasil_survey_$idSurvey" . "_periode_$idPeriode" . "_" . date('Y-m-d') . ".csv";
      header("Content-Type: application/csv");
      header("Content-Disposition: attachment; filename=$filename");
      $output = fopen('php://output', 'w');
      if (!$output) {
        log_message('error', 'Gagal membuka output stream');
        return redirectWithMessage('survey', 'error', 'Gagal membuka output stream.');
      }
      fputcsv($output, ['Nomor', 'Pertanyaan', 'Jenis Jawaban', 'Jawaban']);
      $number = 1;
      foreach ($results as $result) {
        $data = [
          $number++,
          $result->pertanyaan,
          $result->jenis_pertanyaan,
          $result->jawaban
        ];
        fputcsv($output, $data);
      }
      fclose($output);
    } catch (Throwable $exception) {
      log_message('error', 'Download error: ' . $exception->getMessage());
      return redirectWithMessage('survey', 'error', 'Gagal mengunduh hasil survei: ' . $exception->getMessage());
    }
  }
}
?>