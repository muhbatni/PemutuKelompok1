<?php

namespace App\Models;

use CodeIgniter\Model;

class IsianPemutuModel extends Model
{
    protected $table = 'p_isian_pemutu';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_unitpemutu', 'id_instrumen', 'isian', 'status'];
    protected $useTimestamps = false;

    public function getJoin()
    {
        $result = $this->db->table('p_isian_pemutu as isian')
        ->select('
            isian.id,
            unit.nama AS nama_unit,
            periode.ts AS tahun_ajaran,
            instrumen.jenjang AS jenjang,
            instrumen.indikator AS indikator,
            isian.isian,
            isian.status
        ')
        ->join('p_unit_pemutu as punit', 'punit.id = isian.id_unitpemutu')
        ->join('m_unit as unit', 'unit.id = punit.id_unit')
        ->join('m_periode as periode', 'periode.id = punit.id_periode')
        ->join('p_instrumen_pemutu as instrumen', 'instrumen.id = isian.id_instrumen')
        ->get()
        ->getResultArray();

        // Mapping jenjang ke teks
        $jenjangMap = [
            1 => 'S3',
            2 => 'S2',
            3 => 'S1',
            4 => 'D4',
            5 => 'D3',
            6 => 'D2',
            7 => 'D1',
        ];

        // Tambahkan field jenjang_text ke setiap baris
        foreach ($result as &$row) {
            $row['jenjang_text'] = $jenjangMap[$row['jenjang']] ?? 'Unknown';
        }

        return $result;
    }

    public function getAllPeriode()
    {
        return $this->db->table('m_periode')
            ->select('id, ts')
            ->orderBy('ts', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Mengambil ID instrumen yang sudah digunakan untuk unit pemutu tertentu
     * @param int $unitPemutuId ID unit pemutu
     * @param int|null $excludeId ID data yang dikecualikan (untuk mode edit)
     * @return array Array berisi ID instrumen yang sudah digunakan
     */
    public function getUsedInstrumenByUnitPemutu($unitPemutuId, $excludeId = null)
    {
        $builder = $this->db->table($this->table)
            ->select('id_instrumen')
            ->where('id_unitpemutu', $unitPemutuId);

        // Jika ada ID yang dikecualikan (untuk mode edit)
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }

        $result = $builder->get()->getResultArray();
        
        // Extract hanya ID instrumen
        return array_column($result, 'id_instrumen');
    }

    /**
     * Cek apakah instrumen sudah digunakan untuk unit pemutu tertentu
     * @param int $unitPemutuId ID unit pemutu
     * @param int $instrumenId ID instrumen
     * @param int|null $excludeId ID data yang dikecualikan (untuk mode edit)
     * @return bool True jika sudah digunakan, false jika belum
     */
    public function isInstrumenUsed($unitPemutuId, $instrumenId, $excludeId = null)
    {
        $builder = $this->where('id_unitpemutu', $unitPemutuId)
                        ->where('id_instrumen', $instrumenId);

        // Jika ada ID yang dikecualikan (untuk mode edit)
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }

        return $builder->countAllResults() > 0;
    }

    /**
     * Mengambil statistik penggunaan instrumen per unit pemutu
     * @param int $unitPemutuId ID unit pemutu
     * @return array Statistik penggunaan instrumen
     */
    public function getInstrumenUsageStats($unitPemutuId)
    {
        // Hitung total instrumen yang tersedia untuk unit pemutu
        $totalInstrumen = $this->db->table('p_instrumen_pemutu as instrumen')
            ->join('p_unit_pemutu as unit', 'unit.id_periode = instrumen.id_periode AND unit.id_unit = instrumen.id_unit')
            ->where('unit.id', $unitPemutuId)
            ->countAllResults();

        // Hitung instrumen yang sudah digunakan
        $usedInstrumen = $this->where('id_unitpemutu', $unitPemutuId)
                              ->countAllResults();

        return [
            'total_instrumen' => (int)$totalInstrumen,
            'used_instrumen' => (int)$usedInstrumen,
            'available_instrumen' => (int)($totalInstrumen - $usedInstrumen),
            'usage_percentage' => $totalInstrumen > 0 ? round(($usedInstrumen / $totalInstrumen) * 100, 2) : 0
        ];
    }

    /**
     * Mengambil daftar unit pemutu beserta statistik penggunaan instrumen
     * @return array Daftar unit pemutu dengan statistik
     */
    public function getUnitPemutuWithStats()
    {
        $unitPemutus = $this->db->table('p_unit_pemutu as punit')
            ->select('punit.id, unit.nama as nama_unit, periode.ts as tahun_ajaran')
            ->join('m_unit as unit', 'unit.id = punit.id_unit')
            ->join('m_periode as periode', 'periode.id = punit.id_periode')
            ->get()
            ->getResultArray();

        // Tambahkan statistik untuk setiap unit pemutu
        foreach ($unitPemutus as &$unit) {
            $stats = $this->getInstrumenUsageStats($unit['id']);
            $unit = array_merge($unit, $stats);
        }

        return $unitPemutus;
    }

    /**
     * Validasi data sebelum save/update
     * @param array $data Data yang akan disimpan
     * @param int|null $excludeId ID data yang dikecualikan (untuk mode edit)
     * @return array|true Array error jika ada kesalahan, true jika valid
     */
    public function validateData($data, $excludeId = null)
    {
        $errors = [];

        // Validasi required fields
        if (empty($data['id_unitpemutu'])) {
            $errors[] = 'Unit Pemutu harus dipilih';
        }

        if (empty($data['id_instrumen'])) {
            $errors[] = 'Instrumen harus dipilih';
        }

        if (!isset($data['isian']) || $data['isian'] === '') {
            $errors[] = 'Isian harus diisi';
        }

        if (!is_numeric($data['isian'])) {
            $errors[] = 'Isian harus berupa angka';
        }

        if (!in_array($data['status'], [0, 1])) {
            $errors[] = 'Status tidak valid';
        }

        // Validasi duplikasi instrumen
        if (!empty($data['id_unitpemutu']) && !empty($data['id_instrumen'])) {
            if ($this->isInstrumenUsed($data['id_unitpemutu'], $data['id_instrumen'], $excludeId)) {
                $errors[] = 'Instrumen ini sudah digunakan untuk unit pemutu yang dipilih';
            }
        }

        return empty($errors) ? true : $errors;
    }
}