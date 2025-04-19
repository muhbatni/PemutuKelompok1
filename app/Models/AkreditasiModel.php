<?php

namespace App\Models;

use CodeIgniter\Model;

class Akreditasi extends Model
{
    protected $table            = 'p_akreditasi';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id_unit', 'id_lembaga', 'status', 'tanggal_berlaku', 'tanggal_habis'];
    protected $useTimestamps    = true;
}
?> 