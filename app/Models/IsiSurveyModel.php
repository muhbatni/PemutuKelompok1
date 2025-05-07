<?php

namespace App\Models;

use CodeIgniter\Model;

class IsiSurveyModel extends Model
{

  protected $table = 's_isian_survey';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true;
  protected $allowedFields = ['id_pertanyaan', 'jawaban', 'id_user', 'id_periode'];
  protected $returnType = 'array';

  public function getHasilSurvey($idSurvey, $idPeriode)
  {
    return $this->select('s_pertanyaan.*, s_pertanyaan.id AS id_pertanyaan, s_isian_survey.*, s_survey.*')
      ->join('s_pertanyaan', 's_pertanyaan.id = s_isian_survey.id_pertanyaan')
      ->join('s_survey', 's_survey.id = s_pertanyaan.id_survey')
      ->where('s_pertanyaan.id_survey', $idSurvey)
      ->where('s_isian_survey.id_periode', $idPeriode)
      ->findAll();
  }

  public function getOptionSummaryById($idSurvey, $idPertanyaan, $idPeriode)
  {
    return $this->select('jawaban, COUNT(jawaban) as jumlah')
      ->join('s_pertanyaan', 's_pertanyaan.id = s_isian_survey.id_pertanyaan')
      ->where('s_pertanyaan.id_survey', $idSurvey)
      ->where('s_pertanyaan.jenis', 1)
      ->where('s_pertanyaan.id', $idPertanyaan)
      ->where('s_isian_survey.id_periode', $idPeriode)
      ->groupBy('jawaban')
      ->orderBy('jawaban', 'ASC')
      ->findAll();
  }
}