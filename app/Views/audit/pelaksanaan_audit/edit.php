<div class="row mb-4">
  <div class="col-md-6">
    <label for="auditor">Pilih Auditor</label>
    <select id="auditor" class="form-control select2">
      <option value="">-- Pilih Auditor --</option>
      <!-- Loop data auditor di sini -->
    </select>
  </div>
  <div class="col-md-6">
    <label for="unit">Pilih Unit</label>
    <select id="unit" class="form-control select2">
      <option value="">-- Pilih Unit --</option>
      <!-- Loop data unit di sini -->
    </select>
  </div>
</div>


<div class="row">
  <div class="col-md-4">
    <div class="list-group" id="list-standar">
      <?php foreach ($standar as $item): ?>
        <a href="#" class="list-group-item list-group-item-action" data-standar-id="<?= $item->id_standar ?>">
          <?= esc($item->nama) ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="col-md-8">
    <div id="indikator-content">
      <h6>Silakan pilih standar di sebelah kiri</h6>
    </div>
  </div>
</div>


<div class="col-md-8">
  <h6>Indikator Audit</h6>
  <form action="<?= base_url('public/audit/pelaksanaan-audit/simpan/' . $id_audit); ?>" method="post">
    <?php foreach ($indikator as $i): ?>
      <div class="card mb-3">
        <div class="card-body">
          <strong><?= esc($i->indikator); ?></strong>
          <p><?= esc($i->pernyataan); ?></p>
          <textarea name="jawaban[<?= $i->id; ?>]" class="form-control" placeholder="Isi jawaban audit"></textarea>
        </div>
      </div>
    <?php endforeach; ?>

    <button type="submit" class="btn btn-primary">Simpan Jawaban Audit</button>
  </form>
</div>
</div>

<script>
  $(document).ready(function () {
    $('.select2').select2(); // untuk searchable dropdown

    // Klik standar
    $('#list-standar a').on('click', function (e) {
      e.preventDefault();
      var standarId = $(this).data('standar-id');

      // Panggil data indikator via AJAX (bisa nanti)
      $('#indikator-content').html('<p>Loading indikator untuk standar ID: ' + standarId + '...</p>');

      // TODO: Load indikator + form isian berdasarkan standarId
    });
  });
</script>