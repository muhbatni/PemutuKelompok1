<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;
use Firebase\JWT\Key;

class Pemutu extends BaseConfig
{
  public $myConfig = [];

  public function __construct()
  {
    $this->myConfig['jwt_secret'] = new Key(getenv('JWT_SECRET'), 'HS256');
    // $this->myConfig[''] = ;
  }
}
?>