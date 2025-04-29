<?php
namespace App\Models;

use CodeIgniter\Model;

class AuditorModel extends Model
{
    protected $table = 'a_auditor'; // Tabel utama
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false; 
    protected $allowedFields = ['id','dokumen']; // Kolom yang diizinkan untuk diisi

    public function getAll()
    {
        // Join dengan tabel m_user untuk mendapatkan username
        return $this->select('a_auditor.id, m_user.username, a_auditor.dokumen')
                    ->join('m_user', 'm_user.id = a_auditor.id') // Join berdasarkan user_id
                    ->findAll();
    }

    // public function simpanAuditor($data)
    // {
    //     return $this->insert($data);
    // }
}