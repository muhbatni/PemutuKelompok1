<?php
namespace App\Controllers;

use App\Models\SurveyModel;
use App\Models\PeriodeModel;
use App\Models\PelaksanaanSurveyModel;
use \Config\Database;
use Exception;
use Throwable;
use CodeIgniter\Exceptions\PageNotFoundException;

class PelaksanaanSurvey extends BaseController
{
  protected $surveyModel;
  protected $periodeModel;
  protected $periodeData;
  protected $pelaksanaanSurveyModel;
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
    $this->periodeModel = new PeriodeModel();
    $this->pelaksanaanSurveyModel = new PelaksanaanSurveyModel();
    $this->periodeData = $this->periodeModel->orderBy('id', 'asc')->findAll();
  }

  public function index()
  {
    $data['surveys'] = $this->surveyModel->getActiveSurveys();
    $data['periode'] = $this->periodeData;
    echo view('layouts/header.php', ["title" => "Pelaksanaan Survey"]);
    echo view('survey_kepuasan/pelaksanaan_survey/index.php', $data);
    echo view('layouts/footer.php');
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
      $data = $database->table('s_pelaksanaan_survey s')
        ->select("s.id_survey, s.id_periode, s.deskripsi AS deskripsi_survey, s.tanggal_mulai, s.tanggal_selesai")
        ->where('id_survey', $idSurvey)->get()->getRowArray();
      if (!$data) {
        throw new Exception("Survey tidak ditemukan!");
      }
      $data['id_periode'] = $idPeriode;
      $this->createPelaksanaanSurvey($database, $data);
      $database->close();
      return redirectWithMessage('survey', 'success', 'Pelaksanaan survey berhasil dibuat!');
    } catch (Throwable $exception) {
      log_message('error', 'Database error: ' . $exception->getMessage());
      return redirectWithMessage('survey', 'error', $exception->getMessage());
    }
  }
}
?>