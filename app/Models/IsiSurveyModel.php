<?php

namespace App\Models;

use CodeIgniter\Model;

class IsiSurveyModel extends Model
{

  protected $table = 's_isian_survey';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true;
  protected $allowedFields = ['id_pertanyaan', 'jawaban', 'id_user'];
  protected $returnType = 'array';

  public function getPertanyaanBySurvey($idSurvey)
  {
    return $this->select('s_pertanyaan.*, s_isian_survey.*')
      ->join('s_pertanyaan', 's_pertanyaan.id = s_isian_survey.id_pertanyaan')
      ->where('s_pertanyaan.id_survey', $idSurvey)
      ->findAll();
  }
}