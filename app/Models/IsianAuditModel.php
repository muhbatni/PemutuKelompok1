<?php

namespace App\Models;

use CodeIgniter\Model;

class IsianAuditModel extends Model
{
    protected $table = 'a_isian_audit';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_pelaksanaan', 'id_pernyataan', 'capaian', 'kondisi', 'akar', 'akibat', 'rekom', 'tanggapan', 'rencana_perbaikan', 'tanggal_perbaikan', 'rencana_pencegahan', 'tanggal_pencegahan', 'is_temuan'];

    public function getIsianByPernyataan($id_pelaksanaan, $id_pernyataan)
    {
        return $this->where([
            'id_pelaksanaan' => $id_pelaksanaan,
            'id_pernyataan' => $id_pernyataan
        ])->first();
    }

}