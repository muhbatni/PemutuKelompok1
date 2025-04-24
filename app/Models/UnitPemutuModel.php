<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitPemutuModel extends Model
{
    protected $table = 'p_unit_pemutu';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_unit', 'id_periode', 'id_lembaga', 'status'];
    protected $useTimestamps = true;

    public function getPemutuData()
    {
        return $this->db->table($this->table)
            ->select('
                p_unit_pemutu.id,
                m_unit.nama as unit,
                m_periode.tahun as periode,
                m_lembaga_akreditasi.nama as lembaga,
                p_unit_pemutu.status,
                p_unit_pemutu.created_at
            ')
            ->join('m_unit', 'm_unit.id = p_unit_pemutu.id_unit')
            ->join('m_periode', 'm_periode.id = p_unit_pemutu.id_periode')
            ->join('m_lembaga_akreditasi', 'm_lembaga_akreditasi.id = p_unit_pemutu.id_lembaga')
            ->orderBy('p_unit_pemutu.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }
}
?>