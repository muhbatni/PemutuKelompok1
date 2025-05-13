<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitModel extends Model
{
    protected $table = 'm_unit';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'nama', 'parent'];

    public function getUnits()
    {
        return $this->findAll();
    }

    public function getUnitById($id){
        return $this->where('id', $id)->first();
    }
}

?>