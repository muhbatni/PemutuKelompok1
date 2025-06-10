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
            a.kode AS kode_audit,
            mu.nama AS nama_unit,
            s.nama AS nama_standar,
            p.pernyataan,
            p.indikator,
            da.deskripsi,
            da.dokumen
        ')
            ->join('a_pelaksanaan_audit pa', 'da.id_pelaksanaan = pa.id', 'LEFT')
            ->join('a_standar_audit sa', 'pa.id_standar_audit = sa.id', 'LEFT')
            ->join('a_audit a', 'a.id = sa.id_audit', 'LEFT')
            ->join('m_unit mu', 'pa.id_unit = mu.id', 'LEFT')
            ->join('a_pernyataan p', 'da.id_pernyataan = p.id', 'LEFT')
            ->join('a_standar s', 'p.id_standar = s.id', 'LEFT')
            ->orderBy('da.id', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function find($id = null)
    {
        return $this->db->table($this->table . ' da')
            ->select('
            da.id,
            da.id_pelaksanaan,
            da.id_pernyataan,
            da.deskripsi,
            da.dokumen,
            a.kode as kode_audit,
            mu.nama as nama_unit,
            s.id as id_standar,
            s.nama as nama_standar,
            p.pernyataan,
            p.indikator
        ')
            ->join('a_pelaksanaan_audit pa', 'da.id_pelaksanaan = pa.id', 'LEFT')
            ->join('a_standar_audit sa', 'pa.id_standar_audit = sa.id', 'LEFT')
            ->join('a_audit a', 'a.id = sa.id_audit', 'LEFT')
            ->join('m_unit mu', 'pa.id_unit = mu.id', 'LEFT')
            ->join('a_pernyataan p', 'da.id_pernyataan = p.id', 'LEFT')
            ->join('a_standar s', 'p.id_standar = s.id', 'LEFT')
            ->where('da.id', $id)
            ->get()
            ->getRowArray();
    }

    public function getPelaksanaanList()
    {
        return $this->db->table('a_pelaksanaan_audit pa')
            ->select('pa.id, a.kode as kode_audit')
            ->join('a_standar_audit sa', 'pa.id_standar_audit = sa.id', 'LEFT')
            ->join('a_audit a', 'a.id = sa.id_audit', 'LEFT')
            ->get()
            ->getResultArray();
    }

    public function getPelaksanaanInfo($id)
    {
        $result = $this->db->table('a_pelaksanaan_audit pa')
            ->select('mu.nama as unit_name')
            ->join('m_unit mu', 'mu.id = pa.id_unit', 'LEFT')
            ->where('pa.id', $id)
            ->get()
            ->getRowArray();

        return $result ? $result : ['unit_name' => ''];
    }

    public function getPernyataanInfo($id)
    {
        return $this->db->table('a_pernyataan p')
            ->select('p.indikator')
            ->where('p.id', $id)
            ->get()
            ->getFirstRow('array');
    }

    public function getStandarList()
    {
        return $this->db->table('a_pelaksanaan_audit pa')
            ->select('s.id, s.nama as nama_standar')
            ->join('a_standar_audit sa', 'pa.id_standar_audit = sa.id', 'LEFT')
            ->join('a_pernyataan p', 'sa.id = p.id_standar', 'LEFT')
            ->join('a_standar s', 'p.id_standar = s.id', 'LEFT')
            ->where('pa.id IS NOT NULL')
            ->get()
            ->getResultArray();
    }


    public function getPernyataanByStandar($standarId)
    {
        return $this->db->table('a_pernyataan')
            ->select('id, pernyataan, indikator')
            ->where('id_standar', $standarId)
            ->get()
            ->getResultArray();
    }
}
