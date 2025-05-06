<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitPemutuModel extends Model
{
    protected $table = 'p_unit_pemutu';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_unit', 'id_periode', 'id_lembaga', 'status', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

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

    public function getUnitsFromAkreditasi()
    {
        return $this->db->table('p_akreditasi')
            ->select('m_unit.id, m_unit.nama')
            ->join('m_unit', 'm_unit.id = p_akreditasi.id_unit')
            ->groupBy('m_unit.id, m_unit.nama')
            ->orderBy('m_unit.nama', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getLembagaByUnit($id_unit)
    {
        return $this->db->table('p_akreditasi')
            ->select('p_akreditasi.id_lembaga, m_lembaga_akreditasi.nama')
            ->join('m_lembaga_akreditasi', 'm_lembaga_akreditasi.id = p_akreditasi.id_lembaga')
            ->where('p_akreditasi.id_unit', $id_unit)
            ->orderBy('p_akreditasi.tanggal_berlaku', 'DESC') // Ambil yang terbaru
            ->limit(1) // Ambil satu record saja
            ->get()
            ->getRowArray();
    }
    public function getAllUnits()
    {
        return $this->db->table('m_unit')
            ->select('m_unit.id, m_unit.nama')
            ->orderBy('m_unit.nama', 'ASC')
            ->get()
            ->getResultArray();
    }
}
