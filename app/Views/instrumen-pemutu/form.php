<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">Form Input Instrumen Pemutugit </h3>
          </div>
        </div>
      </div>

      <!--begin::Form-->
      <form action="submit.php" method="POST" class="m-form m-form--fit m-form--label-align-right">
        <div class="m-portlet__body">

          <!-- ID Field (Auto-generated) -->
          <input type="hidden" name="id" value="<?php echo 'auto-generated'; ?>">

          <!-- id_lembaga Field -->
          <div class="form-group m-form__group">
            <label for="id_lembaga">ID Lembaga</label>
            <input type="number" name="id_lembaga" id="id_lembaga" required placeholder="Enter ID Lembaga" class="form-control m-input">
          </div>

          <!-- Jenjang Field -->
          <div class="form-group m-form__group">
            <label for="jenjang">Jenjang</label>
            <input type="number" name="jenjang" id="jenjang" required placeholder="Enter Jenjang" class="form-control m-input">
          </div>

          <!-- Indikator Field -->
          <div class="form-group m-form__group">
            <label for="indikator">Indikator</label>
            <input type="text" name="indikator" id="indikator" maxlength="255" required placeholder="Enter Indikator" class="form-control m-input">
          </div>

          <!-- Kondisi Field -->
          <div class="form-group m-form__group">
            <label for="kondisi">Kondisi</label>
            <input type="text" name="kondisi" id="kondisi" placeholder="Enter Kondisi" class="form-control m-input">
          </div>

          <!-- Batas Field -->
          <div class="form-group m-form__group">
            <label for="batas">Batas</label>
            <input type="number" name="batas" id="batas" placeholder="Enter Batas" class="form-control m-input">
          </div>

        </div>

        <!-- Submit and Cancel Buttons -->
        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
          </div>
        </div>

      </form>
      <!--end::Form-->

    </div>
  </div>
</div>
