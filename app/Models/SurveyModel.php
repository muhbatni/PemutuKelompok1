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
    $this->select('s_survey.*, s_pelaksanaan_survey.tanggal_mulai, s_pelaksanaan_survey.tanggal_selesai')
      ->join('s_pelaksanaan_survey', 's_pelaksanaan_survey.id = s_survey.id');
    $surveys = $this->paginate($perPage, 'default', $page);
    $pager = $this->pager;
    return [
      'surveys' => $surveys,
      'pager' => $pager
    ];
  }

  public function getActiveSurveys()
  {
    $id_user = getDatabyToken()->uid;
    $tanggalSekarang = date('Y-m-d');
    return $this->select('s_survey.*, s_pelaksanaan_survey.tanggal_mulai, s_pelaksanaan_survey.tanggal_selesai')
      ->join('s_pelaksanaan_survey', 's_pelaksanaan_survey.id = s_survey.id')
      ->join('s_pertanyaan', 's_pertanyaan.id_survey = s_survey.id')
      ->where('tanggal_mulai <=', $tanggalSekarang)
      ->where('tanggal_selesai >=', $tanggalSekarang)
      ->where("s_pertanyaan.id NOT IN (SELECT s_isian_survey.id_pertanyaan FROM s_isian_survey WHERE id_user = '$id_user')")
      ->groupBy('s_survey.id')
      ->groupBy('s_pelaksanaan_survey.tanggal_mulai')
      ->groupBy('s_pelaksanaan_survey.tanggal_selesai')
      ->findAll();
  }
}