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

    public function getWithLembaga($id_lembaga = null)
    {
        $builder = $this->select('p_instrumen_pemutu.*, m_lembaga_akreditasi.nama as nama_lembaga')
                        ->join('m_lembaga_akreditasi', 'm_lembaga_akreditasi.id = p_instrumen_pemutu.id_lembaga');
        
        if ($id_lembaga !== null) {
            $builder->where('p_instrumen_pemutu.id_lembaga', $id_lembaga);
        }
        
        return $builder->orderBy('m_lembaga_akreditasi.nama, p_instrumen_pemutu.jenjang')
                       ->findAll();
    }

    public function getForDropdown($id_lembaga)
    {
        return $this->select('p_instrumen_pemutu.*, m_lembaga_akreditasi.nama as nama_lembaga')
                    ->join('m_lembaga_akreditasi', 'm_lembaga_akreditasi.id = p_instrumen_pemutu.id_lembaga')
                    ->where('p_instrumen_pemutu.id_lembaga', $id_lembaga)
                    ->orderBy('p_instrumen_pemutu.jenjang, p_instrumen_pemutu.indikator')
                    ->findAll();
    }

    public function getLembagaByUnitPemutu($id_unitpemutu)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('p_unit_pemutu');
        
        $result = $builder->select('id_lembaga')
                         ->where('id', $id_unitpemutu)
                         ->get()
                         ->getRow();
        
        return $result ? $result->id_lembaga : null;
    }

    public function getByUnitPemutu($id_unitpemutu)
    {
        // First, get the lembaga from unit pemutu
        $lembagaId = $this->getLembagaByUnitPemutu($id_unitpemutu);
        
        if (!$lembagaId) {
            return []; // Return empty array if no lembaga found
        }
        
        // Then get instruments for that lembaga
        return $this->select('p_instrumen_pemutu.*, m_lembaga_akreditasi.nama as nama_lembaga')
                    ->join('m_lembaga_akreditasi', 'm_lembaga_akreditasi.id = p_instrumen_pemutu.id_lembaga')
                    ->where('p_instrumen_pemutu.id_lembaga', $lembagaId)
                    ->orderBy('p_instrumen_pemutu.jenjang, p_instrumen_pemutu.indikator')
                    ->findAll();
    }
}
?>