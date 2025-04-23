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
              FORM INPUT STANDAR 
            </h3>
          </div>
        </div>
      </div>
      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" method="post" action= "input-standar">
        <div class="m-portlet__body">
          <div class="form-group m-form__group">
            <label for="JudulStandar">
             Judul Standar
            </label>
            <input type="text" class="form-control m-input" id="JudulStandar" name="judul" required placeholder="Judul Standar">
          </div>
          
          <div class="form-group m-form__group">
            <label for="parent">
             Parent
            </label>
            <select class="form-control m-input" id="parent" name="parent">
            <option value="">-- Pilih Parent --</option>
            <!-- <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option> -->
          </select>
          </div>
          
          <div class="form-group m-form__group">
            <label for="DeskripsiStandar">
              Deskripsi Standar
            </label>
            <textarea class="form-control m-input" id="DeskripsiStandar" name="deskripsi" rows="3" placeholder="Deskripsi Standar"></textarea>
          </div>

          <div class="form-group m-form__group">
  <label for="is_aktif" class="font-weight-bold">Status Aktif</label>
  <div class="d-flex align-items-center mt-2">
    <label class="radio">
      <input type="radio" name="is_aktif" value="1" checked />
      <span></span>
      Aktif
    </label>
    <label class="radio ml-4">
      <input type="radio" name="is_aktif" value="0" />
      <span></span>
      Tidak Aktif
    </label>
  </div>
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
    </div>
  </div>
</div>