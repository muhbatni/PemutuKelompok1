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
              Formulir Kriteria Akreditasi
            </h3>
          </div>
        </div>
      </div>
      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" action="kriteria" method="post" enctype="multipart/form-data">
        <div class="m-portlet__body">
          <div class="form-group m-form__group m--margin-top-10">
          </div>
          </div>
          <div class="form-group m-form__group">
            <label for="id_lembaga">Lembaga Akreditasi</label>
            <select class="form-control m-input" id="id_lembaga" name="id_lembaga">
            <option value="">-- Pilih Lembaga --</option>
              <?php foreach ($lembagas as $lembaga): ?>
              <option value="<?= $lembaga['id']; ?>"><?= $lembaga['nama']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group m-form__group">
            <label for="InputKode">
              Kode
            </label>
            <input type="kode" class="form-control m-input" name="kode" id="kode" aria-describedby="emailHelp"
              placeholder="Masukkan kode">
            <span class="m-form__help">
            </span>
          </div>
          <div class="form-group m-form__group">
            <label for="InputNama">
              Nama
            </label>
            <input type="nama" class="form-control m-input" name="nama" id="nama" aria-describedby="emailHelp"
              placeholder="Masukkan Nama">
            <span class="m-form__help">
            </span>
          </div>

        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <button type="submit" class="btn btn-primary">
              Submit
            </button>
            <button type="reset" class="btn btn-secondary">
              Batal
            </button>
          </div>
        </div>
      </form>
    </div>
    <!--end::Portlet-->
  </div>

  <?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success">
    <?= session()->getFlashdata('success') ?>
  </div>
<?php endif; ?>
