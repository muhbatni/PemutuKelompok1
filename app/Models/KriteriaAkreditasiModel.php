<?php

namespace App\Models;

use CodeIgniter\Model;

class KriteriaAkreditasiModel extends Model
{
    protected $table            = 'p_kriteria';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id_lembaga', 'kode', 'nama'];
    protected $useTimestamps    = false;

    public function getKriteriaWithLembaga()
{
    return $this->select('p_kriteria.*, m_lembaga_akreditasi.nama AS nama_lembaga')
                ->join('m_lembaga_akreditasi', 'm_lembaga_akreditasi.id = p_kriteria.id_lembaga')
                ->findAll();
                
}
public function delete_by_id($id)
{
    return $this->delete($id); // langsung gunakan fungsi delete() dari CI Model
}

public function getAllLembaga()
{
    return $this->db->table('m_lembaga_akreditasi')
        ->select('id, nama')
        ->orderBy('nama', 'ASC')
        ->get()
        ->getResultArray();
}


}

?>