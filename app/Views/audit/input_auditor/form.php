<!-- filepath: d:\xampp\htdocs\pemutu\app\Views\audit\input_auditor\form.php -->
<div class="row">
  <div class="col-md-12">

    <!-- Flash Message -->
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success">
        <?= session()->getFlashdata('success'); ?>
      </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
      <div class="alert alert-danger">
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
          <p><?= $error ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <!-- End Flash Message -->

    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <span class="m-portlet__head-icon m--hide">
              <i class="la la-gear"></i>
            </span>
            <h3 class="m-portlet__head-text">
              FORM INPUT AUDITOR
            </h3>
          </div>
        </div>
      </div>
      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" method="POST" 
      action="<?= isset($auditor) ? base_url("public/audit/auditor/input-auditor/edit/" . $auditor['id']) : base_url('public/audit/auditor/input-auditor') ?>" 
      enctype="multipart/form-data">
        <div class="m-portlet__body">
          <!-- Field Username -->
          <div class="form-group m-form__group">
            <label for="inputUsername">Username</label>
            <select class="form-control m-input" id="inputUsername" name="id" <?= isset($auditor) ? "disabled" : "" ?>>
                <option value="">-- Pilih Username --</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id'] ?>" <?= isset($auditor) && $auditor['id'] == $user['id'] ? 'selected' : '' ?>>
                        <?= $user['username'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

          <!-- Field Upload Dokumen -->
          <div class="form-group m-form__group">
            <label for="inputDokumen">Upload Dokumen</label>
            <input type="file" class="form-control m-input" id="inputDokumen" name="dokumen">
            <?php if (isset($auditor) && !empty($auditor['dokumen'])): ?>
                <small class="form-text text-muted">Dokumen saat ini: <?= esc($auditor['dokumen']) ?></small>
            <?php endif; ?>
          </div>

        </div>

        <!-- Tombol Aksi -->
        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
              <a href="<?= base_url('public/audit/auditor') ?>" class="btn btn-light">Kembali</a>
              <input type="submit" class="btn btn-primary" value="<?= isset($auditor) ? 'Update' : 'Simpan' ?>">
              </input>
              <button type="reset" class="btn btn-metal">Reset</button>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>