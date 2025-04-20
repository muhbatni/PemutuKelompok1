<?php
namespace App\Controllers;

use App\Models\SurveyModel;
use App\Models\PertanyaanSurveyModel;
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
      $id_survey = $this->surveyModel->insert($data);

      $pertanyaan = $this->request->getPost('pertanyaan');
      $jenis = $this->request->getPost('jenis');

      if ($pertanyaan && $jenis) {
        $pertanyaanData = [];
        foreach ($pertanyaan as $index => $teks) {
          $jenisValue = isset($jenis[$index]) && is_numeric($jenis[$index]) ? (int) $jenis[$index] : null;
          if ($jenisValue === null || empty($teks)) {
            continue;
          }
          $pertanyaanData[] = [
            'id_survey' => $id_survey,
            'teks' => $teks,
            'jenis' => $jenis[$index],
            'is_aktif' => true,
            'updated_at' => date('Y-m-d H:i:s'),
          ];
        }
        $pertanyaanSurveyModel = new \App\Models\PertanyaanSurveyModel();
        $pertanyaanSurveyModel->insertBatch($pertanyaanData);
      }
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
}
?>