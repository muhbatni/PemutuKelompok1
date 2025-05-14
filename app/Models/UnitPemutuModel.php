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
        $result = $this->db->table($this->table)
            ->select('
            p_unit_pemutu.id,
            m_unit.nama as unit,
            m_periode.tahun as periode,
            m_lembaga_akreditasi.nama as lembaga,
            p_unit_pemutu.created_at,
            (SELECT COUNT(isi.id) 
             FROM p_isian_pemutu isi 
             WHERE isi.id_unitpemutu = p_unit_pemutu.id) as total_isian,
            (SELECT COUNT(isi.id) 
             FROM p_isian_pemutu isi 
             WHERE isi.id_unitpemutu = p_unit_pemutu.id 
             AND isi.status = 1) as jumlah_lolos
        ')
            ->join('m_unit', 'm_unit.id = p_unit_pemutu.id_unit')
            ->join('m_periode', 'm_periode.id = p_unit_pemutu.id_periode')
            ->join('m_lembaga_akreditasi', 'm_lembaga_akreditasi.id = p_unit_pemutu.id_lembaga')
            ->orderBy('p_unit_pemutu.created_at', 'DESC')
            ->get()
            ->getResultArray();

        // Hitung status untuk setiap row
        foreach ($result as &$row) {
            $total = (int) $row['total_isian'];
            $lolos = (int) $row['jumlah_lolos'];

            if ($total === 0) {
                $row['status'] = '-';
                $row['status_class'] = '';
                continue;
            }

            $percentage = round(($lolos / $total) * 100);

            if ($percentage >= 60) {
                $row['status'] = "Lolos ($percentage%)";
                $row['status_class'] = 'text-success';
            } else if ($percentage >= 50) {
                $row['status'] = "Peringatan ($percentage%)";
                $row['status_class'] = 'text-warning';
            } else {
                $row['status'] = "Tidak Lolos ($percentage%)";
                $row['status_class'] = 'text-danger';
            }
        }

        return $result;
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
        $result = $this->db->table('p_akreditasi')
            ->select('p_akreditasi.id_lembaga, m_lembaga_akreditasi.nama')
            ->join('m_lembaga_akreditasi', 'm_lembaga_akreditasi.id = p_akreditasi.id_lembaga')
            ->where('p_akreditasi.id_unit', $id_unit)
            ->orderBy('p_akreditasi.tanggal_berlaku', 'DESC')
            ->limit(1)
            ->get()
            ->getRowArray();

        // Jika tidak ada data, kembalikan null
        if (!$result) {
            return null;
        }

        return $result;
    }
    public function getAllUnits()
    {
        return $this->db->table('m_unit')
            ->select('m_unit.id, m_unit.nama')
            ->orderBy('m_unit.nama', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getStatusByUnitPeriode($id_unit, $id_periode)
    {
        $builder = $this->db->table('p_unit_pemutu pu');
        $builder->select('
        COUNT(isi.id) as total_isian,
        SUM(CASE WHEN isi.status = 1 THEN 1 ELSE 0 END) as jumlah_lolos,
        pu.id as unit_pemutu_id
    ');
        $builder->join('p_isian_pemutu isi', 'isi.id_unitpemutu = pu.id', 'left');
        $builder->where('pu.id_unit', $id_unit);
        $builder->where('pu.id_periode', $id_periode);

        $result = $builder->get()->getRowArray();

        // Jika tidak ada data, kembalikan status default
        if (empty($result)) {
            return [
                'total_isian' => 0,
                'jumlah_lolos' => 0,
                'percentage' => 0,
                'status' => '-',
                'status_class' => ''
            ];
        }

        // Hitung status menggunakan data yang ada
        return $this->calculateStatus($result);
    }

    private function calculateStatus($data)
    {
        $total = (int) $data['total_isian'];
        $lolos = (int) $data['jumlah_lolos'];

        if ($total === 0) {
            return [
                'total_isian' => 0,
                'jumlah_lolos' => 0,
                'percentage' => 0,
                'status' => '-',
                'status_class' => ''
            ];
        }

        $percentage = round(($lolos / $total) * 100);

        $result = [
            'total_isian' => $total,
            'jumlah_lolos' => $lolos,
            'percentage' => $percentage
        ];

        if ($percentage >= 60) {
            $result['status'] = "Lolos ($percentage%)";
            $result['status_class'] = 'text-success';
        } else if ($percentage >= 50) {
            $result['status'] = "Peringatan ($percentage%)";
            $result['status_class'] = 'text-warning';
        } else {
            $result['status'] = "Tidak Lolos ($percentage%)";
            $result['status_class'] = 'text-danger';
        }

        return $result;
    }
}
