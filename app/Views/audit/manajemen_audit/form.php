<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <span class="m-portlet__head-icon m--hide">
              <i class="la la-gear"></i>
            </span>
            <h3 class="m-portlet__head-text">
              Penjadwalan Audit
            </h3>
          </div>
        </div>
      </div>
      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" method="POST"
        action="<?= isset($audit) ? base_url('public/audit/input-manajemen-audit/update/' . $audit['id']) : base_url('public/audit/input-manajemen-audit') ?>">
        <div class="m-portlet__body">
          <div class="form-group m-form__group">
            <label for="kode">
              Kode Audit
            </label>
            <input type="text" class="form-control m-input" id="kode" name="kode" placeholder="AU001"
              value="<?= isset($audit) ? $audit['kode'] : ''; ?>" required>
          </div>

          <div class="form-group m-form__group">
            <label for="id_standar">Standar</label>
            <select name="id_standar[]" id="id_standar" class="form-control js-example-basic-multiple" multiple>
              <?php foreach ($standars as $standar): ?>
                <option value="<?= $standar['id']; ?>" <?= in_array($standar['id'], $selectedStandars ?? []) ? 'selected' : '' ?>>
                  <?= esc($standar['nama']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group m-form__group">
            <label for="id_periode">Periode</label>
            <select class="form-control m-input" id="id_periode" name="id_periode">
              <option value="">-- Pilih Periode --</option>
              <?php foreach ($periodes as $periode): ?>
                <option value="<?= $periode['id']; ?>" <?= isset($audit) && $audit['id_periode'] == $periode['id'] ? 'selected' : '' ?>>
                  <?= $periode['tahun']; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group m-form__group">
            <label for="tanggalMulai">
              Tanggal Mulai
            </label>
            <input type="Date" class="form-control m-input" id="tanggalMulai" name="tanggal_mulai"
              value="<?= isset($audit) ? esc($audit['tanggal_mulai']) : '' ?>">
          </div>

          <div class="form-group m-form__group">
            <label for="tanggalSelesai">
              Tanggal Selesai
            </label>
            <input type="Date" class="form-control m-input" id="tanggalSelesai" name="tanggal_selesai"
              value="<?= isset($audit) ? esc($audit['tanggal_selesai']) : '' ?>">
          </div>
        </div>
        <!--end::Form Body-->

        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <button type="submit" class="btn btn-primary">
              <?= isset($audit) ? 'Update' : 'Submit' ?>
            </button>
            <button type="button" class="btn btn-secondary"
              onclick="window.location.href='<?= base_url('public/audit/manajemen-audit'); ?>'">
              Back
            </button>
          </div>
        </div>
      </form>
    </div>
    <!--end::Portlet-->
  </div>
  </form>
</div>
</div>
</div>
<script>
  $(document).ready(function() {
    $('#id_standar').select2({
      placeholder: "Pilih standar audit",
      tags: false,
      width: '100%'
    });
  });
</script>
