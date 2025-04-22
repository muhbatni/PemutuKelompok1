<?php

namespace App\Models;

use CodeIgniter\Model;

class PelaksanaanAudit extends Model
{
    protected $table            = 'a_audit';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id_periode', 'kode', 'tanggal_mulai', 'tanggal_selesai'];

}
?>