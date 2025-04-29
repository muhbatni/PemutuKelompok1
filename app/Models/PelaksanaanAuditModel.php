<?php
namespace App\Models;
use CodeIgniter\Model;
class PelaksanaanAuditModel extends Model
{
    protected $table            = 'a_pelaksanaan_audit';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id_auditor', 'id_unit'];
    
    public function getPelaksanaanAudit()
    {
        return $this->db->query("
            SELECT 
                a.id AS id_audit,
                a.kode AS kode_audit,
                p.tahun AS tahun_periode,
                STRING_AGG(DISTINCT s.nama, ', ') AS nama_standar,
                STRING_AGG(DISTINCT sa.id::text, ',') AS standar_audit_ids,
                COALESCE(MAX(pa.id_auditor::text), 'Belum dipilih') AS id_auditor,
                COALESCE(MAX(pa.id_unit::text), 'Belum dipilih') AS id_unit
            FROM 
                a_audit a
                JOIN a_standar_audit sa ON a.id = sa.id_audit
                JOIN m_periode p ON p.id = a.id_periode
                JOIN a_standar s ON s.id = sa.id_standar
                LEFT JOIN a_pelaksanaan_audit pa ON pa.id = sa.id
            GROUP BY 
                a.id, a.kode, p.tahun
            ORDER BY 
                a.kode
        ")->getResult();
    }
}
?>