<?php

namespace App\Models;

use CodeIgniter\Model;

class IsianPemutuUnitModel extends Model
{
    protected $table = 'p_isian_pemutu';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_unitpemutu', 'id_instrumen', 'isian', 'status'];
    protected $useTimestamps = false;

    public function getJoin()
    {
        $result = $this->db->table('p_isian_pemutu as isian')
            ->select('
            isian.id,
            unit.nama AS nama_unit,
            periode.ts AS tahun_ajaran,
            instrumen.jenjang AS jenjang,
            instrumen.indikator AS indikator,
            isian.isian,
            isian.status
        ')
            ->join('p_unit_pemutu as punit', 'punit.id = isian.id_unitpemutu')
            ->join('m_unit as unit', 'unit.id = punit.id_unit')
            ->join('m_periode as periode', 'periode.id = punit.id_periode')
            ->join('p_instrumen_pemutu as instrumen', 'instrumen.id = isian.id_instrumen')
            ->get()
            ->getResultArray();

        // Mapping jenjang ke teks
        $jenjangMap = [
            1 => 'S3',
            2 => 'S2',
            3 => 'S1',
            4 => 'D4',
            5 => 'D3',
            6 => 'D2',
            7 => 'D1',
        ];

        // Tambahkan field jenjang_text ke setiap baris
        foreach ($result as &$row) {
            $row['jenjang_text'] = $jenjangMap[$row['jenjang']] ?? 'Unknown';
        }

        return $result;
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
?>