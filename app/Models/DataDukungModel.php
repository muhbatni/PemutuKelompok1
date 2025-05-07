<?php

namespace App\Models;

use CodeIgniter\Model;

class DataDukungModel extends Model
{
    protected $table            = 'a_dokumen_audit';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id_pelaksanaan', 'id_pernyataan', 'deskripsi', 'dokumen'];

    public function getDataDukung()
    {
        return $this->db->table($this->table . ' da')
            ->select('
                da.id, 
                da.id_pernyataan,
                da.id_pelaksanaan,
                mu.nama AS nama_unit, 
                p.pernyataan, 
                p.indikator,
                da.deskripsi, 
                da.dokumen,
                u.username AS auditor_name
            ')
            ->join('a_pelaksanaan_audit pa', 'da.id_pelaksanaan = pa.id', 'LEFT')
            ->join('m_unit mu', 'pa.id_unit = mu.id', 'LEFT')
            ->join('a_pernyataan p', 'da.id_pernyataan = p.id', 'LEFT')
            ->join('a_auditor a', 'a.id = pa.id_auditor', 'LEFT')
            ->join('m_user u', 'u.id = a.id', 'LEFT')
            ->orderBy('da.id_pernyataan', 'ASC')
            ->get()
            ->getResultArray();
    }


    public function getPelaksanaanList()
    {
        return $this->db->table('a_pelaksanaan_audit')
            ->select('id')
            ->get()
            ->getResultArray();
    }

    public function getPelaksanaanInfo($id)
    {
    return $this->db->table('a_pelaksanaan_audit pa')
        ->select('
            mu.nama as unit_name,
            u.username as auditor_name
        ')
        ->join('m_unit mu', 'mu.id = pa.id_unit')
        ->join('a_auditor a', 'a.id = pa.id_auditor')
        ->join('m_user u', 'u.id = a.id') // tambahan join ke m_user
        ->where('pa.id', $id)
        ->get()
        ->getFirstRow('array');
    }

    public function getPernyataanInfo($id) 
    {
    return $this->db->table('a_pernyataan p')
        ->select('p.indikator')
        ->where('p.id', $id)
        ->get()
        ->getFirstRow('array');
    }
}
?>