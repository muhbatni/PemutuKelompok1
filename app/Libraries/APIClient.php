<?php

namespace App\Libraries;

class APIClient
{
  protected static $baseUrl = 'http://localhost:3000/api';

  protected static function request($method, $endpoint, $data = null)
  {
    if (!extension_loaded('curl')) {
      throw new \RuntimeException('cURL extension is not loaded. Please enable it in php.ini');
    }
    $url = self::$baseUrl . $endpoint;
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

  public static function getAllStandar()
  {
    return self::request('get', '/standar');
  }

  public static function getStandar($id)
  {
    return self::request('get', "/standar/{$id}");
  }

  public static function createStandar($data)
  {
    $requiredFields = ['id_parent', 'nama', 'dokumen', 'is_aktif'];
    foreach ($requiredFields as $field) {
      if (!isset($data[$field])) {
        return ['error' => "Field '{$field}' is required"];
      }
    }

    return self::request('post', '/standar', $data);
  }

  public static function updateStandar($id, $data)
  {
    $requiredFields = ['nama', 'dokumen', 'is_aktif', 'id_parent'];
    foreach ($requiredFields as $field) {
      if (!array_key_exists($field, $data)) {
        return ['error' => "Field '{$field}' is required"];
      }
    }

    return self::request('put', "/standar/{$id}", $data);
  }

  public static function deleteStandar($id)
  {
    return self::request('delete', "/standar/{$id}");
  }

  public static function createStandarWithParams($id_parent, $nama, $dokumen, $is_aktif = true)
  {
    $data = [
      'id_parent' => $id_parent,
      'nama' => $nama,
      'dokumen' => $dokumen,
      'is_aktif' => $is_aktif
    ];

    return self::createStandar($data);
  }

  public static function updateStandarWithParams($id, $nama, $dokumen, $is_aktif = true, $id_parent = null)
  {
    $data = [
      'nama' => $nama,
      'dokumen' => $dokumen,
      'is_aktif' => $is_aktif,
      'id_parent' => $id_parent
    ];
    return self::updateStandar($id, $data);
  }

  public static function createPelaksanaanSurvey($data)
  {
    $requiredFields = ['id_survey', 'id_periode', 'tanggal_mulai', 'tanggal_selesai'];
    foreach ($requiredFields as $field) {
      if (!isset($data[$field])) {
        return ['error' => "Field '{$field}' is required"];
      }
    }

    return self::request('post', '/pelaksanaan-survey', $data);
  }

  public static function getPelaksanaanSurvey()
  {
    return self::request('get', "/pelaksanaan-survey");
  }

  public static function deleteSurvey($id)
  {
    return self::request("delete", "/surveys/$id");
  }
}