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
      'urutan' => $index + 1,
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

function editSurveyData($database, $tableName, $data, $id)
{
  $database->table($tableName)->where('id', $id)->update($data);
  return $database->affectedRows() > 0;
}

function editPertanyaanData($database, $data)
{
  $builder = $database->table('s_pertanyaan');
  $idSurvey = $data['id_survey'] ?? null;
  $idPertanyaan = $data['id_pertanyaan'] ?? null;
  $pertanyaan = $data['pertanyaan'] ?? null;
  $jenis = $data['jenis'] ?? null;

  if (!$idSurvey || !$pertanyaan || !$jenis) {
    return null;
  }

  $existingIds = [];
  $pertanyaanDataUpdate = [];
  $pertanyaanDataInsert = [];

  foreach ($pertanyaan as $index => $teks) {
    $jenisValue = isset($jenis[$index]) && is_numeric($jenis[$index]) ? (int) $jenis[$index] : 1;
    if (isset($idPertanyaan[$index]) && !empty($idPertanyaan[$index])) {
      // Existing question - add to update array
      $existingIds[] = $idPertanyaan[$index];
      $pertanyaanDataUpdate[] = [
        'id' => $idPertanyaan[$index],
        'id_survey' => $idSurvey,
        'teks' => $teks,
        'jenis' => $jenisValue,
        'is_aktif' => true,
        'urutan' => $index + 1,
        'updated_at' => date('Y-m-d H:i:s'),
      ];
      continue;
    }
    $pertanyaanDataInsert[] = [
      'id_survey' => $idSurvey,
      'teks' => $teks,
      'jenis' => $jenisValue,
      'is_aktif' => true,
      'urutan' => $index + 1,
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => date('Y-m-d H:i:s'),
    ];
  }

  // Delete questions that no longer exist
  if (!empty($existingIds)) {
    $builder->where('id_survey', $idSurvey)
      ->whereNotIn('id', $existingIds)
      ->delete();
  } else if (!empty($idPertanyaan)) {
    // If we have some IDs but none were valid, still delete as before
    $builder->where('id_survey', $idSurvey)
      ->whereNotIn('id', $idPertanyaan)
      ->delete();
  }

  if (!empty($pertanyaanDataUpdate)) {
    try {
      $builder->updateBatch($pertanyaanDataUpdate, 'id');
    } catch (\Exception $e) {
      log_message('error', 'Update batch error: ' . $e->getMessage());
      return false;
    }
  }

  if (!empty($pertanyaanDataInsert)) {
    try {
      $builder->insertBatch($pertanyaanDataInsert);
    } catch (\Exception $e) {
      log_message('error', 'Insert batch error: ' . $e->getMessage());
      return false;
    }
  }

  return true;
}
?>