<?php

namespace App\Models;

use CodeIgniter\Model;

class TemuanModel extends Model
{
    protected $table = 'a_temuan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_unit', 'id_kondisi', 'rencana_perbaikan', 'tanggal_perbaikan', 'catatan', 'status', 'id_isian_audit', 'created_at', 'updated_at'];
    protected $returnType = 'array';


}