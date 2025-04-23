<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">
              Formulir Syarat Unggul
            </h3>
          </div>
        </div>
      </div>

      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" method="POST" action="syarat-unggul" enctype="multipart/form-data">
        <div class="m-portlet__body">

          <!-- Hidden ID Field for Editing -->
        <?php if (isset($editData)): ?>
          <input type="hidden" name="id" value="<?= $editData['id']; ?>">
        <?php endif; ?>

        <!-- ID Lembaga -->
        <div class="form-group m-form__group">
          <label for="id_lembaga">Lembaga Akreditasi</label>
          <select class="form-control m-input" id="id_lembaga" name="id_lembaga" required>
            <option value="">-- Pilih Lembaga --</option>
            <?php foreach ($lembagas as $lembaga): ?>
              <option value="<?= $lembaga['id']; ?>"
                <?= isset($editData) && $editData['id_lembaga'] == $lembaga['id'] ? 'selected' : ''; ?>>
                <?= $lembaga['nama']; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Nama Syarat -->
        <div class="form-group m-form__group">
          <label for="nama">Nama Syarat Unggul</label>
          <input type="text" class="form-control m-input" id="nama" name="nama" placeholder="masukkan nama" maxlength="100" 
            value="<?= isset($editData) ? $editData['nama'] : ''; ?>" required>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
          <button type="submit" class="btn btn-primary"><?= isset($editData) ? 'Perbarui' : 'Simpan' ?></button>
          <button type="button" class="btn btn-secondary" onclick="handleCancel()">Batal</button>
        </div>
      </div>
      </form>
      <!--end::Form-->

      <?php if (!isset($editData)): ?>
      <div class="m-portlet__body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Nama Lembaga</th>
              <th>Nama Syarat Unggul</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($syaratUnggul as $syarat): ?>
              <tr>
              <td><?php
                  foreach ($lembagas as $lembaga) {
                      if (isset($lembaga['id']) && isset($syarat['id_lembaga']) && $lembaga['id'] == $syarat['id_lembaga']) {
                          echo $lembaga['nama'];
                          break;  // keluar dari loop setelah menemukan yang cocok
                      } else {
                          echo "Lembaga Tidak Ditemukan";
                          break;
                      }
                  }
                  ?></td>
                <td><?= $syarat['nama']; ?></td>
                <td>
                  <!-- Tombol Edit -->
                  <a href="<?= 'syarat-unggul?id=' . $syarat['id']; ?>" class="btn btn-sm btn-warning">
                    <i class="fa fa-pencil-alt"></i> Edit
                  </a>
                  <!-- Tombol Delete -->
                  <a href="<?= 'syarat-unggul?id=' . $syarat['id'] . '&action=delete'; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                    <i class="fa fa-trash-alt"></i> Hapus
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
    function handleCancel() {
        <?php if (isset($editData)): ?>
            // If editing, redirect to the list or home page
            window.location.href = 'syarat-unggul'; // You can change this to redirect to a different page
        <?php else: ?>
            // If adding a new record, reset the form
            document.querySelector("form").reset();
        <?php endif; ?>
    }
</script>
