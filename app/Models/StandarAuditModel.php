<?php

namespace App\Models;

use CodeIgniter\Model;

class StandarAuditModel extends Model
{
    protected $table = 'a_standar'; // Pastikan ini sesuai dengan nama tabel
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'id_parent', 'dokumen', 'is_aktif'];
}
?>