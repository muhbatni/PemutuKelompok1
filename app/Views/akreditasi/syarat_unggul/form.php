<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">
              Formulir Syarat Unggul
            </h3>
          </div>
        </div>
      </div>

      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" method="POST" action="syarat-unggul" enctype="multipart/form-data">
        <div class="m-portlet__body">

          <!-- ID Lembaga -->
          <div class="form-group m-form__group">
            <label for="id_lembaga">Lembaga Akreditasi</label>
            <select class="form-control m-input" id="id_lembaga" name="id_lembaga" required>
              <option value="">-- Pilih Lembaga --</option>
              <?php foreach ($lembagas as $lembaga): ?>
              <option value="<?= $lembaga['id']; ?>"><?= $lembaga['nama']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Nama Syarat -->
          <div class="form-group m-form__group">
            <label for="nama">Nama Syarat Unggul</label>
            <input type="text" class="form-control m-input" id="nama" name="nama" maxlength="100" required>
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
      <!--end::Form-->

    </div>
  </div>
</div>
