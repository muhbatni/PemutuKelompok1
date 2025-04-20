<?php

namespace App\Models;

use CodeIgniter\Model;

class LembagaAkreditasiModel extends Model
{
    protected $table            = 'm_lembaga_akreditasi';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id', 'nama', 'deskripsi'];

    public function getLembagas(){
        return $this->findAll();
    }
}

?>