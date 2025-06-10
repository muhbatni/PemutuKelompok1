<?php
namespace App\Controllers;

use App\Libraries\APIClient;
use App\Models\SurveyModel;
use App\Models\PeriodeModel;
use App\Models\PelaksanaanSurveyModel;
use Exception;

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

  public function getIndex()
  {
    $data['pelaksanaan'] = APIClient::getPelaksanaanSurvey()['data'];
    $data['surveys'] = $this->surveyModel->findAll();
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

}
?>