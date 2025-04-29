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
              FORM PERNYATAAN
            </h3>
          </div>
        </div>
      </div>
      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" method="post" 
            action="<?= isset($standar) ? base_url('public/audit/input-standar/update/' . $standar['id']) : base_url('public/audit/input-standar') ?>"
            enctype="multipart/form-data">
      <!-- <form class="m-form m-form--fit m-form--label-align-right" method="post" action= "input-standar"> -->
        <div class="m-portlet__body">

        <!-- Field Judul Standar -->
        <div class="form-group m-form__group">
            <label for="PernyataanStandar">Pernyataan Standar </label>
            <input type="text" class="form-control m-input" id="JudulStandar" name="pernyataan" 
                   required placeholder="Judul Standar" 
                   value="<?= isset($standar) ? esc($standar['nama']) : ''; ?>">
          </div>
         
          <div class="form-group m-form__group">
            <label for="IndikatorStandar">Indikator </label>
            <input type="text area" class="form-control m-input" id="IndikatorStandar" name="indikator" 
                   required placeholder="IndikatorStandar" 
                   value="<?= isset($standar) ? esc($standar['nama']) : ''; ?>">
          </div>
          
          <!-- Field Deskripsi Standar -->
          <!-- <div class="form-group m-form__group">
            <label for="DeskripsiStandar">Deskripsi Standar</label>
            <textarea class="form-control m-input" id="DeskripsiStandar" name="deskripsi" rows="3" 
                      placeholder="Deskripsi Standar"><?= isset($standar) ? esc($standar['dokumen']) : ''; ?></textarea>
          </div> -->

        </div>

    
        </div>

        <!-- Tombol aksi -->
        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
          <a href="<?= base_url('public/audit/standar') ?>" class="btn btn-light">Kembali</a>
            <button type="submit" class="btn btn-primary">
            <?= isset($standar) ? 'Update' : 'Simpan' ?>
            </button>
            <button type="reset" class="btn btn-metal">Reset</button>
          </div>
        </div>
      </form>
    </div>
    </div>
  </div>
</div>