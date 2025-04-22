<?php

namespace App\Models;

use CodeIgniter\Model;

class InstrumenPemutuModel extends Model
{
    protected $table            = 'p_instrumen_pemutu';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id_lembaga', 'jenjang', 'indikator', 'kondisi', 'batas'];
    protected $useTimestamps    = false;
}
?>