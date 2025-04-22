<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditStandarModel extends Model
{
    protected $table            = 'a_standar_audit';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id_audit', 'id_standar'];

    public function getAuditWithStandar()
    {
        return $this->db->table('a_standar_audit sa')
            ->select('sa.*, a.kode AS kode_audit, s.nama AS nama_standar, p.tahun AS tahun_periode, a.tanggal_mulai, a.tanggal_selesai, s.is_aktif')
            ->join('a_audit a', 'a.id = sa.id_audit')
            ->join('a_standar s', 's.id = sa.id_standar')
            ->join('m_periode p', 'p.id = a.id_periode')
            ->get()
            ->getResult();
    }
}
