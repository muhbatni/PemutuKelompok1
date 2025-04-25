<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitPemutuModel extends Model
{
    protected $table            = 'p_unit_pemutu';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id_unit', 'id_periode', 'id_lembaga', 'status'];
    protected $useTimestamps    = true;
}
?>