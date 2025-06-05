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
          <label for="id_unitpemutu">Pilih Unit Pemutu <span class="text-danger">*</span></label>
          <select class="form-control js-example-basic-single" id="id_unitpemutu" name="id_unitpemutu" required>
            <option value="">-- Pilih Unit Pemutu --</option>
            <?php foreach ($unitpemutus as $unit): ?>
              <option value="<?= $unit['id'] ?>" <?= $isEdit && $edit['id_unitpemutu'] == $unit['id'] ? 'selected' : '' ?>>
                <?= $unit['nama_unit'] ?> - <?= $unit['tahun_ajaran'] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Pilih Instrumen Pemutu -->
        <div class="form-group m-form__group">
          <label for="id_instrumen">Pilih Instrumen <span class="text-danger">*</span></label>
          <select class="form-control" id="id_instrumen" name="id_instrumen" required disabled>
            <option value="">-- Pilih Unit Pemutu Terlebih Dahulu --</option>
          </select>
          <div class="form-text">
            <small id="loadingInstrumen" class="text-muted" style="display: none;">
              <i class="fa fa-spinner fa-spin"></i> Memuat instrumen...
            </small>
          </div>
        </div>


        <!-- form input untuk isi dari instrumen pemutu -->
        <div class="form-group m-form__group">
          <label>Detail Instrumen Pemutu</label>

          <!-- Baris 1: Lembaga & Jenjang -->
          <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control m-input mb-2" id="lembaga" name="lembaga" placeholder="Lembaga"
                readonly>
            </div>
            <div class="col-md-6">
              <input type="text" class="form-control m-input mb-2" id="jenjang_instrumen" name="jenjang_instrumen"
                placeholder="Jenjang" readonly>
            </div>
          </div>

          <!-- Baris 2: Indikator (75%) + Kondisi (25%) dan Batas (50%) -->
          <div class="row">
            <!-- Kolom kiri: indikator & kondisi -->
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-9 pr-1">
                  <input type="text" class="form-control m-input mb-2" id="indikator" name="indikator"
                    placeholder="Indikator" readonly>
                </div>
                <div class="col-md-3">
                  <input type="text" class="form-control m-input mb-2 text-center" id="kondisi" name="kondisi"
                    placeholder="Kondisi" readonly>
                </div>
              </div>
            </div>

            <!-- Kolom kanan: batas -->
            <div class="col-md-6">
              <input type="text" class="form-control m-input mb-2" id="batas" name="batas" placeholder="Batas" readonly>
            </div>
          </div>
        </div>

        <!-- form input untuk isian pemutu -->
        <div class="form-group m-form__group">
          <label for="isian">Isian (Hanya angka) <span class="text-danger">*</span></label>
          <input type="number" class="form-control m-input" id="isian" name="isian" required min="0" step="1"
            value="<?= $isEdit ? htmlspecialchars($edit['isian']) : '' ?>" placeholder="Masukkan nilai isian">
        </div>

        <!-- Status (auto calculated) -->
        <div class="form-group m-form__group">
          <label for="status">Status (otomatis terisi berdasarkan isian)</label>
          <select class="form-control m-input" id="status_display" disabled>
            <option value="">-- Status akan muncul setelah isian diisi --</option>
            <option value="0" <?= ($isEdit && $edit['status'] == 0) ? 'selected' : '' ?>>Tidak Lolos</option>
            <option value="1" <?= ($isEdit && $edit['status'] == 1) ? 'selected' : '' ?>>Lolos</option>
          </select>
          <!-- Hidden input untuk nilai sebenarnya -->
          <input type="hidden" name="status" id="status_hidden" value="<?= $isEdit ? (int) $edit['status'] : '' ?>">
        </div>

        <div class="m-portlet_foot m-portlet_foot--fit">
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

<!-- Alert Messages -->
<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success mt-3 alert-dismissible fade show">
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
<?php endif ?>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger mt-3 alert-dismissible fade show">
    <?= session()->getFlashdata('error') ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
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
  $(document).ready(function () {
    $('.js-example-basic-single').select2({
      placeholder: "-- Pilih Unit Pemutu --",
      allowClear: true
    });

    const jenjangMap = {
      1: 'S3', 2: 'S2', 3: 'S1', 4: 'D4',
      5: 'D3', 6: 'D2', 7: 'D1'
    };

    const editInstrumenId = '<?= $isEdit && !empty($edit['id_instrumen']) ? $edit['id_instrumen'] : '' ?>';

    $('#id_unitpemutu').change(function () {
      const unitPemutuId = $(this).val();
      const instrumenSelect = $('#id_instrumen');
      const loadingText = $('#loadingInstrumen');

      instrumenSelect.html('<option value="">-- Pilih Instrumen --</option>');
      clearInstrumenDetails();

      if (unitPemutuId !== '') {
        loadingText.show();
        instrumenSelect.prop('disabled', true);

        $.ajax({
          url: '<?= current_url() ?>',
          type: 'POST',
          data: {
            action: 'get-instrumen',
            id_unitpemutu: unitPemutuId,
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
          },
          dataType: 'json',
          success: function (response) {
            loadingText.hide();
            instrumenSelect.prop('disabled', false);

            if (response.status === 'success' && response.data.length > 0) {
              let options = '<option value="">-- Pilih Instrumen --</option>';

              response.data.forEach(function (item) {
                options += `<option value="${item.id}" 
                                        data-lembaga="${item.nama_lembaga}"
                                        data-jenjang="${item.jenjang}"
                                        data-indikator="${item.indikator}"
                                        data-kondisi="${item.kondisi}"
                                        data-batas="${item.batas}">
                                        ${item.text}
                                      </option>`;
              });

              instrumenSelect.html(options);

              // Jika mode edit, set selected instrumen
              <?php if ($isEdit && !empty($edit['id_instrumen'])): ?>
                instrumenSelect.val('<?= $edit['id_instrumen'] ?>').trigger('change');
              <?php endif; ?>

            } else {
              instrumenSelect.html('<option value="">Tidak ada instrumen tersedia</option>');
              console.warn('No instruments found:', response.message);
            }
          },
          error: function (xhr, status, error) {
            loadingText.hide();
            instrumenSelect.prop('disabled', false);
            instrumenSelect.html('<option value="">Terjadi kesalahan koneksi</option>');
            console.error('AJAX Error:', error);
          }
        });
      } else {
        instrumenSelect.prop('disabled', true);
        instrumenSelect.html('<option value="">-- Pilih Unit Pemutu Terlebih Dahulu --</option>');
      }
    });

    // Event handler untuk perubahan instrumen
    $('#id_instrumen').change(function () {
      const selectedOption = $(this).find('option:selected');

      if (selectedOption.val() !== '') {
        // Isi detail instrumen
        $('#lembaga').val(selectedOption.data('lembaga') || '');
        $('#jenjang_instrumen').val(jenjangMap[selectedOption.data('jenjang')] || '');
        $('#indikator').val(selectedOption.data('indikator') || '');
        $('#kondisi').val(selectedOption.data('kondisi') || '');
        $('#batas').val(selectedOption.data('batas') || '');
      } else {
        clearInstrumenDetails();
      }

      // Trigger perhitungan status jika ada isian
      $('#isian').trigger('input');
    });

    // Event handler untuk perubahan isian (menghitung status)
    $('#isian').on('input', function () {
      calculateStatus();
    });

    // Trigger change event jika mode edit
    <?php if ($isEdit && !empty($edit['id_unitpemutu'])): ?>
      $('#id_unitpemutu').trigger('change');
    <?php endif; ?>
  });

  // Function untuk clear detail instrumen
  function clearInstrumenDetails() {
    $('#lembaga').val('');
    $('#jenjang_instrumen').val('');
    $('#indikator').val('');
    $('#kondisi').val('');
    $('#batas').val('');
    $('#status_display').val('');
    $('#status_hidden').val('');
  }

  // Function untuk menghitung status
  function calculateStatus() {
    const isian = parseFloat($('#isian').val());
    const kondisi = $('#kondisi').val().trim();
    const batas = parseFloat($('#batas').val());
    let status = '';

    if (!isNaN(isian) && !isNaN(batas) && kondisi !== '') {
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
          status = '';
      }
    }

    // Update display dan hidden input
    $('#status_display').val(status);
    $('#status_hidden').val(status);
  }

  function resetForm() {
    $('#isianPemutuForm')[0].reset();
    $('.js-example-basic-single').val(null).trigger('change');
    clearInstrumenDetails();
    $('#id_instrumen').prop('disabled', true);
  }

  // Function untuk modal update
  function showUpdateModal() {
    $('#updateModal').modal('show');
  }

  function submitUpdate() {
    $('#isianPemutuForm').submit();
  }
</script>