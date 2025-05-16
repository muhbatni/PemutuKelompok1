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
            p_unit_pemutu.status as status_awal,
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

        foreach ($result as &$row) {
            $statusData = $this->calculateStatusBasedOnIsian($row); // Perhatikan huruf besar 'I'
            $row['status'] = $statusData['status'];
            $row['status_class'] = $statusData['status_class'];
            $row['status_value'] = $statusData['status_value'];
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
        $builder = $this->db->table('p_isian_pemutu isi')
            ->select('COUNT(isi.id) as total_isian, 
                 SUM(CASE WHEN isi.status = 1 THEN 1 ELSE 0 END) as jumlah_lolos')
            ->join('p_unit_pemutu pu', 'isi.id_unitpemutu = pu.id')
            ->where('pu.id_unit', $id_unit)
            ->where('pu.id_periode', $id_periode)
            ->groupBy('pu.id_unit, pu.id_periode');

        $result = $builder->get()->getRowArray();

        // Pastikan mengembalikan array dengan nilai default jika tidak ada data
        return [
            'total_isian' => $result['total_isian'] ?? 0,
            'jumlah_lolos' => $result['jumlah_lolos'] ?? 0
        ];
    }

    private function calculateStatusBasedOnIsian($data)
    {
        $total = (int) $data['total_isian'];
        $lolos = (int) $data['jumlah_lolos'];

        if ($total === 0) {
            return [
                'status' => '-',
                'status_class' => 'text-primary', // Ubah menjadi text-primary untuk warna biru
                'status_value' => 0
            ];
        }

        $percentage = round(($lolos / $total) * 100);

        if ($percentage > 50) {
            return [
                'status' => "Lolos ($percentage%)",
                'status_class' => 'text-success',
                'status_value' => 1
            ];
        } else {
            return [
                'status' => "Tidak Lolos ($percentage%)",
                'status_class' => 'text-danger',
                'status_value' => 0
            ];
        }
    }

    public function getDetailPemutuData($id)
    {
        $result = $this->db->table($this->table)
            ->select('
            p_unit_pemutu.id,
            p_unit_pemutu.status as status_awal,
            (SELECT COUNT(isi.id) 
             FROM p_isian_pemutu isi 
             WHERE isi.id_unitpemutu = p_unit_pemutu.id) as total_isian,
            (SELECT COUNT(isi.id) 
             FROM p_isian_pemutu isi 
             WHERE isi.id_unitpemutu = p_unit_pemutu.id 
             AND isi.status = 1) as jumlah_lolos
        ')
            ->where('p_unit_pemutu.id', $id)
            ->get()
            ->getRowArray();

        if (!$result) {
            return null;
        }

        return $this->calculateStatusBasedOnIsian($result);
    }
}
