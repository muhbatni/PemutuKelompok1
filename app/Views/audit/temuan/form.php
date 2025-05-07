<?php if (session()->getFlashdata('Success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('Success'); ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>

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
              Input Temuan Audit
            </h3>
          </div>
        </div>
      </div>
      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" method="POST"
      action="<?= isset($temuan['id']) ? base_url('public/audit/input-temuan/update/' . $temuan['id']) : base_url('public/audit/input-temuan') ?>">

        <div class="m-portlet__body">
          <div class="form-group m-form__group">
            <label for="unit_select">Pilih Unit:</label>
            <select class="form-control" id="unit_select" name="id_unit" required>
              <option value="">-- Pilih Unit --</option>
              <?php foreach ($unit_list as $unit): ?>
                <option value="<?= $unit->id_unit ?>" <?= isset($temuan) && $temuan['id_unit'] == $unit->id_unit ? 'selected' : '' ?>>
                  <?= $unit->nama_unit ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>



          <div class="form-group m-form__group">
            <label>Kondisi</label>
            <input type="text" class="form-control m-input" id="kondisi" name="kondisi" placeholder="" required
              value="<?= isset($temuan) ? $temuan['kondisi'] : '' ?>">
          </div>

          <div class="form-group m-form__group">
            <label>Rencana Perbaikan</label>
            <input type="text" class="form-control m-input" id="rencana_perbaikan" name="rencana_perbaikan"
              placeholder="" required value="<?= isset($temuan) ? $temuan['rencana_perbaikan'] : '' ?>">
          </div>

          <div class="form-group m-form__group">
            <label>Tanggal Perbaikan</label>
            <input type="date" class="form-control m-input" id="tanggal_perbaikan" name="tanggal_perbaikan"
              placeholder="" required value="<?= isset($temuan) ? $temuan['tanggal_perbaikan'] : '' ?>">
          </div>

          <div class="form-group m-form__group">
            <label>Catatan</label>
            <textarea class="form-control m-input" id="catatan" name="catatan" rows="3"
              required><?= isset($temuan) ? $temuan['catatan'] : '' ?></textarea>
          </div>


          <div class="form-group m-form__group">
            <label>Status</label>
            <select class="form-control" name="status" required>
              <option value="">-- Pilih Status --</option>
              <option value="0" <?= isset($temuan) && $temuan['status'] == '0' ? 'selected' : '' ?>>Belum Ditindaklanjuti
              </option>
              <option value="1" <?= isset($temuan) && $temuan['status'] == '1' ? 'selected' : '' ?>>Sedang Ditindaklanjuti
              </option>
              <option value="2" <?= isset($temuan) && $temuan['status'] == '2' ? 'selected' : '' ?>>Selesai</option>
            </select>
          </div>

          <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions">
            <button type="submit" class="btn btn-primary">
              <?= isset($temuan) ? 'Update' : 'Submit' ?>
            </button>
              <button type="button" class="btn btn-secondary"
              onclick="window.location.href='<?= base_url('public/audit/temuan'); ?>'">
              Back
            </button>
            </div>
          </div>
      </form>
    </div>
    </form>
  </div>
</div>
</div>