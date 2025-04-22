<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>

<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">Formulir Periode</h3>
          </div>
        </div>
      </div>
      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" method="POST" action="periode">
        <div class="m-portlet__body">

          <!-- Tahun -->
          <div class="form-group m-form__group row">
            <label for="input-tahun" class="col-2 col-form-label">Tahun</label>
            <div class="col-10">
              <input class="form-control m-input" type="number" id="input-tahun" name="tahun" placeholder="Masukkan Tahun" required>
            </div>
          </div>

          <!-- Tahun Ajaran -->
          <div class="form-group m-form__group row">
            <label for="input-ts" class="col-2 col-form-label">Tahun Ajaran</label>
            <div class="col-10">
              <input class="form-control m-input" type="text" id="input-ts" name="ts" placeholder="Masukkan Tahun Ajaran" required>
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="reset" class="btn btn-secondary">Batal</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>