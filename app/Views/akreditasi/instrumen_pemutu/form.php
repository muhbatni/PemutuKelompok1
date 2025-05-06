<?php $isEdit = isset($edit); ?>

<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">Formulir Instrumen Pemutu</h3>
          </div>
        </div>
      </div>

      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" action="<?= site_url('akreditasi/instrumen-pemutu') ?>" method="post" id="instrumenForm">

        <?php if ($isEdit): ?>
          <input type="hidden" name="id" value="<?= esc($edit['id']) ?>">
        <?php endif ?>

        <!-- Lembaga Akreditasi -->
        <div class="form-group m-form__group">
          <label for="id_lembaga">Lembaga Akreditasi</label>
          <select class="form-control m-input" id="id_lembaga" name="id_lembaga" required>
            <option value="">-- Pilih Lembaga --</option>
            <?php foreach ($lembagas as $lembaga): ?>
              <option value="<?= $lembaga['id'] ?>" <?= (old('id_lembaga') ?? ($isEdit ? $edit['id_lembaga'] : '')) == $lembaga['id'] ? 'selected' : '' ?>>
                <?= esc($lembaga['nama']) ?>
              </option>
            <?php endforeach ?>
          </select>
        </div>

        <!-- Jenjang -->
        <div class="form-group m-form__group">
          <label for="jenjang">Jenjang</label>
          <select name="jenjang" id="jenjang" class="form-control m-input" required>
            <option value="">-- Pilih Jenjang --</option>
            <?php
            $jenjangOptions = [1 => 'S3', 2 => 'S2', 3 => 'S1', 4 => 'D4', 5 => 'D3', 6 => 'D2', 7 => 'D1'];
            foreach ($jenjangOptions as $key => $val): ?>
              <option value="<?= $key ?>" <?= (old('jenjang') ?? ($isEdit ? $edit['jenjang'] : '')) == $key ? 'selected' : '' ?>>
                <?= $val ?>
              </option>
            <?php endforeach ?>
          </select>
        </div>

        <!-- Indikator -->
        <div class="form-group m-form__group">
          <label for="indikator">Indikator</label>
          <input type="text" name="indikator" id="indikator" maxlength="255" required placeholder="Masukkan indikator"
            value="<?= old('indikator') ?? ($isEdit ? $edit['indikator'] : '') ?>" class="form-control m-input">
        </div>

        <!-- Kondisi -->
        <div class="form-group m-form__group">
          <label for="kondisi">Kondisi</label>
          <select name="kondisi" id="kondisi" class="form-control m-input" required>
            <option value="">-- Pilih Kondisi --</option>
            <?php
            $kondisiOps = ['<' => 'Kurang dari (<)', '=' => 'Sama dengan (=)', '>' => 'Lebih dari (>)'];
            foreach ($kondisiOps as $val => $label): ?>
              <option value="<?= $val ?>" <?= (old('kondisi') ?? ($isEdit ? $edit['kondisi'] : '')) == $val ? 'selected' : '' ?>>
                <?= $label ?>
              </option>
            <?php endforeach ?>
          </select>
        </div>

        <!-- Batas -->
        <div class="form-group m-form__group">
          <label for="batas">Batas</label>
          <input type="number" name="batas" id="batas" class="form-control m-input" placeholder="Masukkan batas"
            required value="<?= old('batas') ?? ($isEdit ? $edit['batas'] : '') ?>">
        </div>

        <!-- Form Actions -->
        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <a href="<?= site_url('akreditasi/instrumen-pemutu') ?>" class="btn btn-danger me-2">
              <i class="fa fa-arrow-left"></i> Batal
            </a>
            <button type="reset" class="btn btn-warning me-2">
              <i class="fa fa-paint-brush"></i> Reset
            </button>
            <button type="submit" class="btn btn-primary">
              <i class="fa fa-save"></i> <?= $isEdit ? 'Perbarui' : 'Simpan' ?>
            </button>
          </div>
        </div>
      </form>
      <!--end::Form-->
    </div>
  </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success mt-3">
    <?= session()->getFlashdata('success') ?>
  </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger mt-3">
    <?= session()->getFlashdata('error') ?>
  </div>
<?php endif; ?>
