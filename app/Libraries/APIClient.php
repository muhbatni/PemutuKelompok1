<?php

namespace App\Libraries;

class APIClient
{
  protected $baseUrl = 'http://localhost:3000/api';

  protected function request($method, $endpoint, $data = null)
  {
    if (!extension_loaded('curl')) {
      throw new \RuntimeException('cURL extension is not loaded. Please enable it in php.ini');
    }
    $url = $this->baseUrl . $endpoint;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    if ($data) {
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if ($error) {
      return ['error' => $error];
    }
    return json_decode($response, true);
  }

  public function getAllStandar()
  {
    return $this->request('get', '/standar');
  }

  public function getStandar($id)
  {
    return $this->request('get', "/standar/{$id}");
  }

  public function createStandar($data)
  {
    // Validasi field yang diperlukan
    $requiredFields = ['id_parent', 'nama', 'dokumen', 'is_aktif'];
    foreach ($requiredFields as $field) {
      if (!isset($data[$field])) {
        return ['error' => "Field '{$field}' is required"];
      }
    }

    return $this->request('post', '/standar', $data);
  }

  public function updateStandar($id, $data)
  {
    // Validasi field yang diperlukan untuk update
    $requiredFields = ['nama', 'dokumen', 'is_aktif', 'id_parent'];
    foreach ($requiredFields as $field) {
      if (!array_key_exists($field, $data)) {
        return ['error' => "Field '{$field}' is required"];
      }
    }

    return $this->request('put', "/standar/{$id}", $data);
  }

  public function deleteStandar($id)
  {
    return $this->request('delete', "/standar/{$id}");
  }

  public function createStandarWithParams($id_parent, $nama, $dokumen, $is_aktif = true)
  {
    $data = [
      'id_parent' => $id_parent,
      'nama' => $nama,
      'dokumen' => $dokumen,
      'is_aktif' => $is_aktif
    ];

    return $this->createStandar($data);
  }


  public function updateStandarWithParams($id, $nama, $dokumen, $is_aktif = true, $id_parent = null)
  {
    $data = [
      'nama' => $nama,
      'dokumen' => $dokumen,
      'is_aktif' => $is_aktif,
      'id_parent' => $id_parent
    ];

    return $this->updateStandar($id, $data);
  }
}