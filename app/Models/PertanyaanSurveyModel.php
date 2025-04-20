<?php

namespace App\Models;

use CodeIgniter\Model;

class PertanyaanSurveyModel extends Model
{
    protected $table = 's_pertanyaan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['id_survey', 'teks', 'jenis', 'is_aktif', 'created_at', 'updated_at'];
    protected $returnType = 'array';
}