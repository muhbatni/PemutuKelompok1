<?php

namespace App\Models;

use CodeIgniter\Model;

class LembagaModel extends Model
{
    protected $table = 'm_lembaga_akreditasi';
    protected $primaryKey = 'id';  
    protected $allowedFields = ['nama', 'deskripsi'];
}
?>