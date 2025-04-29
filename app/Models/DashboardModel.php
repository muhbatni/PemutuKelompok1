<?php
namespace App\Models;
use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $table = 'p_unit_pemutu';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_unit', 'id_instrumen_pemutu', 'status_isian'];

    public function getDataUnitPemutu()
    {
        return $this->select('p_unit_pemutu.id, m_unit.nama_unit, m_instrumen_pemutu.kondisi, p_unit_pemutu.status_isian')
            ->join('m_unit', 'p_unit_pemutu.id_unit = m_unit.id', 'left')
            ->join('m_instrumen_pemutu', 'p_unit_pemutu.id_instrumen_pemutu = m_instrumen_pemutu.id', 'left')
            ->orderBy('p_unit_pemutu.id', 'ASC')
            ->findAll();
    }
}
