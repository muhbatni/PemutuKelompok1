<?php
namespace App\Models;
use CodeIgniter\Model;
class PelaksanaanAuditModel extends Model
{
    protected $table = 'a_pelaksanaan_audit';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_auditor', 'id_unit', 'id_standar_audit'];

    public function getPelaksanaanAudit($id_audit = null)
    {
        $builder = $this->select('
            a_audit.id AS id_audit,
            a_audit.kode AS kode_audit,
            m_user.nama AS nama_auditor,
            m_unit.nama AS nama_unit,
            MIN(a_pelaksanaan_audit.id) AS min_id_pelaksanaan,
            MIN(a_pelaksanaan_audit.id_standar_audit) AS min_id_standar_audit
        ')
            ->join('a_standar_audit', 'a_standar_audit.id = a_pelaksanaan_audit.id_standar_audit')
            ->join('a_audit', 'a_audit.id = a_standar_audit.id_audit')
            ->join('a_auditor', 'a_auditor.id = a_pelaksanaan_audit.id_auditor', 'left')
            ->join('m_user', 'm_user.id = a_auditor.id', 'left')
            ->join('m_unit', 'm_unit.id = a_pelaksanaan_audit.id_unit', 'left');

        if ($id_audit) {
            $builder->where('a_standar_audit.id_audit', $id_audit);
        }

        $builder->groupBy('a_audit.id, a_audit.kode, m_user.nama, m_unit.nama');
        $builder->orderBy('a_audit.kode', 'ASC');

        return $builder->findAll();
    }


    public function getListAuditForDropdown()
    {
        return $this->db->table('a_standar_audit')
            ->select('a_audit.id, a_audit.kode')
            ->join('a_audit', 'a_audit.id = a_standar_audit.id_audit')
            ->distinct()
            ->orderBy('a_audit.kode', 'ASC')
            ->get()
            ->getResultArray();
    }



    public function getAuditorList()
    {
        return $this->db->query("
            SELECT
            a_auditor.id AS id_auditor,
            m_user.nama AS nama_auditor
            FROM 
            a_auditor
            JOIN 
            m_user ON a_auditor.id = m_user.id;
            ")->getResult();
    }

    public function getUnitList()
    {
        return $this->db->query("
            SELECT 
                id as id_unit, 
                nama as nama_unit
            FROM 
                m_unit
            ORDER BY 
                nama ASC
        ")->getResult();
    }

    public function getPernyataanByStandar($id_standar)
    {
        return $this->db->query("
        SELECT 
            a_pernyataan.pernyataan,
            a_pernyataan.indikator,
            a_pernyataan.kondisi,
            a_pernyataan.batas
        FROM 
            a_pernyataan
        WHERE 
            a_pernyataan.id_standar = ?",
            [$id_standar]
        )->getResult();
    }


    public function getStandards($audit_id, $unit_id)
    {
        return $this->db->query("
            SELECT 
                s.id as id_standar, 
                s.nama
            FROM 
                a_standar s
                JOIN a_standar_audit sa ON s.id = sa.id_standar
            WHERE 
                sa.id_audit = ?
            GROUP BY 
                s.id, s.nama
            ORDER BY 
                s.nama
        ", [$audit_id])->getResult();
    }

    public function getPelaksanaanAuditById($id_standar_audit)
    {
        return $this->select('a_pelaksanaan_audit.*, a_standar_audit.id_audit AS id_audit, a_audit.kode AS kode_audit, m_user.nama AS nama_auditor, m_unit.nama AS nama_unit')
            ->join('a_standar_audit', 'a_standar_audit.id = a_pelaksanaan_audit.id_standar_audit')
            ->join('a_audit', 'a_audit.id = a_standar_audit.id_audit')
            ->join('a_auditor', 'a_auditor.id = a_pelaksanaan_audit.id_auditor', 'left')
            ->join('m_user', 'm_user.id = a_auditor.id', 'left')
            ->join('m_unit', 'm_unit.id = a_pelaksanaan_audit.id_unit', 'left')
            ->where('a_pelaksanaan_audit.id_standar_audit', $id_standar_audit)
            ->findAll();
    }




}
?>