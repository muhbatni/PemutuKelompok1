<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
  protected $table = 'm_user';
  protected $primaryKey = 'id';

  // Fields that are allowed to be inserted or updated
  protected $allowedFields = ['username', 'password', 'tipe'];
}