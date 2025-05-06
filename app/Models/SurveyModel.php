<?php

namespace App\Models;

use CodeIgniter\Model;

class SurveyModel extends Model
{
  protected $table = 's_survey';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true;
  protected $allowedFields = ['id_kriteria', 'kode', 'nama', 'dokumen_pendukung', 'status'];
  protected $returnType = 'array';

  public function getPaginatedSurveys($perPage = 10, $page = null)
  {
    $this->select('s_survey.*');
    $surveys = $this->paginate($perPage, 'default', $page);
    $pager = $this->pager;
    return [
      'surveys' => $surveys,
      'pager' => $pager
    ];
  }

  public function getActiveSurveys()
  {
    $id_user = getDecodedToken()->uid;
    if (!$id_user) {
      return null;
    }
    $tanggalSekarang = date('Y-m-d');
    return $this->select('s_survey.*, s_pelaksanaan_survey.tanggal_mulai, s_pelaksanaan_survey.tanggal_selesai, m_periode.tahun')
      ->join('s_pelaksanaan_survey', 's_pelaksanaan_survey.id_survey = s_survey.id')
      ->join('s_pertanyaan', 's_pertanyaan.id_survey = s_survey.id')
      ->join('m_periode', 'm_periode.id = s_pelaksanaan_survey.id_periode')
      ->where('tanggal_mulai <=', $tanggalSekarang)
      ->where('tanggal_selesai >=', $tanggalSekarang)
      ->where("NOT EXISTS (
        SELECT 1
        FROM s_isian_survey
        WHERE id_user = '$id_user'
          AND id_periode = s_pelaksanaan_survey.id_periode
          AND s_pertanyaan.id_survey = s_pelaksanaan_survey.id_survey)")
      ->groupBy('s_survey.id')
      ->groupBy('m_periode.tahun')
      ->groupBy('s_pelaksanaan_survey.tanggal_mulai')
      ->groupBy('s_pelaksanaan_survey.tanggal_selesai')
      ->findAll();
  }

  public function getSurveyByKodeId($kode, $idSurvey)
  {
    $id_user = getDecodedToken()->uid;
    if (!$id_user) {
      return null;
    }
    $tanggalSekarang = date('Y-m-d');
    return $this->select('s_survey.*, s_survey.id, s_pertanyaan.id_survey AS id_pertanyaan_survey, s_pelaksanaan_survey.id_survey as id_pelaksanaan_survey, s_pelaksanaan_survey.id_periode, s_pelaksanaan_survey.tanggal_mulai, s_pelaksanaan_survey.tanggal_selesai, m_periode.tahun')
      ->join('s_pelaksanaan_survey', 's_pelaksanaan_survey.id_survey = s_survey.id')
      ->join('s_pertanyaan', 's_pertanyaan.id_survey = s_survey.id')
      ->where('tanggal_mulai <=', $tanggalSekarang)
      ->where('tanggal_selesai >=', $tanggalSekarang)
      ->where("NOT EXISTS (
        SELECT 1
        FROM s_isian_survey
        WHERE id_user = '$id_user'
          AND id_periode = s_pelaksanaan_survey.id_periode
          AND s_pertanyaan.id_survey = s_pelaksanaan_survey.id_survey)")
      ->where('kode', $kode)
      ->where('s_survey.id', $idSurvey)->first();
  }
}