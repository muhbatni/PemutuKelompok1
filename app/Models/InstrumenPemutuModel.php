<?php

namespace App\Models;

use CodeIgniter\Model;

class InstrumenPemutuModel extends Model
{
    protected $table            = 'p_instrumen_pemutu';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id_lembaga', 'jenjang', 'indikator', 'kondisi', 'batas'];
    protected $useTimestamps    = false;

    public function getInstrumenWithLembaga()
{
    return $this->select('p_instrumen_pemutu.*, m_lembaga_akreditasi.nama AS nama_lembaga')
                ->join('m_lembaga_akreditasi', 'm_lembaga_akreditasi.id = p_instrumen_pemutu.id_lembaga')
                ->findAll();
                
}
public function delete_by_id($id) {
    return $this->where('id', $id)->delete();
}



public function getJenjangText($jenjang)
{
    $jenjangOptions = [
        1 => 'S3',
        2 => 'S2',
        3 => 'S1',
        4 => 'D4',
        5 => 'D3',
        6 => 'D2',
        7 => 'D1',
    ];
    
    return $jenjangOptions[$jenjang] ?? 'Unknown';
}

}
?>