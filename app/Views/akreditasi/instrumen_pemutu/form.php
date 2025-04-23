<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">Formulir Instrumen Pemutu </h3>
          </div>
        </div>
      </div>

      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" action="instrumen-pemutu" method="post"
        enctype="multipart/form-data">
        <div class="m-portlet__body">

          <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?= esc($edit['id']) ?>">
          <?php endif ?>

          <!-- id_lembaga Field -->
          <div class="form-group m-form__group">
            <label for="id_lembaga">Lembaga Akreditasi</label>
            <select class="form-control m-input" id="id_lembaga" name="id_lembaga">
              <option value="">-- Pilih Lembaga --</option>
              <?php foreach ($lembagas as $lembaga): ?>
                <option value="<?= $lembaga['id']; ?>" <?= (old('id_lembaga') ?? ($isEdit ? $edit['id_lembaga'] : '')) == $lembaga['id'] ? 'selected' : '' ?>>
                  <?= $lembaga['nama']; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Jenjang Field -->
          <div class="form-group m-form__group">
            <label for="jenjang">Jenjang</label>
            <select name="jenjang" id="jenjang" class="form-control m-input" required>
              <option value="">-- Pilih Jenjang --</option>
              <?php
              $jenjangOptions = [
                1 => 'S3',
                2 => 'S2',
                3 => 'S1',
                4 => 'D4',
                5 => 'D3',
                6 => 'D2',
                7 => 'D1',
              ];
              foreach ($jenjangOptions as $key => $val):
                ?>
                <option value="<?= $key ?>" <?= (old('jenjang') ?? ($isEdit ? $edit['jenjang'] : '')) == $key ? 'selected' : '' ?>><?= $val ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Indikator Field -->
          <div class="form-group m-form__group">
            <label for="indikator">Indikator</label>
            <input type="text" name="indikator" id="indikator" maxlength="255" required placeholder="Enter Indikator"
              value="<?= old('indikator') ?? ($isEdit ? $edit['indikator'] : '') ?>" class="form-control m-input">
          </div>

          <!-- Kondisi Field -->
          <div class="form-group m-form__group">
            <label for="kondisi">Kondisi</label>
            <select name="kondisi" id="kondisi" class="form-control m-input" required>
              <option value="">-- Pilih Kondisi --</option>
              <option value="<" <?= (old('kondisi') ?? ($isEdit ? $edit['kondisi'] : '')) == '<' ? 'selected' : '' ?>>
                Kurang dari (&lt;)</option>
              <option value="=" <?= (old('kondisi') ?? ($isEdit ? $edit['kondisi'] : '')) == '=' ? 'selected' : '' ?>>Sama
                dengan (=)</option>
              <option value=">" <?= (old('kondisi') ?? ($isEdit ? $edit['kondisi'] : '')) == '>' ? 'selected' : '' ?>>Lebih
                dari (&gt;)</option>
            </select>
          </div>

          <!-- Batas Field -->
          <div class="form-group m-form__group">
            <label for="batas">Batas</label>
            <input type="number" name="batas" id="batas" placeholder="Enter Batas" class="form-control m-input" required
              value="<?= old('batas') ?? ($isEdit ? $edit['batas'] : '') ?>">
          </div>

        </div>

        <!-- Submit and Cancel Buttons -->
        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <button type="submit" class="btn btn-primary">
              <?= $isEdit ? 'Perbarui' : 'Simpan' ?> <!-- Teks tombol disesuaikan -->
            </button>
            <button type="reset" class="btn btn-secondary" 
    onclick="window.location.href='<?= $isEdit ? base_url('public/akreditasi/instrumen-pemutu') : '#' ?>'">
    Batal
  </button>
          </div>

      </form>
      <!--end::Form-->


    </div>
  </div>
</div>

<!-- TABEL DATA -->
<div class="container-fluid mt-5">
  <div class="row">
    <div class="col-12">
      <div class="m-portlet">
        <div class="m-portlet__head">
          <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
              <h3 class="m-portlet__head-text">Daftar Instrumen Pemutu</h3>
            </div>
          </div>
        </div>

        <div class="m-portlet__body p-0">
          <form method="post" action="instrumen-pemutu" class="mb-0">
            <?= csrf_field() ?>
            <div class="table-responsive">
              <table class="table table-bordered table-striped mb-0 w-100">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Lembaga</th>
                    <th>Jenjang</th>
                    <th>Indikator</th>
                    <th>Kondisi</th>
                    <th>Batas</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($instrumen_pemutu)): ?>
                    <?php $no = 1;
                    foreach ($instrumen_pemutu as $row): ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($row['nama_lembaga']) ?></td>
                        <td><?= esc($row['jenjang_text']) ?></td>
                        <td><?= esc($row['indikator']) ?></td>
                        <td><?= esc($row['kondisi']) ?></td>
                        <td><?= esc($row['batas']) ?></td>
                        <td class="d-flex gap-2">
                          <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning mr-1">Edit</a>
                          <button type="submit" name="id_delete" value="<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('Yakin ingin menghapus data ini?')">
                            Hapus
                          </button>
                        </td>
                      </tr>
                    <?php endforeach ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="7" class="text-center">Belum ada data instrumen.</td>
                    </tr>
                  <?php endif ?>
                </tbody>
              </table>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>
