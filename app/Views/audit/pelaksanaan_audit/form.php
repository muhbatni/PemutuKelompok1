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
      <form class="m-form m-form--fit m-form--label-align-right" method="POST" action="">
        <div class="m-portlet__body">
          <div class="form-group m-form__group">
            <label for="example-number-input">
              ID Audit
            </label>
            <div>
              <input class="form-control m-input" type="number" value="1" id="example-number-input">
            </div>
          </div>
          <div class="form-group m-form__group">
            <label for="exampleSelect1">
              Periode
            </label>
            <select class="form-control m-input" id="exampleSelect1">
              <option>
                1
              </option>
              <option>
                2
              </option>
              <option>
                3
              </option>
              <option>
                4
              </option>
              <option>
                5
              </option>
            </select>
          </div>
          <div class="form-group m-form__group">
            <label for="kodeAudit">
              Kode Audit
            </label>
            <input type="text" class="form-control m-input" id="kodeAudit" placeholder="AU001">
          </div>
          <div class="form-group m-form__group">
            <label for="tanggalMulai">
              Tanggal Mulai
            </label>
            <input type="Date" class="form-control m-input" id="tanggalMulai">
          </div>
          <div class="form-group m-form__group">
            <label for="tanggalSelesai">
              Tanggal Selesai
            </label>
            <input type="Date" class="form-control m-input" id="tanggalSelesai">
          </div>
        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <button type="reset" class="btn btn-primary">
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