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
        $builder = $this->db->table('p_unit_pemutu pu');
        $builder->select('pu.id, mu.nama as nama_unit, 
                     mp.tahun as periode,
                     mp.ts as ts, 
                     isi.isian as status_isian,
                     isi.status as status_aktif,
                     pu.id_periode');
        $builder->join('m_unit mu', 'pu.id_unit = mu.id', 'left');
        $builder->join('p_isian_pemutu isi', 'isi.id_unitpemutu = pu.id', 'left');
        $builder->join('p_instrumen_pemutu ip', 'isi.id_instrumen = ip.id', 'left');
        $builder->join('m_periode mp', 'pu.id_periode = mp.id', 'left');

        if ($tahun !== null && $tahun !== '') {
            $builder->where('pu.id_periode', $tahun);
        }

        $builder->orderBy('mu.nama', 'ASC');
        $query = $builder->get();
        $results = $query->getResultArray();

        // Mapping status_isian dan badge class di sini
        foreach ($results as &$row) {
            $status = $row['status_isian'];
            switch ($status) {
                case '0':
                    $row['status_isian_text'] = 'Cek';
                    $row['status_isian_class'] = 'badge bg-primary'; // biru
                    break;
                case '1':
                    $row['status_isian_text'] = 'Lolos';
                    $row['status_isian_class'] = 'badge bg-success'; // hijau
                    break;
                case '2':
                    $row['status_isian_text'] = 'Peringatan (50%)';
                    $row['status_isian_class'] = 'badge bg-warning'; // kuning
                    break;
                case '3':
                    $row['status_isian_text'] = 'Tidak Lolos (<49%)';
                    $row['status_isian_class'] = 'badge bg-danger'; // merah
                    break;
                default:
                    $row['status_isian_text'] = '-';
                    $row['status_isian_class'] = 'badge bg-secondary'; // abu
                    break;
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