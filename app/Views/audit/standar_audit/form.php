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
      <form class="m-form m-form--fit m-form--label-align-right" method="post"
        action="<?= isset($standar) ? base_url('public/audit/input-standar/update/' . $standar['id']) : base_url('public/audit/input-standar') ?>"
        enctype="multipart/form-data">
        <!-- <form class="m-form m-form--fit m-form--label-align-right" method="post" action= "input-standar"> -->
        <div class="m-portlet__body">

          <!-- Field Judul Standar -->
          <div class="form-group m-form__group">
            <label for="JudulStandar">Judul Standar</label>
            <input type="text" class="form-control m-input" id="JudulStandar" name="judul" required
              placeholder="Judul Standar" value="<?= isset($standar) ? esc($standar['nama']) : ''; ?>">
          </div>

          <!-- Parent Audit -->
          <div class="form-group m-form__group">
            <label for="id_periode">Parent</label>
            <select class="form-control m-input" id="id_parent" name="id_parent">
              <option value="">-- Pilih Parent --</option>
              <?php foreach ($standars as $standar): ?>
                <?php if (!isset($edit) || $edit['id'] != $standar['id']): // Hindari pilih dirinya sendiri ?>
                  <option value="<?= $standar['id']; ?>" <?= isset($edit['id_parent']) && $edit['id_parent'] == $standar['id'] ? 'selected' : '' ?>>
                    <?= $standar['nama']; ?>
                  </option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>
          </div>


          <div class="form-group m-form__group">
            <label for="dokumen">Unggah Dokumen</label>
            <input type="file" class="form-control m-input" name="dokumen" id="DokumenStandar" accept=".pdf,.doc,.docx"
              value="<?= isset($standar) ? esc($standar['dokumen']) : ''; ?>">
            <span class="m-form__help">
              File yang diperbolehkan: PDF, DOC, DOCX
              <?= $isEdit && !empty($edit['dokumen']) ? '(Abaikan jika tidak ingin mengganti)' : '' ?>
            </span>
          </div>
        </div>

        <!-- !-- Field Status Aktif -->
        <div class="form-group m-form__group">
          <label for="is_aktif" class="font-weight-bold">Status Aktif</label>
          <div class="d-flex align-items-center mt-2">
            <label class="radio">
              <input type="radio" name="is_aktif" value="1" <?= isset($standar) && $standar['is_aktif'] == true ? 'checked' : '' ?> />
              <span></span>
              Aktif
            </label>
            <label class="radio ml-4">
              <input type="radio" name="is_aktif" value="0" <?= isset($standar) && $standar['is_aktif'] == false ? 'checked' : '' ?> />
              <span></span>
              Tidak Aktif
            </label>
          </div>
        </div>

    </div>

    <!-- Tombol aksi -->
    <div class="m-portlet__foot m-portlet__foot--fit">
      <div class="m-form__actions">
        <a href="<?= base_url('public/audit/standar') ?>" class="btn btn-light">Kembali</a>
        <button type="submit" class="btn btn-primary">
        <?= isset($isEdit) && $isEdit ? 'Update' : 'Simpan' ?>
        </button>
        <button type="reset" class="btn btn-metal">Reset</button>
      </div>
    </div>
    </form>
  </div>
</div>
</div>
</div>