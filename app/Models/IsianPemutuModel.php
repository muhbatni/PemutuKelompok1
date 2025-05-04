<?php

namespace App\Models;

use CodeIgniter\Model;

class IsianPemutuModel extends Model
{
    protected $table            = 'p_isian_pemutu';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id_unitpemutu', 'id_instrumen', 'isian', 'status'];
    protected $useTimestamps    = false;

    // Fungsi untuk mengambil data dengan relasi
    // public function getJoin()
    // {
    //     return $this->db->table('p_isian_pemutu as isian')
    //         ->select('isian.id, unit.nama AS nama_unit, instrumen.jenjang AS jenjang, isian.isian, isian.status') // Ubah nama_lembaga menjadi jenjang
    //         ->join('p_unit_pemutu as punit', 'punit.id = isian.id_unitpemutu')
    //         ->join('m_unit as unit', 'unit.id = punit.id_unit')
    //         ->join('p_instrumen_pemutu as instrumen', 'instrumen.id = isian.id_instrumen')
    //         ->join('m_lembaga_akreditasi as lembaga', 'lembaga.id = instrumen.id_lembaga')
    //         ->get()
    //         ->getResultArray();
    // }
    public function getJoin()
    {
        return $this->db->table('p_isian_pemutu as isian')
            ->select('isian.id, unit.nama AS nama_unit, instrumen.jenjang AS jenjang, isian.isian, isian.status')
            ->join('p_unit_pemutu as punit', 'punit.id = isian.id_unitpemutu')
            ->join('m_unit as unit', 'unit.id = punit.id_unit')
            ->join('p_instrumen_pemutu as instrumen', 'instrumen.id = isian.id_instrumen')
            ->get()
            ->getResultArray();
    }

}
?>