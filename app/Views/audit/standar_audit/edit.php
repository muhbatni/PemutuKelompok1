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
              FORM INPUT PERNYATAAN STANDAR
            </h3>
          </div>
        </div>
      </div>
      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" method="post"
        action="<?= base_url('public/audit/standar') ?>" enctype="multipart/form-data">
        <input type="hidden" name="id_standar" value="<?= $id_standar ?>">
        <div class="m-portlet__body">

          <!-- Field Judul Standar -->
          <div class="form-group m-form__group">
            <label for="PernyataanStandar">PERNYATAAN</label>
            <input type="text" class="form-control m-input" id="PernyataanStandar" name="pernyataan" required
              placeholder="Pernyataan Standar"
              value="<?= isset($pernyataan['pernyataan']) ? $pernyataan['pernyataan'] : "" ?>">
          </div>

          <div class="form-group m-form__group">
            <label for="IndikatorStandar">INDIKATOR</label>
            <input type="textarea" class="form-control m-input" id="IndikatorStandar" name="indikator" required
              placeholder="Indikator Standar"
              value="<?= isset($pernyataan['indikator']) ? $pernyataan['indikator'] : "" ?>">
          </div>

          <!-- Kondisi Field -->
          <div class="form-group m-form__group">
            <label for="kondisi">Kondisi</label>
            <select name="kondisi" id="kondisi" class="form-control m-input" required>
              <option value="">-- Pilih Kondisi --</option>
              <option value="<" <?= (isset($pernyataan['kondisi']) && $pernyataan["kondisi"] === "<") ? "selected" : "" ?>>
                Kurang dari (&lt;)</option>
              <option value="=" <?= (isset($pernyataan['kondisi']) && $pernyataan["kondisi"] === "=") ? 'selected' : '' ?>>Sama dengan (=)</option>
              <option value=">" <?= (isset($pernyataan['kondisi']) && $pernyataan["kondisi"] === ">") ? 'selected' : '' ?>>Lebih dari (&gt;)</option>
            </select>
          </div>

          <!-- Batas Field -->
          <div class="form-group m-form__group">
            <label for="batas">Batas</label>
            <input type="number" name="batas" id="batas" placeholder="Enter Batas" class="form-control m-input"
              value="<?= isset($pernyataan['batas']) ? $pernyataan["batas"] : "" ?>" required min="1" step="1">
          </div>

        </div>

        <!-- Tombol aksi -->
        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <a href="<?= base_url('public/audit/standar') ?>" class="btn btn-light">Kembali</a>
            <button type="submit" class="btn btn-primary">
              Submit
            </button>
            <button type="reset" class="btn btn-metal">Reset</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</div>

<!-- Table View setelah Form -->
<div class="row mt-5">
  <div class="col-md-12">
    <div class="m-portlet">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">
              DAFTAR PERNYATAAN STANDAR
            </h3>
          </div>
        </div>
      </div>
      <div class="m-portlet__body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Pernyataan</th>
                <th>Indikator</th>
                <th>Kondisi</th>
                <th>Batas</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($data_standar)): ?>
                <?php $no = 1;
                foreach ($data_standar as $row): ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row['pernyataan']) ?></td>
                    <td><?= esc($row['indikator']) ?></td>
                    <td><?= esc($row['kondisi']) ?></td>
                    <td><?= esc($row['batas']) ?></td>
                    <td class="text-center">
                      <a href="<?= base_url("public/audit/standar/edit/$id_standar/$row[id]") ?>"
                        class="btn btn-sm btn-warning" title="Edit">
                        <i class="la la-edit"></i>
                      </a>
                      <a href="<?= base_url('public/audit/standar/delete/' . $row['id']) ?>" class="btn btn-sm btn-danger"
                        onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                        <i class="la la-trash"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center">Belum ada data.</td>
                </tr>
              <?php endif; ?>
            </tbody>

          </table>
        </div>
      </div>
    </div>
  </div>
</div>