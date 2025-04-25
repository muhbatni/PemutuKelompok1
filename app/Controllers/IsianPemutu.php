<?php

namespace App\Controllers;

use App\Models\IsianPemutuModel;
use App\Models\UnitPemutuModel; // Tambahkan use statement untuk model UnitPemutu

class IsianPemutu extends BaseController
{
    public function index()
    {
        $unitPemutuModel = new UnitPemutuModel(); // Instansiasi model UnitPemutu

        // Ambil semua data dari tabel p_unit_pemutu
        $data['unitpemutus'] = $unitPemutuModel->findAll();

        $data["title"] = "Isian Pemutu";
        echo view('layouts/header.php', $data);
        echo view('akreditasi/isian_pemutu/form.php', $data);
        echo view('layouts/footer.php');
    }
}