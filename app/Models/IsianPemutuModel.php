<?php

namespace App\Models;

use CodeIgniter\Model;

class IsianPemutuModel extends Model
{
    protected $table            = 'p_isian_pemutu';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id_unitpemutu', 'id_instrumen', 'isian', 'status'];
    protected $useTimestamps    = false;

}
?>