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
              Input Data Dukung
            </h3>
          </div>
        </div>
      </div>
      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" action="data-dukung" method="post" enctype="multipart/form-data">
        <div class="m-portlet__body">

        <div class="form-group m-form__group">
            <label for="pelaksanaan">
              Pelaksanaan
            </label>
            <input type="text" class="form-control m-input" id="pelaksanaan" name="pelaksanaan" placeholder="Pilih Pelaksanaan Audit">
          </div>

          <div class="form-group m-form__group">
            <label for="pernyataan">
              Pernyataan
            </label>
            <input type="text" class="form-control m-input" id="pernyataan" name="pernyataan" placeholder="Pilih Pernyataan">
          </div>

        <!-- Deskripsi -->
          <div class="form-group m-form__group">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control m-input" name="deskripsi" id="deskripsi" rows="3" placeholder="Deskripsi Data Dukung"></textarea>
          </div>

          <!-- Upload File Dokumen -->
          <div class="form-group m-form__group">
            <label for="dokumen">Upload Data Dukung</label>
            <input type="file" class="form-control m-input" name="dokumen" id="dokumen" accept=".pdf,.doc,.docx,.jpg,.png">
            <span class="m-form__help">File yang diperbolehkan: PDF, DOC, DOCX, JPG, PNG</span>
          </div>
        </div>
        
        <!-- Tombol Aksi -->
        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <a href="data-dukung" class="btn btn-light">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="reset" class="btn btn-metal">Reset</button>
          </div>
        </div>

      </form>
    </div>
    <!--end::Portlet-->
  </div>
</div>