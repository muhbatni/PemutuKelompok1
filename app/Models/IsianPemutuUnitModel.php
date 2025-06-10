<?php

namespace App\Models;

use CodeIgniter\Model;

class IsianPemutuUnitModel extends Model
{
    protected $table = 'p_isian_pemutu';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_unitpemutu', 'id_instrumen', 'isian', 'status'];
    protected $useTimestamps = false;

    public function getUsedInstrumenByUnitPemutu($id_unitpemutu, $excludeId = null)
    {
        $builder = $this->select('id_instrumen')
                        ->where('id_unitpemutu', $id_unitpemutu);
        
        // Jika ada ID yang dikecualikan (untuk mode edit)
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }
        
        $result = $builder->findAll();
        
        // Return array of used instrument IDs
        return array_column($result, 'id_instrumen');
    }

    public function getJoin()
    {
        $result = $this->db->table('p_isian_pemutu as isian')
            ->select("
                isian.id,
                unit.nama AS nama_unit,
                periode.ts AS tahun_ajaran,
                instrumen.jenjang AS jenjang,
                instrumen.indikator AS indikator,
                isian.isian,
                isian.status,
                CASE
                    WHEN instrumen.jenjang = 1 THEN 'S3'
                    WHEN instrumen.jenjang = 2 THEN 'S2'
                    WHEN instrumen.jenjang = 3 THEN 'S1'
                    WHEN instrumen.jenjang = 4 THEN 'D4'
                    WHEN instrumen.jenjang = 5 THEN 'D3'
                    WHEN instrumen.jenjang = 6 THEN 'D2'
                    WHEN instrumen.jenjang = 7 THEN 'D1'
                    ELSE 'Unknown'
                END AS jenjang_text
            ")
            ->join('p_unit_pemutu as punit', 'punit.id = isian.id_unitpemutu', 'LEFT')
            ->join('m_unit as unit', 'unit.id = punit.id_unit', 'LEFT')
            ->join('m_periode as periode', 'periode.id = punit.id_periode', 'LEFT')
            ->join('p_instrumen_pemutu as instrumen', 'instrumen.id = isian.id_instrumen', 'LEFT')
            ->orderBy('periode.ts DESC, unit.nama ASC')
            ->get()
            ->getResultArray();

        return $result ?: [];
    }

    public function getAllPeriode()
    {
        return $this->db->table('m_periode')
            ->select('id, ts')
            ->orderBy('ts', 'DESC')
            ->get()
            ->getResultArray();
    }
}
