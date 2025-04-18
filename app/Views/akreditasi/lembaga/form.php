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

      <!-- Flashdata -->
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success m-3">
          <?= session()->getFlashdata('success') ?>
        </div>
      <?php endif; ?>

      <!--begin::Form-->
      <form action="lembaga" method="post" class="m-form m-form--fit m-form--label-align-right">
        <input type="hidden" name="id" value="<?= isset($editData) ? $editData['id'] : '' ?>">

        <div class="m-portlet__body">
          <div class="form-group m-form__group">
            <label for="nama">Nama Lembaga</label>
            <input type="text" name="nama" class="form-control m-input" id="nama" placeholder="Masukkan nama lembaga" required value="<?= isset($editData) ? esc($editData['nama']) : '' ?>">
          </div>
          <div class="form-group m-form__group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" class="form-control m-input" id="deskripsi" rows="4" required><?= isset($editData) ? esc($editData['deskripsi']) : '' ?></textarea>
          </div>
        </div>

        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <button type="submit" class="btn btn-primary"><?= isset($editData) ? 'Update' : 'Simpan' ?></button>
            <a href="<?= base_url('akreditasi/lembaga') ?>" class="btn btn-secondary">Reset</a>
          </div>
        </div>
      </form>
      <!--end::Form-->
    </div>
  </div>
</div>

<!-- TABEL DATA -->
<div class="row mt-5">
  <div class="col-md-12">
    <div class="m-portlet">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">Daftar Lembaga Akreditasi</h3>
          </div>
        </div>
      </div>
      <div class="m-portlet__body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Lembaga</th>
              <th>Deskripsi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($lembaga)) : ?>
              <?php $no = 1; foreach ($lembaga as $row) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= esc($row['nama']) ?></td>
                  <td><?= esc($row['deskripsi']) ?></td>
                  <td>
                    <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                  </td>
                </tr>
              <?php endforeach ?>
            <?php else : ?>
              <tr>
                <td colspan="4" class="text-center">Belum ada data.</td>
              </tr>
            <?php endif ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>