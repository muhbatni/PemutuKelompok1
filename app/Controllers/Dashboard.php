<?php
// Di controller atau bagian yang sesuai, ambil data periode dari database
$periodeModel = new \App\Models\PeriodeModel(); // Sesuaikan dengan nama model Anda
$periodeList = $periodeModel->findAll(); // Atau query khusus jika diperlukan
?>

<!-- Di bagian HTML dropdown -->
<select id="filterTahun" class="form-select w-auto">
  <option value="">-- Semua Tahun --</option>
  <?php if (!empty($periodeList)): ?>
    <?php foreach ($periodeList as $periode): ?>
      <option value="<?= esc($periode['tahun']) ?>">
        <?= esc($periode['tahun']) ?> (<?= esc($periode['ts']) ?>)
      </option>
    <?php endforeach; ?>
  <?php else: ?>
    <option value="">Tidak ada data periode</option>
  <?php endif; ?>
</select>