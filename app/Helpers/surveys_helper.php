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
?>