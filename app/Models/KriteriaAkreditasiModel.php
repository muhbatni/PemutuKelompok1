<?php

namespace App\Models;

use CodeIgniter\Model;

class KriteriaAkreditasiModel extends Model
{
    protected $table            = 'p_kriteria';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id_lembaga', 'kode', 'nama'];
    protected $useTimestamps    = false;
}
?>