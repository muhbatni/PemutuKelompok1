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
                pu.id_lembaga,
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

        $builder->groupBy('pu.id, pu.id_lembaga, mu.nama, mp.tahun, mp.ts, pu.id_periode');
        $builder->orderBy('mu.nama', 'ASC');
        $query = $builder->get();
        $results = $query->getResultArray();

        // Mapping status berdasarkan persentase
        foreach ($results as &$row) {
            $total = $row['total_isian'];
            $lolos = $row['jumlah_lolos'];

            // Hitung jumlah instrumen dengan lembaga yang sama
            $jumlah_lembaga_sama = $this->db->table('p_instrumen_pemutu')
                ->where('id_lembaga', $row['id_lembaga'])
                ->countAllResults();

            if ($jumlah_lembaga_sama === 0) {
                $row['status_isian_text'] = '-';
                $row['status_isian_class'] = 'badge-status badge-primary';
                continue;
            }

            // Hitung persentase berdasarkan jumlah lembaga yang sama
            $persentase = min(round(($lolos / $jumlah_lembaga_sama) * 100), 100);

            if ($persentase > 50) {
                $row['status_isian_text'] = 'Lolos (' . $persentase . '%)';
                $row['status_isian_class'] = 'text-success';
            } elseif ($persentase == 50) {
                $row['status_isian_text'] = 'Peringatan (' . $persentase . '%)';
                $row['status_isian_class'] = 'text-warning';
            } else {
                $row['status_isian_text'] = 'Tidak Lolos (' . $persentase . '%)';
                $row['status_isian_class'] = 'text-danger';
            }
        }

        return $results;
    }

    private function countInstrumenByLembaga($id_lembaga)
    {
        try {
            return $this->db->table('m_instrumen_pemutu')
                ->where('id_lembaga', $id_lembaga)
                ->countAllResults();
        } catch (\Exception $e) {
            log_message('error', 'Error counting instrumen: ' . $e->getMessage());
            return 0;
        }
    }

    public function getAllPeriode()
    {
        $builder = $this->db->table('m_periode');
        $builder->select('id, tahun, ts');
        $builder->orderBy('tahun', 'DESC');
        return $builder->get()->getResultArray();
    }
}