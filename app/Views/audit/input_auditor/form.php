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
              Data Auditor
            </h3>
          </div>
        </div>
      </div>
      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right">

        <div class="m-portlet__body">
        <div class="form-group m-form__group">
            <label for="inputIdUser">Username</label>
            <select class="form-control m-input" id="inputUsername" name="username">
              <option value="">-- Pilih Username --</option>
              <?php foreach ($users as $user): ?>
                <option value="<?= $user['id'] ?>"><?= $user['username'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group m-form__group">
            <label for="inputDokumen">
              Upload Dokumen
            </label>
            <input type="file" class="form-control m-input" id="inputDokumen" name="dokumen">
          </div>
          <div class="form-group m-form__group">
          <button type="submit" class="btn btn-primary" id="Simpan">Simpan</button>
          <button type="reset" class="btn btn-metal">Cancel</button>
          </div>

      </form>
    </div>
  </div>
  </form>
</div>