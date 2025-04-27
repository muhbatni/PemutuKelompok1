<?php

namespace App\Models;

use CodeIgniter\Model;

class PernyataanModel extends Model
{
    protected $table = 'a_pernyataan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_standar', 'pernyataan', 'indikator', 'kondisi', 'batas'];

    public function getPernyataanByAudit($id_audit)
    {
        return $this->db->query("
            SELECT 
                s.nama AS nama_standar,
                p.id AS id_pernyataan,
                p.pernyataan,
                p.indikator,
                p.kondisi,
                p.batas
            FROM 
                a_audit a
                JOIN a_standar_audit sa ON a.id = sa.id_audit
                JOIN a_standar s ON sa.id_standar = s.id
                JOIN a_pernyataan p ON p.id_standar = s.id
            WHERE 
                a.id = ?
            ORDER BY 
                s.nama, p.id
        ", [$id_audit])->getResult();
    }
}
