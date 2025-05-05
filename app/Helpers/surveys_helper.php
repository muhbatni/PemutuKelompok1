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
    if (empty($teks)) {
      continue;
    }
    $jenisValue = isset($jenis[$index]) && is_numeric($jenis[$index]) ? (int) $jenis[$index] : 1;
    $urutan = $index + 1;
    $pertanyaanData[] = [
      'id_survey' => $idSurvey,
      'teks' => $teks,
      'jenis' => $jenisValue,
      'is_aktif' => true,
      'urutan' => $urutan,
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => date('Y-m-d H:i:s'),
    ];
    log_message('info', 'Pertanyaan data: ' . json_encode($pertanyaanData));
  }

  if (empty($pertanyaanData)) {
    return null;
  }

  $database->table('s_pertanyaan')->insertBatch($pertanyaanData);
  return $database->affectedRows() > 0;
}

function editSurveyData($database, $tableName, $data, $id, $column = 'id')
{
  $database->table($tableName)->where($column, $id)->update($data);
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
    $jenisValue = isset($jenis[$index]) && is_numeric($jenis[$index]) ? (int) $jenis[$index] : null;
    if ($jenisValue === null) {
      throw new \Exception("Pilih jenis pertanyaan dahulu! pertanyaan ke-" . ($index + 1));
    }
    if (isset($idPertanyaan[$index]) && !empty($idPertanyaan[$index])) {
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

  if (!empty($existingIds)) {
    $builder->where('id_survey', $idSurvey)
      ->whereNotIn('id', $existingIds)
      ->delete();
  } else if (!empty($idPertanyaan)) {
    $builder->where('id_survey', $idSurvey)
      ->whereNotIn('id', $idPertanyaan)
      ->delete();
  }

  if (!empty($pertanyaanDataUpdate)) {
    try {
      $builder->updateBatch($pertanyaanDataUpdate, 'id');
    } catch (\Exception $exception) {
      log_message('error', 'Update batch error: ' . $exception->getMessage());
      return false;
    }
  }

  if (!empty($pertanyaanDataInsert)) {
    try {
      $builder->insertBatch($pertanyaanDataInsert);
    } catch (\Exception $exception) {
      log_message('error', 'Insert batch error: ' . $exception->getMessage());
      return false;
    }
  }

  return true;
}
?>