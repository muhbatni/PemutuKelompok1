<?php

namespace App\Models;

use CodeIgniter\Model;

class SyaratUnggulModel extends Model
{
    protected $table            = 'p_syarat_unggul';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id_lembaga', 'nama'];
    public function getAkreditasiData()
    {
        return $this->findAll(); 
    }
}
?> 