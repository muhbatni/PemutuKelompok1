<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">Formulir Instrumen Pemutu </h3>
          </div>
        </div>
      </div>

      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" action="instrumen-pemutu" method="post"
        enctype="multipart/form-data">
        <div class="m-portlet__body">

          <!-- ID Field (Auto-generated) -->
          <input type="hidden" name="id" value="<?php echo 'auto-generated'; ?>">

          <!-- id_lembaga Field -->
          <div class="form-group m-form__group">
            <label for="id_lembaga">ID Lembaga</label>
            <input type="number" name="id_lembaga" id="id_lembaga" required placeholder="Enter ID Lembaga"
              class="form-control m-input">
          </div>

          <!-- Jenjang Field -->
          <div class="form-group m-form__group">
            <label for="jenjang">Jenjang</label>
            <select name="jenjang" id="jenjang" class="form-control m-input" required>
              <option value="">-- Pilih Jenjang --</option>
              <option value="1" <?= old('jenjang') == 1 ? 'selected' : '' ?>>S3</option>
              <option value="2" <?= old('jenjang') == 2 ? 'selected' : '' ?>>S2</option>
              <option value="3" <?= old('jenjang') == 3 ? 'selected' : '' ?>>S1</option>
              <option value="4" <?= old('jenjang') == 4 ? 'selected' : '' ?>>D4</option>
              <option value="5" <?= old('jenjang') == 5 ? 'selected' : '' ?>>D3</option>
              <option value="6" <?= old('jenjang') == 6 ? 'selected' : '' ?>>D2</option>
              <option value="7" <?= old('jenjang') == 7 ? 'selected' : '' ?>>D1</option>
            </select>
          </div>


          <!-- Indikator Field -->
          <div class="form-group m-form__group">
            <label for="indikator">Indikator</label>
            <input type="text" name="indikator" id="indikator" maxlength="255" required placeholder="Enter Indikator"
              class="form-control m-input">
          </div>

          <!-- Kondisi Field -->
          <div class="form-group m-form__group">
            <label for="kondisi">Kondisi</label>
            <select name="kondisi" id="kondisi" class="form-control m-input" required>
              <option value="">-- Pilih Kondisi --</option>
              <option value="<" <?= old('kondisi') == '<' ? 'selected' : '' ?>>Kurang dari (&lt;)</option>
              <option value="=" <?= old('kondisi') == '=' ? 'selected' : '' ?>>Sama dengan (=)</option>
              <option value=">" <?= old('kondisi') == '>' ? 'selected' : '' ?>>Lebih dari (&gt;)</option>
            </select>
          </div>

          <!-- Batas Field -->
          <div class="form-group m-form__group">
            <label for="batas">Batas</label>
            <input type="number" name="batas" id="batas" placeholder="Enter Batas" class="form-control m-input"
              required>
          </div>

        </div>

        <!-- Submit and Cancel Buttons -->
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