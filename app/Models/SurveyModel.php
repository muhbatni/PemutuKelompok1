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
}