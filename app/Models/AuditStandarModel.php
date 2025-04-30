<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditStandarModel extends Model
{
    protected $table = 'a_standar_audit';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_audit', 'id_standar'];

    public function getAuditWithStandar()
    {
        return $this->db->table('a_audit a')
            ->join('a_standar_audit sa', 'sa.id_audit = a.id')
            ->join('a_standar s', 's.id = sa.id_standar')
            ->join('m_periode p', 'p.id = a.id_periode')
            ->select(
                'a.id AS id_audit,
                a.kode AS kode_audit,
                STRING_AGG(s.nama, E\'\n\') AS nama_standar,
                p.tahun AS tahun_periode,
                a.tanggal_mulai,
                a.tanggal_selesai'
            )
            ->groupBy('a.id, a.kode, p.tahun, a.tanggal_mulai, a.tanggal_selesai')
            ->get()
            ->getResult();
    }
    public function getStandarByAudit($id_audit)
    {
        return $this->db->table('a_standar_audit sa')
            ->join('a_standar s', 's.id = sa.id_standar')
            ->select('sa.id_standar, s.nama')
            ->where('sa.id_audit', $id_audit)
            ->get()
            ->getResult();
    }

}