<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <span class="m-portlet__head-icon m--hide">
              <i class="la la-file"></i>
            </span>
            <h3 class="m-portlet__head-text">
              Form Input Dokumen Penetapan
            </h3>
          </div>
        </div>
      </div>

      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" action="dokumen-penetapan" method="post" enctype="multipart/form-data">
        <div class="m-portlet__body">

          <!-- Nomor Dokumen -->
          <div class="form-group m-form__group">
            <label for="nomor">Nomor Dokumen</label>
            <input type="text" class="form-control m-input" name="nomor" id="nomor" placeholder="Contoh: 001/PM/2024" required>
          </div>

          <!-- Tanggal Dokumen -->
          <div class="form-group m-form__group">
            <label for="tanggal">Tanggal Dokumen</label>
            <input type="date" class="form-control m-input" name="tanggal" id="tanggal" required>
          </div>

          <!-- Nama Dokumen -->
          <div class="form-group m-form__group">
            <label for="nama">Nama Dokumen</label>
            <input type="text" class="form-control m-input" name="nama" id="nama" placeholder="Contoh: Pedoman Mutu" required>
          </div>

          <!-- Deskripsi -->
          <div class="form-group m-form__group">
            <label for="deskripsi">Deskripsi / Catatan Tambahan</label>
            <textarea class="form-control m-input" name="deskripsi" id="deskripsi" rows="3" placeholder="Tambahkan keterangan jika perlu..."></textarea>
          </div>

          <!-- Upload File Dokumen -->
          <div class="form-group m-form__group">
            <label for="dokumen">Upload File Dokumen</label>
            <input type="file" class="form-control m-input" name="dokumen" id="dokumen" accept=".pdf,.doc,.docx">
            <span class="m-form__help">File yang diperbolehkan: PDF, DOC, DOCX</span>
          </div>
        </div>

        <!-- Tombol Aksi -->
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

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success">
    <?= session()->getFlashdata('success') ?>
  </div>
<?php endif; ?>