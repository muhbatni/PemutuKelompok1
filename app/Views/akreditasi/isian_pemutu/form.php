<?php $isEdit = isset($edit); ?>

<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">Formulir Isian Pemutu</h3>
          </div>
        </div>
      </div>

      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" method="post" action="">
        <?php if ($isEdit): ?>
          <input type="hidden" name="id" value="<?= esc($edit['id']) ?>">
        <?php endif ?>

        <!-- Pilih Unit Pemutu -->
        <div class="form-group m-form__group">
          <label for="id_unitpemutu">Pilih Unit Pemutu</label>
          <select class="form-control js-example-basic-single" id="id_unitpemutu" name="id_unitpemutu" required>
            <option value="" selected disabled hidden></option>
            <?php foreach ($unitpemutus as $unit): ?>
              <option value="<?= $unit['id'] ?>" <?= $isEdit && $edit['id_unitpemutu'] == $unit['id'] ? 'selected' : '' ?>>
                <?= $unit['nama_unit'] ?> - <?= $unit['tahun_ajaran'] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Pilih Instrumen Pemutu -->
        <div class="form-group m-form__group">
          <label for="id_instrumen">Pilih Instrumen</label>
          <select class="form-control" id="id_instrumen" name="id_instrumen" required>
            <option value="">-- Pilih --</option>
            <?php foreach ($instrumen_list as $index => $instrumen): ?>
              <option value="<?= $instrumen['id'] ?>" <?= $isEdit && $edit['id_instrumen'] == $instrumen['id'] ? 'selected' : '' ?>>
                <?= ($index + 1).' - '.$instrumen['nama_lembaga'].' - '.$instrumen['indikator'] ?>
              </option>
            <?php endforeach ?>
          </select>
        </div>


        <!-- form input untuk isi dari instrumen pemutu -->
        <div class="form-group m-form__group">
          <label for="lembaga">Isi dari Instrumen Pemutu</label>

          <input type="text" class="form-control m-input mb-2" id="lembaga" name="lembaga" placeholder="Lembaga"
            readonly>

          <input type="text" class="form-control m-input mb-2" id="jenjang_instrumen" name="jenjang_instrumen"
            placeholder="Jenjang" readonly>

          <input type="text" class="form-control m-input mb-2" id="indikator" name="indikator" placeholder="Indikator"
            readonly>

          <input type="text" class="form-control m-input mb-2" id="kondisi" name="kondisi" placeholder="Kondisi"
            readonly>

          <input type="text" class="form-control m-input mb-2" id="batas" name="batas" placeholder="Batas" readonly>
        </div>

        <!-- form input untuk isian pemutu -->
        <div class="form-group m-form__group">
          <label for="isian">Isian (Hanya angka)</label>
          <input type="number" class="form-control m-input" id="isian" name="isian" required min="0" step="1"
            value="<?= $isEdit ? htmlspecialchars($edit['isian']) : '' ?>">
        </div>

        <div class="form-group m-form__group">
          <label for="status">Status (otomatis terisi apabila isian terisi)</label>
          <select class="form-control m-input" id="status_display" disabled>
            <option value="">-- Pilih --</option>
            <option value="0" <?= $isEdit && (int) $edit['status'] === 0 ? 'selected' : '' ?>>Tidak Lolos</option>
            <option value="1" <?= $isEdit && (int) $edit['status'] === 1 ? 'selected' : '' ?>>Lolos</option>
          </select>
          <!-- Hidden input untuk nilai sebenarnya -->
          <input type="hidden" name="status" value="<?= $isEdit ? (int) $edit['status'] : '' ?>">
        </div>

        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <a href="<?= site_url('akreditasi/isian-pemutu') ?>" class="btn btn-danger me-2">
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
      <!--end::Form-->
    </div>
  </div>
</div>

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

<script>


  // Event saat input isian berubah
  document.getElementById('isian').addEventListener('input', function () {
    const isian = parseFloat(this.value);
    const kondisi = document.getElementById('kondisi').value.trim();
    const batas = parseFloat(document.getElementById('batas').value);
    let status = '';

    if (!isNaN(isian) && !isNaN(batas)) {
      switch (kondisi) {
        case '>':
          status = isian > batas ? 1 : 0;
          break;
        case '>=':
          status = isian >= batas ? 1 : 0;
          break;
        case '<':
          status = isian < batas ? 1 : 0;
          break;
        case '<=':
          status = isian <= batas ? 1 : 0;
          break;
        case '=':
          status = isian == batas ? 1 : 0;
          break;
        default:
          status = 0;
      }
    } else {
      status = '';
    }

    // Set ke select disabled
    document.getElementById('status_display').value = status;
    // Set ke hidden input untuk disimpan
    document.querySelector('input[name="status"]').value = status;
  });

  // Inisialisasi Select2 untuk dropdown
  $(document).ready(function () {
    $('.js-example-basic-single').select2({
      placeholder: "-- Pilih --",
      allowClear: true
    });
  });

  //jenjangMap untuk mengubah id jenjang ke teks
  const jenjangMap = {
    1: 'S3',
    2: 'S2',
    3: 'S1',
    4: 'D4',
    5: 'D3',
    6: 'D2',
    7: 'D1'
  };

  // Simpan data instrumen dalam JS
  const instrumenData = <?= json_encode(array_column($instrumen_list, null, 'id')) ?>;

  // Ketika dropdown berubah, isi input-input di bawah
  document.getElementById('id_instrumen').addEventListener('change', function () {
    const selectedId = this.value;
    const data = instrumenData[selectedId];

    if (data) {
      document.getElementById('lembaga').value = data.nama_lembaga || '';
      document.getElementById('jenjang_instrumen').value = jenjangMap[data.jenjang] || '';
      document.getElementById('indikator').value = data.indikator || '';
      document.getElementById('kondisi').value = data.kondisi || '';
      document.getElementById('batas').value = data.batas || '';
    } else {
      // Kosongkan jika tidak ada pilihan
      document.getElementById('lembaga').value = '';
      document.getElementById('jenjang_instrumen').value = '';
      document.getElementById('indikator').value = '';
      document.getElementById('kondisi').value = '';
      document.getElementById('batas').value = '';
    }
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