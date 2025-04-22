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
      <form class="m-form m-form--fit m-form--label-align-right" method="POST" action="input-manajemen-audit">
        <div class="m-portlet__body">
          <div class="form-group m-form__group">
            <label for="kode">
              Kode Audit
            </label>
            <input type="text" class="form-control m-input" id="kode" name="kode" placeholder="AU001">
          </div>
          <div class="form-group m-form__group">
            <label for="id_standar">Standar</label>
            <select class="form-control m-input" id="id_standar" name="id_standar">
            <option value="">-- Pilih Standar --</option>
              <?php foreach ($standars as $standar): ?>
              <option value="<?= $standar['id']; ?>"><?= $standar['nama']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group m-form__group">
            <label for="id_periode">Periode</label>
            <select class="form-control m-input" id="id_standar" name="id_periode">
            <option value="">-- Pilih Periode --</option>
              <?php foreach ($periodes as $periode): ?>
              <option value="<?= $periode['id']; ?>"><?= $periode['tahun']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group m-form__group">
            <label for="tanggalMulai">
              Tanggal Mulai
            </label>
            <input type="Date" class="form-control m-input" id="tanggalMulai" name="tanggal_mulai">
          </div>
          <div class="form-group m-form__group">
            <label for="tanggalSelesai">
              Tanggal Selesai
            </label>
            <input type="Date" class="form-control m-input" id="tanggalSelesai" name="tanggal_selesai">
          </div>
        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <button type="submit" class="btn btn-primary">
              Submit
            </button>
            <button type="reset" class="btn btn-secondary">
              Reset
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