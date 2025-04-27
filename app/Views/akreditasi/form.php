<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">
              Formulir Akreditasi
            </h3>
          </div>
        </div>
      </div>
      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" method="POST" action="akreditasi" enctype="multipart/form-data">
        <div class="m-portlet__body">

        <!-- ID input, hidden field -->
        <input type="hidden" name="id" value="<?= isset($editData) ? $editData['id'] : ''; ?>">
          
          <!-- ID Unit -->
          <div class="form-group m-form__group">
            <label for="id_unit">Unit</label>
            <select class="form-control m-input" id="id_unit" name="id_unit">
              <option value="">-- Pilih Unit --</option>
              <?php foreach ($units as $unit): ?>
                <option value="<?= $unit['id']; ?>" 
                  <?= isset($dataAkreditasi['id_unit']) && $dataAkreditasi['id_unit'] == $unit['id'] ? 'selected' : ''; ?>>
                  <?= $unit['nama']; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- ID Lembaga Akreditasi -->
        <div class="form-group m-form__group">
          <label for="id_lembaga">Lembaga Akreditasi</label>
          <select class="form-control m-input" id="id_lembaga" name="id_lembaga">
            <option value="">-- Pilih Lembaga --</option>
            <?php foreach ($lembagas as $lembaga): ?>
              <option value="<?= $lembaga['id']; ?>" 
                <?= isset($dataAkreditasi['id_lembaga']) && $dataAkreditasi['id_lembaga'] == $lembaga['id'] ? 'selected' : ''; ?>>
                <?= $lembaga['nama']; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

          <!-- Nilai Akreditasi -->
          <div class="form-group m-form__group">
            <label for="nilai_akreditasi">Nilai Akreditasi</label>
            <select class="form-control m-input" id="nilai_akreditasi" name="nilai_akreditasi">
              <option value="">-- Pilih Nilai --</option>
              <?php
                $nilaiOptions = [
                  1 => 'Unggul', 2 => 'Baik Sekali', 3 => 'Baik', 4 => 'A', 
                  5 => 'B', 6 => 'C', 7 => 'Minimum', 8 => 'Tidak Ada'
                ];
              ?>
              <?php foreach ($nilaiOptions as $key => $value): ?>
                <option value="<?= $key; ?>" 
                  <?= isset($dataAkreditasi['nilai']) && $dataAkreditasi['nilai'] == $key ? 'selected' : ''; ?>>
                  <?= $value; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Is Active -->
        <div class="form-group m-form__group">
            <label>Is Active</label><br>
            <label class="radio-inline">
                <input type="radio" name="is_active" value="0" 
                <?= isset($dataAkreditasi['is_active']) && $dataAkreditasi['is_active'] == false ? 'checked' : ''; ?>>
                Tidak Aktif
            </label>
            <label class="radio-inline">
                <input type="radio" name="is_active" value="1" 
                <?= isset($dataAkreditasi['is_active']) && $dataAkreditasi['is_active'] == true ? 'checked' : ''; ?>>
                Aktif
            </label>
        </div>


          <!-- Status -->
          <div class="form-group m-form__group">
            <label>Status</label><br>
            <label class="radio-inline">
              <input type="radio" name="status" value="0" <?= isset($dataAkreditasi['status']) && $dataAkreditasi['status'] == 0 ? 'checked' : ''; ?>> Pengajuan
            </label>
            <label class="radio-inline">
              <input type="radio" name="status" value="1" <?= isset($dataAkreditasi['status']) && $dataAkreditasi['status'] == 1 ? 'checked' : ''; ?>> Diterima
            </label>
            <label class="radio-inline">
              <input type="radio" name="status" value="2" <?= isset($dataAkreditasi['status']) && $dataAkreditasi['status'] == 2 ? 'checked' : ''; ?>> Ditolak
            </label>
          </div>

          <!-- Tanggal Berlaku -->
          <div class="form-group m-form__group">
            <label for="tanggal_berlaku">Tanggal Berlaku</label>
            <input type="date" class="form-control m-input" id="tanggal_berlaku" name="tanggal_berlaku" value="<?= isset($dataAkreditasi['tanggal_berlaku']) ? $dataAkreditasi['tanggal_berlaku'] : ''; ?>">
          </div>

          <!-- Tanggal Habis -->
          <div class="form-group m-form__group">
            <label for="tanggal_habis">Tanggal Habis</label>
            <input type="date" class="form-control m-input" id="tanggal_habis" name="tanggal_habis" value="<?= isset($dataAkreditasi['tanggal_habis']) ? $dataAkreditasi['tanggal_habis'] : ''; ?>">
          </div>

          <!-- File Upload -->
          <div class="form-group m-form__group">
            <label for="file_upload">Unggah Dokumen</label>
            <input type="file" class="form-control m-input" id="file_upload" name="file_upload">
            <?php if (isset($dataAkreditasi['file']) && $dataAkreditasi['file']): ?>
              <p>Dokumen Terupload: <a href="<?= 'uploads/'.$dataAkreditasi['file']; ?>" target="_blank">Lihat File</a></p>
            <?php endif; ?>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="m-portlet_foot m-portlet_foot--fit">
          <div class="m-form__actions">
            <button type="submit" value="add" class="btn btn-primary"><?= isset($editData) ? 'Perbarui' : 'Tambah' ?></button>
            <button type="button" class="btn btn-secondary" onclick="handleCancel()">Batal</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Tabel Data Akreditasi -->
<?php if (!isset($editData)): ?>
      <div class="m-portlet m-portlet--tabs">
        <div class="m-portlet__head">
          <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
              <h3 class="m-portlet__head-text">
                Data Akreditasi
              </h3>
            </div>
          </div>
        </div>
        <div class="m-portlet__body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Nama Unit</th>
                <th>Nama Lembaga</th>
                <th>Status</th>
                <th>Tanggal Berlaku</th>
                <th>Tanggal Habis</th>
                <th>Nilai</th>
                <th>Is Active</th>
                <th>File</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($dataAkreditasi as $akreditasi): ?>
                <tr>
                  <td><?php
                  foreach ($units as $unit) {
                      if (isset($unit['id']) && isset($akreditasi['id_unit']) && $unit['id'] == $akreditasi['id_unit']) {
                          echo $unit['nama'];
                          break;  // keluar dari loop setelah menemukan yang cocok
                      } else {
                          echo "Unit Tidak Ditemukan";
                          break;
                      }
                  }
                  ?></td>
                  <td><?php
                  foreach ($lembagas as $lembaga) {
                      if (isset($lembaga['id']) && isset($akreditasi['id_lembaga']) && $lembaga['id'] == $akreditasi['id_lembaga']) {
                          echo $lembaga['nama'];
                          break;  // keluar dari loop setelah menemukan yang cocok
                      } else {
                          echo "Lembaga Tidak Ditemukan";
                          break;
                      }
                  }
                  ?></td>
                  <td><?php
                    $status = '';
                    if (isset($akreditasi['status'])) {
                        switch ($akreditasi['status']) {
                            case 0: $status = 'Pengajuan'; break;
                            case 1: $status = 'Ditereima'; break;
                            case 2: $status = 'Ditolak'; break;
                        }
                    } else {
                        $status = 'Tidak Ditemukan';
                    }
                    echo $status;
                  ?></td>
                  <td>
                    <?= isset($akreditasi['tanggal_berlaku']) ? $akreditasi['tanggal_berlaku'] : 'Tanggal Tidak Ditemukan'; ?>
                  </td>
                  <td>
                    <?= isset($akreditasi['tanggal_habis']) ? $akreditasi['tanggal_habis'] : 'Tanggal Tidak Ditemukan'; ?>
                  </td>
                  <td>
                    <?php
                      $nilai = '';
                      if (isset($akreditasi['nilai'])) {
                          switch ($akreditasi['nilai']) {
                              case 1: $nilai = 'Unggul'; break;
                              case 2: $nilai = 'Baik Sekali'; break;
                              case 3: $nilai = 'Baik'; break;
                              case 4: $nilai = 'A'; break;
                              case 5: $nilai = 'B'; break;
                              case 6: $nilai = 'C'; break;
                              case 7: $nilai = 'Minimum'; break;
                              case 8: $nilai = 'Tidak Ada'; break;
                              default: $nilai = 'Nilai Tidak Dikenal'; break;
                          }
                      } else {
                          $nilai = 'Nilai Tidak Ditemukan';
                      }
                      echo $nilai;
                    ?>
                  </td>
                  <td>
                  <?php
                    $aktif = '';
                    if (isset($akreditasi['is_active'])) {
                        // Mengecek langsung nilai boolean
                        $aktif = $akreditasi['is_active'] ? 'Aktif' : 'Tidak Aktif';
                    } else {
                        $aktif = 'Tidak Ada';
                    }
                    echo $aktif;
                  ?>
                  </td>
                  <td>
                  <?php 
                  if (isset($akreditasi['file']) && $akreditasi['file']): ?>
                        <a href="<?= $akreditasi['file']; ?>" target="_blank">Download</a>
                <?php else: ?>
                        No File
                <?php endif; ?>
                </td>
                  <td>
                    <!-- Tombol Edit -->
                    <?php if (isset($akreditasi['id'])): ?>
                      <a href="<?= 'akreditasi?id=' . $akreditasi['id']; ?>" value="edit" class="btn btn-sm btn-warning">
                        Edit
                      </a>
                    <?php endif; ?>

                    <!-- Tombol Hapus -->
                  <button class="btn btn-sm btn-danger" 
                          onclick="showDeleteModal('<?= $akreditasi['id'] ?>', '<?= esc($akreditasi['id_unit']) ?>')">
                    Hapus
                  </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>

    
<script>
    function handleCancel() {
        <?php if (isset($editData)): ?>
            // If editing, redirect to the list or home page
            window.location.href = 'akreditasi'; // You can change this to redirect to a different page
        <?php else: ?>
            // If adding a new record, reset the form
            document.querySelector("form").reset();
        <?php endif; ?>
    }

    function showDeleteModal(id, nama) {
    // Mengatur ID data yang akan dihapus
    document.getElementById('deleteId').value = id;
    
    // Menampilkan pesan konfirmasi penghapusan dengan nama data
    document.getElementById('deleteMessage').innerHTML = 
      `Apakah Anda yakin ingin menghapus data <strong>${nama}</strong>?`;

    // Menampilkan modal
    $('#deleteModal').modal('show');
  }
</script>