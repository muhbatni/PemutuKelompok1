<?php

function createSurveyData($database, $tableName, $dataPlaceholder, $data)
{
  $pQuery = $database->prepare(static fn($database) => $database->table($tableName)->insert($dataPlaceholder));
  $pQuery->execute(...array_values($data));
  return $database->insertID();
}

function createPertanyaanData($database, $data)
{
  $idSurvey = $data['id_survey'] ?: null;
  $pertanyaan = $data['pertanyaan'] ?: null;
  $jenis = $data['jenis'] ?: null;
  if (!$idSurvey || !$pertanyaan || !$jenis) {
    return null;
  }
  $pertanyaanData = [];
  foreach ($pertanyaan as $index => $teks) {
    $jenisValue = isset($jenis[$index]) && is_numeric($jenis[$index]) ? (int) $jenis[$index] : 1;
    $pertanyaanData[] = [
      'id_survey' => $idSurvey,
      'teks' => $teks,
      'jenis' => $jenisValue,
      'is_aktif' => true,
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => date('Y-m-d H:i:s'),
    ];
  }
  if (empty($pertanyaanData)) {
    return null;
  }
  $database->table('s_pertanyaan')->insertBatch($pertanyaanData);
  return true;
}
function editSurveyData($database, $tableName, $dataPlaceholder, $data, $id)
{

  $database->table($tableName)->where('id', $id)->update($data);
  return $database->affectedRows() > 0;
}
function editPertanyaanData($database, $data)
{
  $idSurvey = $data['id_survey'] ?: null;
  $idPertanyaan = $data['id_pertanyaan'] ?: null;
  $pertanyaan = $data['pertanyaan'] ?: null;
  $jenis = $data['jenis'] ?: null;
  if (!$idSurvey || !$idPertanyaan || !$pertanyaan || !$jenis) {
    return null;
  }
  $pertanyaanData = [];
  foreach ($pertanyaan as $index => $teks) {
    $jenisValue = isset($jenis[$index]) && is_numeric($jenis[$index]) ? (int) $jenis[$index] : 1;
    $pertanyaanData[] = [
      'id' => $idPertanyaan[$index],
      'id_survey' => $idSurvey,
      'teks' => $teks,
      'jenis' => $jenisValue,
      'is_aktif' => true,
      'updated_at' => date('Y-m-d H:i:s'),
    ];
  }
  if (empty($pertanyaanData)) {
    return null;
  }
  $database->table('s_pertanyaan')->updateBatch($pertanyaanData, 'id');
  return $database->affectedRows() > 0;
}
?>