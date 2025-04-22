<?php
namespace App\Models;

use CodeIgniter\Model;

class StandarModel extends Model
{
    protected $table = 'a_standar';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_parent', 'nama', 'dokumen', 'is_aktif'];

    public function getStandars(){
        return $this->findAll();
    }
}
