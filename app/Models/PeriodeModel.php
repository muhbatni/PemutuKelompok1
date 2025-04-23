<?php

namespace App\Models;

use CodeIgniter\Model;

class PeriodeModel extends Model
{
  protected $table = 'm_periode';
  protected $primaryKey = 'id';
  protected $allowedFields = ['tahun', 'ts',];
  protected $returnType = 'array';
}