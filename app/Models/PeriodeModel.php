<?php
namespace App\Models;

use CodeIgniter\Model;

class PeriodeModel extends Model
{
    protected $table = 'm_periode'; // Sesuaikan dengan nama tabel di database
    protected $primaryKey = 'id';
    protected $allowedFields = ['tahun', 'ts'];

    public function getPeriodes()
    {
        // Ambil data periode dari database
        return $this->select('id, tahun, ts')->findAll();
    }
}