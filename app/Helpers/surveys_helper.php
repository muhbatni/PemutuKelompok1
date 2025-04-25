<?php

function createSurveyData($database, $tableName, $dataPlaceholder, $data)
{
  $pQuery = $database->prepare(static fn($database) => $database->table($tableName)->insert($data));
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
    $jenisValue = isset($jenis[$index]) && is_numeric($jenis[$index]) ? (int) $jenis[$index] : null;
    if ($jenisValue === null || empty($teks)) {
      continue;
    }
    $pertanyaanData[] = [
      'id_survey' => $idSurvey,
      'teks' => $teks,
      'jenis' => $jenis[$index],
      'is_aktif' => true,
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => date('Y-m-d H:i:s'),
    ];
  }
  if (empty($pertanyaanData)) {
    return null;
  }
  $database->table('s_pertanyaan')->insertBatch($pertanyaanData);
  return $database->insertID();
}
function editSurveyData($database, $tableName, $dataPlaceholder, $data, $id)
{

  $database->table($tableName)->where('id', $id)->update($data);
  return $database->affectedRows() > 0;
}
function editPertanyaanData($database, $data, $idSurvey)
{
  $pertanyaan = $data['pertanyaan'] ?: null;
  $jenis = $data['jenis'] ?: null;
  $id_pertanyaan = $data['id_pertanyaan'] ?: null;
  if (!$idSurvey || !$pertanyaan || !$jenis) {
    return null;
  }
  $pertanyaanData = [];
  foreach ($pertanyaan as $index => $teks) {
    $jenisValue = isset($jenis[$index]) && is_numeric($jenis[$index]) ? (int) $jenis[$index] : 1;

    $pertanyaanData[] = [
      'id' => $id_pertanyaan[$index],
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