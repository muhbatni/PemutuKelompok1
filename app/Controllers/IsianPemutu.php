<?php

namespace App\Controllers;

use App\Models\IsianPemutuModel;
use App\Models\UnitPemutuModel; // Tambahkan use statement untuk model UnitPemutu
use App\Models\UnitModel;
use App\Models\LembagaAkreditasiModel;

class IsianPemutu extends BaseController
{
    public function index()
    {
        $unitPemutuModel = new UnitPemutuModel();

        // Ambil semua data dari tabel p_isian_pemutu dan join dengan m_unit
        $data['unitpemutus'] = $unitPemutuModel->select('p.id, m.nama AS nama_unit')
                                                ->from('p_isian_pemutu p') // Specify the table 'p_isian_pemutu' with alias 'p'
                                                ->join('m_unit m', 'p.id_unitpemutu = m.id')
                                                ->findAll();

        // Ambil data lembaga
        $data['isianlembaga'] = $unitPemutuModel->select('p.id, m.nama AS nama_lembaga')
                                                ->from('p_isian_pemutu p') // Specify the table 'p_isian_pemutu' with alias 'p'
                                                ->join('m_lembaga_akreditasi m', 'p.id_unitpemutu = m.id')
                                                ->findAll();

        // Use UnitModel to get units
        $unitModel = new UnitModel();
        $data['units'] = $unitModel->getUnits();

        // Use LembagaAkreditasiModel to get lembagas
        $lembagaModel = new LembagaAkreditasiModel();
        $data['lembagas'] = $lembagaModel->getLembagas();

        $data["title"] = "Isian Pemutu";
        echo view('layouts/header.php', $data);
        echo view('akreditasi/isian_pemutu/form.php', $data);
        echo view('layouts/footer.php');
    }
}