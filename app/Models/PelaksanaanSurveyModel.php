<?php

namespace App\Models;

use CodeIgniter\Model;

class PelaksanaanSurveyModel extends Model
{
  protected $table = 's_pelaksanaan_survey';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true;
  protected $allowedFields = ['id_survey', 'id_periode', 'tanggal_mulai', 'tanggal_selesai', 'deskripsi', 'created_at', 'updated_at'];
  protected $returnType = 'array';

  public function isPeriodSurveyExist($idSurvey, $idPeriode)
  {
    $data = $this->select('id_periode')->where('id_survey', $idSurvey)->where('id_periode', $idPeriode)->first();
    return isset($data['id_periode']) ? true : false;
  }

  public function getPelaksanaanSurvey()
  {
    return $this->select('s_pelaksanaan_survey.*, s_survey.nama, s_survey.kode, s_survey.status, s_survey.id as id_survey, m_periode.tahun')
      ->join('s_survey', 's_survey.id = s_pelaksanaan_survey.id_survey')
      ->join('m_periode', 'm_periode.id = s_pelaksanaan_survey.id_periode')
      ->orderBy('s_pelaksanaan_survey.id', 'DESC')
      ->findAll();
  }
}