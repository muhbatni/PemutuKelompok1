<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">
              Formulir Unit
            </h3>
          </div>
        </div>
      </div>
      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" method="POST" action="unit.php">
        <div class="m-portlet__body">

          <!-- Nama Unit -->
          <div class="form-group m-form__group row">
          <label for="input-nama" class="col-2 col-form-label">Nama Unit</label>
          <div class="col-10">
            <input class="form-control m-input" type="text" id="input-nama" name="nama" placeholder="Masukkan Nama Unit">
          </div>
        </div>

          <!-- Parent Unit -->
          <div class="form-group m-form__group row">
          <label for="input-parent" class="col-2 col-form-label">Parent</label>
          <div class="col-10">
            <select class="form-control m-input" id="input-parent" name="parent">
              <option value="">-- Pilih Kode Fakultas --</option>
              <option value="1">01 - Fakultas Sains dan Teknologi</option>
              <option value="2">02 - Fakultas Adab dan Humaniora</option>
              <option value="3">03 - Fakultas Syariah dan Hukum</option>
              <option value="4">04 - Fakultas Tarbiyah dan Keguruan</option>
              <option value="5">05 - Fakultas Ilmu Sosial dan Ilmu Politik</option>
            </select>
          </div>
        </div>

        <!-- Tombol Submit -->
        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="reset" class="btn btn-secondary">Batal</button>
          </div>
        </div>
      </form>
      </form>
    </div>
  </div>
</div>