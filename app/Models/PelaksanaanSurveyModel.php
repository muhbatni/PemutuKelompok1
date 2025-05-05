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
}