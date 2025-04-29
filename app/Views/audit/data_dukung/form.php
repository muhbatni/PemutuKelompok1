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
              <?= isset($dataDukung) ? 'Edit' : 'Input' ?> Data Dukung
            </h3>
          </div>
        </div>
      </div>
      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" 
      action="<?= isset($dataDukung) ? base_url('public/audit/input-data-dukung/update/'.$dataDukung['id']) : base_url('public/audit/input-data-dukung') ?>" 
      method="post" 
      enctype="multipart/form-data">
        <div class="m-portlet__body">

        <div class="form-group m-form__group">
            <label for="id_pelaksanaan">ID Pelaksanaan</label>
            <select class="form-control m-input" name="id_pelaksanaan" id="id_pelaksanaan" required>
                <option value="">Pilih ID Pelaksanaan</option>
                <?php foreach ($pelaksanaans as $pelaksanaan): ?>
                    <option value="<?= $pelaksanaan['id'] ?>" 
                            <?= (isset($dataDukung) && $dataDukung['id_pelaksanaan'] == $pelaksanaan['id']) ? 'selected' : '' ?>>
                        <?= $pelaksanaan['id'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Info Pelaksanaan akan muncul di bawah dropdown -->
        <div id="pelaksanaan-info" style="display: none;">
            <div class="form-group m-form__group">
                <label>Unit</label>
                <input type="text" class="form-control m-input" id="unit-name" readonly>
            </div>
            <div class="form-group m-form__group">
                <label>Auditor</label>
                <input type="text" class="form-control m-input" id="auditor-name" readonly>
            </div>
        </div>

        <div class="form-group m-form__group">
            <label for="id_pernyataan">Pernyataan</label>
            <select class="form-control m-input" name="id_pernyataan" id="id_pernyataan">
                <option value="">Pilih Pernyataan</option>
                <?php foreach ($pernyataans as $pernyataan): ?>
                    <option value="<?= $pernyataan['id'] ?>"
                            <?= (isset($dataDukung) && $dataDukung['id_pernyataan'] == $pernyataan['id']) ? 'selected' : '' ?>>
                        <?= $pernyataan['pernyataan'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Deskripsi -->
        <div class="form-group m-form__group">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control m-input" 
                      name="deskripsi" 
                      id="deskripsi" 
                      rows="3" 
                      placeholder="Deskripsi Data Dukung" 
                      required><?= isset($dataDukung) ? $dataDukung['deskripsi'] : '' ?></textarea>
        </div>

          <!-- Upload File Dokumen -->
          <div class="form-group m-form__group">
            <label for="dokumen">Upload Data Dukung</label>
            <input type="file" 
                   class="form-control m-input" 
                   name="dokumen" 
                   id="dokumen" 
                   accept=".pdf,.doc,.docx,.jpg,.png"
                   <?= !isset($dataDukung) ? 'required' : '' ?>>
            <span class="m-form__help">File yang diperbolehkan: PDF, DOC, DOCX, JPG, PNG</span>
            <?php if(isset($dataDukung) && $dataDukung['dokumen']): ?>
                <div class="mt-2">
                    <p>File saat ini: <?= $dataDukung['dokumen'] ?></p>
                </div>
            <?php endif; ?>
          </div>
        </div>
        
        <!-- Tombol Aksi -->
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions">
                <a href="<?= base_url('public/audit/data-dukung') ?>" class="btn btn-light">Kembali</a>
                <button type="submit" class="btn btn-primary">
                    <?= isset($dataDukung) ? 'Update' : 'Simpan' ?>
                </button>
                <button type="reset" class="btn btn-metal">Reset</button>
            </div>
        </div>

        <script>
          document.getElementById('id_pelaksanaan').addEventListener('change', function() {
            const pelaksanaanId = this.value;
            if (pelaksanaanId) {
              fetch('<?= site_url('audit/get-pelaksanaan-info') ?>/' + pelaksanaanId)
                .then(response => {
                  if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                  }
                  return response.json();
                })
                .then(data => {
                  if (data) {
                    document.getElementById('unit-name').value = data.unit_name || '';
                    document.getElementById('auditor-name').value = data.auditor_name || '';
                    document.getElementById('pelaksanaan-info').style.display = 'block';
                  }
                })
                .catch(error => {
                  console.error('Error:', error);
                  alert('Gagal mengambil data: ' + error.message);
                  document.getElementById('pelaksanaan-info').style.display = 'none';
                });
            } else {
              document.getElementById('pelaksanaan-info').style.display = 'none';
            }
          });

          // Trigger change event if editing
          <?php if(isset($dataDukung)): ?>
          document.addEventListener('DOMContentLoaded', function() {
              document.getElementById('id_pelaksanaan').dispatchEvent(new Event('change'));
          });
          <?php endif; ?>
        </script>

      </form>
    </div>
    <!--end::Portlet-->
  </div>
</div>