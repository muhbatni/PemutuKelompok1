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
    $tanggalSekarang = date('Y-m-d');
    return $this->select('s_survey.*, s_pelaksanaan_survey.tanggal_mulai, s_pelaksanaan_survey.tanggal_selesai')
      ->join('s_pelaksanaan_survey', 's_pelaksanaan_survey.id = s_survey.id')
      ->where('tanggal_mulai <=', $tanggalSekarang)
      ->where('tanggal_selesai >=', $tanggalSekarang)
      ->findAll();
  }
}