<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <span class="m-portlet__head-icon m--hide">
              <i class="la la-university"></i>
            </span>
            <h3 class="m-portlet__head-text">
              Formulir Lembaga Akreditasi
            </h3>
          </div>
        </div>
      </div>
      <!--begin::Form-->
      <form action="<?= base_url('lembaga-akreditasi/store') ?>" method="post" class="m-form m-form--fit m-form--label-align-right">
        <div class="m-portlet__body">
          <!-- Input Nama Lembaga -->
          <div class="form-group m-form__group">
            <label for="nama">Nama Lembaga</label>
            <input type="text" name="nama" class="form-control m-input" id="nama" placeholder="Masukkan nama lembaga" required>
          </div>
          
          <!-- Input Deskripsi Lembaga -->
          <div class="form-group m-form__group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" class="form-control m-input" id="deskripsi" rows="4" placeholder="Masukkan deskripsi lembaga" required></textarea>
          </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= base_url('lembaga-akreditasi') ?>" class="btn btn-secondary">Batal</a>
          </div>
        </div>
      </form>
      <!--end::Form-->
    </div>
  </div>
</div>