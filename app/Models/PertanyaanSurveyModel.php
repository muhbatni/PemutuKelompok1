<?php

namespace App\Models;

use CodeIgniter\Model;

class PertanyaanSurveyModel extends Model
{
<<<<<<< HEAD
    protected $table = 's_pertanyaan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['id_survey', 'teks', 'jenis', 'is_aktif', 'created_at', 'updated_at'];
    protected $returnType = 'array';
=======
  protected $table = 's_pertanyaan';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true;
  protected $allowedFields = ['id_survey', 'teks', 'jenis', 'is_aktif', 'created_at', 'updated_at'];
  protected $returnType = 'array';
>>>>>>> 00c8c1018d008f9853ae3dcad077bd0b21a62de9
}