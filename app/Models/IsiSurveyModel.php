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
}