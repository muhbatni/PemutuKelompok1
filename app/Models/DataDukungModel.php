<?php

namespace App\Models;

use CodeIgniter\Model;

class DataDukungModel extends Model
{
    protected $table            = 'a_dokumen_audit';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id_pelaksanaan', 'id_pernyataan', 'deskripsi', 'dokumen'];

}
?>