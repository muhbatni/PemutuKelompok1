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
              Formulir Isian Pemutu
            </h3>
          </div>
        </div>
      </div>
      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right">
          <div class="form-group m-form__group">
              <label for="id_unitpemutu">Pilih Unit Pemutu</label>
              <select class="form-control m-input" id="id_unitpemutu" name="id_unitpemutu">
                  <option value="">-- Pilih Unit Pemutu--</option>
                  <?php foreach ($unitpemutus as $unitpemutu): ?>
                      <option value="<?= $unitpemutu['id'] ?>"><?= $unitpemutu['id'] ?> - <?= $unitpemutu['nama_unit'] ?></option>
                  <?php endforeach; ?>
              </select>
          </div>

          <div class="form-group m-form__group">
            <label for="id_unitpemutu">Pilih Instrumen</label>
            <select class="form-control m-input" id="id_unitpemutu" name="id_unitpemutu">
                <option value="">-- Pilih Unit Pemutu--</option>
                <?php foreach ($isianlembaga as $unitpemutu): ?>
                    <option value="<?= $unitpemutu['id'] ?>"><?= $unitpemutu['id'] ?> - <?= $unitpemutu['nama_lembaga'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

          <div class="form-group m-form__group">
            <label for="isian">Isian</label>
            <input type="number" step="any" class="form-control m-input" id="isian" name="isian" placeholder="Masukkan nilai isian">
          </div>

          <div class="form-group m-form__group">
            <label for="status">Status</label>
            <input type="number" class="form-control m-input" id="status" name="status" placeholder="Masukkan status (angka)">
          </div>
        </div>

        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="reset" class="btn btn-secondary">Batal</button>
          </div>
        </div>
      </form>
      <!--end::Form-->
    </div>
  </div>
</div>
