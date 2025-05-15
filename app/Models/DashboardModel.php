<?php
namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $table = 'p_unit_pemutu';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_unit', 'id_periode', 'status'];

    public function getUnitPemutu($tahun = null)
    {
        // Query untuk menghitung status berdasarkan isian pemutu
        $builder = $this->db->table('p_unit_pemutu pu');
        $builder->select('pu.id, 
                    mu.nama as nama_unit, 
                    mp.tahun as periode,
                    mp.ts as ts,
                    pu.id_periode,
                    COUNT(isi.id) as total_isian,
                    SUM(CASE WHEN isi.status = 1 THEN 1 ELSE 0 END) as jumlah_lolos');
        $builder->join('m_unit mu', 'pu.id_unit = mu.id', 'left');
        $builder->join('p_isian_pemutu isi', 'isi.id_unitpemutu = pu.id', 'left');
        $builder->join('m_periode mp', 'pu.id_periode = mp.id', 'left');

        if ($tahun !== null && $tahun !== '') {
            $builder->where('pu.id_periode', $tahun);
        }

        $builder->groupBy('pu.id, mu.nama, mp.tahun, mp.ts, pu.id_periode');
        $builder->orderBy('mu.nama', 'ASC');
        $query = $builder->get();
        $results = $query->getResultArray();

        // Mapping status berdasarkan persentase
        foreach ($results as &$row) {
            $total = $row['total_isian'];
            $lolos = $row['jumlah_lolos'];

            if ($total == 0) {
                $row['status_isian_text'] = '-';
                $row['status_isian_class'] = 'badge-status badge-belum';
                continue;
            }

            $persentase = round(($lolos / $total) * 100);

            if ($persentase <= 49) {
                $row['status_isian_text'] = 'Tidak Lolos (' . $persentase . '%)';
                $row['status_isian_class'] = 'badge-status badge-tidaklolos';
            } elseif ($persentase == 50) {
                $row['status_isian_text'] = 'Peringatan (50%)';
                $row['status_isian_class'] = 'badge-status badge-peringatan';
            } else {
                $row['status_isian_text'] = 'Lolos (' . $persentase . '%)';
                $row['status_isian_class'] = 'badge-status badge-lolos';
            }
        }

        return $results;
    }

    public function getAllPeriode()
    {
        $builder = $this->db->table('m_periode');
        $builder->select('id, tahun, ts');
        $builder->orderBy('tahun', 'DESC');
        return $builder->get()->getResultArray();
    }
}