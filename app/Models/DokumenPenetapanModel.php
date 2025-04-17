<?php

namespace App\Models;

use CodeIgniter\Model;

class DokumenPenetapanModel extends Model
{
    protected $table            = 'm_penetapan';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nomor', 'tanggal', 'nama', 'deskripsi', 'dokumen'];
    protected $useTimestamps    = true;
}
?>