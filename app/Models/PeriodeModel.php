<?php

namespace App\Models;

use CodeIgniter\Model;

class PeriodeModel extends Model
{
<<<<<<< HEAD
    protected $table = 'm_periode'; // Sesuaikan dengan nama tabel di database
    protected $primaryKey = 'id';
    protected $allowedFields = ['tahun', 'ts'];

    public function getPeriodes()
    {
        // Ambil data periode dari database
        return $this->select('id, tahun, ts')->findAll();
    }
}
=======
  protected $table = 'm_periode';
  protected $primaryKey = 'id';
  protected $allowedFields = ['tahun', 'ts'];

  public function getPeriodes()
  {
    return $this->findAll();
  }
}
>>>>>>> 4e213614bcc5e1bffaf4fa4e1ed8b3c8bad3aa59
