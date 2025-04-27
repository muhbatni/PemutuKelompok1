<?php

namespace App\Models;

use CodeIgniter\Model;

class DataDukungModel extends Model
{
    protected $table            = 'a_dokumen_audit';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id_pelaksanaan', 'id_pernyataan', 'deskripsi', 'dokumen'];

    public function getData()
    {
        return $this->db->table($this->table . ' da')
            ->select('
                da.id, 
                mu.nama AS nama_unit, 
                p.pernyataan, 
                da.deskripsi, 
                da.dokumen
            ')
            ->join('a_pelaksanaan_audit pa', 'da.id_pelaksanaan = pa.id', 'LEFT')
            ->join('m_unit mu', 'pa.id_unit = mu.id', 'LEFT')
            ->join('a_pernyataan p', 'da.id_pernyataan = p.id', 'LEFT')
            ->get()
            ->getResultArray();
    }
}
?>