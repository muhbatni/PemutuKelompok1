<?php $isEdit = isset($edit); ?>

<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">Formulir Isian Pemutu Unit</h3>
          </div>
        </div>
      </div>

      <form class="m-form m-form--fit m-form--label-align-right" method="post" action="">
        <?php if ($isEdit): ?>
          <input type="hidden" name="id" value="<?= esc($edit['id']) ?>">
        <?php endif; ?>

        <!-- Unit Pemutu -->
        <div class="form-group m-form__group">
          <label for="id_unitpemutu">Pilih Unit Pemutu</label>
          <select class="form-control js-example-basic-single" id="id_unitpemutu" name="id_unitpemutu" required>
            <option value="" disabled hidden <?= !$isEdit ? 'selected' : '' ?>>-- Pilih --</option>
            <?php foreach ($unitpemutus as $unit): ?>
              <option value="<?= $unit['id'] ?>" <?= $isEdit && $edit['id_unitpemutu'] == $unit['id'] ? 'selected' : '' ?>>
                <?= $unit['nama_unit'] ?> - <?= $unit['tahun_ajaran'] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Instrumen -->
        <div class="form-group m-form__group">
          <label for="id_instrumen">Pilih Instrumen</label>
          <select class="form-control" id="id_instrumen" name="id_instrumen" required>
            <option value="" disabled hidden <?= !$isEdit ? 'selected' : '' ?>>-- Pilih --</option>
            <?php foreach ($instrumen_list as $index => $instrumen): ?>
              <option value="<?= $instrumen['id'] ?>" <?= $isEdit && $edit['id_instrumen'] == $instrumen['id'] ? 'selected' : '' ?>>
                <?= $index + 1 ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Data dari Instrumen -->
        <div class="form-group m-form__group">
          <label>Detail Instrumen</label>
          <input type="text" class="form-control mb-2" id="lembaga" placeholder="Lembaga" readonly>
          <input type="text" class="form-control mb-2" id="jenjang_instrumen" placeholder="Jenjang" readonly>
          <input type="text" class="form-control mb-2" id="indikator" placeholder="Indikator" readonly>
          <input type="text" class="form-control mb-2" id="kondisi" placeholder="Kondisi" readonly>
          <input type="text" class="form-control mb-2" id="batas" placeholder="Batas" readonly>
        </div>

        <!-- Isian -->
        <div class="form-group m-form__group">
          <label for="isian">Isian (Hanya angka)</label>
          <input type="number" class="form-control" id="isian" name="isian" required min="0" step="1"
                 value="<?= $isEdit ? esc($edit['isian']) : '' ?>">
        </div>

        <!-- Status Otomatis -->
        <div class="form-group m-form__group">
          <label for="status_display">Status</label>
          <select class="form-control" id="status_display" disabled>
            <option value="">-</option>
            <option value="0">Tidak Lolos</option>
            <option value="1">Lolos</option>
          </select>
          <input type="hidden" name="status" id="status_hidden" value="<?= $isEdit ? esc($edit['status']) : '' ?>">
        </div>

        <!-- Tombol Aksi -->
        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <a href="<?= site_url('akreditasi/isian-pemutu-unit') ?>" class="btn btn-danger me-2">
              <i class="fa fa-arrow-left"></i> Batal
            </a>
            <button type="reset" class="btn btn-warning me-2">
              <i class="fa fa-paint-brush"></i> Reset
            </button>
            <?php if ($isEdit): ?>
              <button type="button" class="btn btn-primary" onclick="showUpdateModal()">
                <i class="fa fa-save"></i> Perbarui
              </button>
            <?php else: ?>
              <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Simpan
              </button>
            <?php endif; ?>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Flash Message -->
<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success mt-3"><?= session()->getFlashdata('success') ?></div>
<?php endif ?>

<!-- Modal Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form method="get">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Konfirmasi Hapus</h5>
          <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="delete" id="deleteId">
          <p>Apakah Anda yakin ingin menghapus data ini?</p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Ya, Hapus</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Update -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title">Konfirmasi Perbarui Data</h5>
        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">Apakah Anda yakin ingin memperbarui data ini?</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" onclick="submitUpdate()">Ya, Perbarui</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

<!-- Script -->
<script>
  // Mapping jenjang
  const jenjangMap = {
    1: 'S3', 2: 'S2', 3: 'S1',
    4: 'D4', 5: 'D3', 6: 'D2', 7: 'D1'
  };

  // Data instrumen (dari PHP)
  const instrumenData = <?= json_encode(array_column($instrumen_list, null, 'id')) ?>;

  // Select2
  $(function () {
    $('.js-example-basic-single').select2({
      placeholder: "-- Pilih --",
      allowClear: true
    });
  });

  // Ketika instrumen berubah
  document.getElementById('id_instrumen').addEventListener('change', function () {
    const selectedId = this.value;
    const data = instrumenData[selectedId] || {};

    document.getElementById('lembaga').value = data.nama_lembaga || '';
    document.getElementById('jenjang_instrumen').value = jenjangMap[data.jenjang] || '';
    document.getElementById('indikator').value = data.indikator || '';
    document.getElementById('kondisi').value = data.kondisi || '';
    document.getElementById('batas').value = data.batas || '';
  });

  // Perhitungan status
  document.getElementById('isian').addEventListener('input', function () {
    const isian = parseFloat(this.value);
    const kondisi = document.getElementById('kondisi').value.trim();
    const batas = parseFloat(document.getElementById('batas').value);
    let status = '';

    if (!isNaN(isian) && !isNaN(batas)) {
      switch (kondisi) {
        case '>':  status = isian > batas ? 1 : 0; break;
        case '>=': status = isian >= batas ? 1 : 0; break;
        case '<':  status = isian < batas ? 1 : 0; break;
        case '<=': status = isian <= batas ? 1 : 0; break;
        case '=':  status = isian == batas ? 1 : 0; break;
        default:   status = '';
      }
    }

    document.getElementById('status_display').value = status;
    document.getElementById('status_hidden').value = status;
  });

  function showDeleteModal(id) {
    document.getElementById('deleteId').value = id;
    $('#deleteModal').modal('show');
  }

  function showUpdateModal() {
    $('#updateModal').modal('show');
  }

  function submitUpdate() {
    document.querySelector('form.m-form').submit();
  }
</script>
