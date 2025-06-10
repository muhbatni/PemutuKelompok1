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
              Pelaksanaan Survey Kepuasan
            </h3>
          </div>
        </div>
      </div>
      <!--begin::Form-->
      <div class="m-portlet__body">
        <!--begin: Search Form -->
        <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
          <div class="row align-items-center">
            <div class="col-xl-8 order-2 order-xl-1">
              <div class="form-group m-form__group row align-items-center">
                <div class="col-md-4">
                  <div class="m-input-icon m-input-icon--left">
                    <input type="text" class="form-control m-input m-input--solid" placeholder="Search..."
                      id="generalSearch">
                    <span class="m-input-icon__icon m-input-icon__icon--left">
                      <span>
                        <i class="la la-search"></i>
                      </span>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 order-1 order-xl-2 m--align-right">
              <a class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air" href="#" data-toggle="modal"
                data-target="#pelaksanaanModal" fdprocessedid="yus45" title="Pelaksanaan Survey">
                <span>
                  <i class="la la-calendar-plus-o"></i>
                  <span>Tambah Pelaksanaan</span>
                </span>
              </a>
              <div class="m-separator m-separator--dashed d-xl-none"></div>
              <form method="POST" action="<?= base_url("public/survey/create-pelaksanaan") ?>" class="modal fade"
                id="pelaksanaanModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="">Pelaksanaan Survey</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p>Pilih periode untuk menambah pelaksanaan survey!</p>
                      <div class="form-group m-form__group row">
                        <label for="id_survey" class="col-form-label col-lg-3 col-sm-12">Pilih Survey</label>
                        <div class="col-lg-9 col-md-9 col-sm-12">
                          <select class="form-control" id="id_survey" name="id_survey" required>
                            <?php foreach ($surveys as $survey): ?>
                              <option value="<?= $survey['id']; ?>">
                                <?= $survey['nama']; ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                          <div id="nama_survey" class="mt-2 text-primary"></div>
                        </div>
                        <label for="id_periode" class="col-form-label col-lg-3 col-sm-12">Pilih Periode</label>
                        <br>
                        <div class="col-lg-9 col-md-9 col-sm-12">
                          <select class="form-control" id="id_periode" name="id_periode" required>
                            <?php foreach ($periode as $p): ?>
                              <option value="<?= $p['id']; ?>" <?= isset($pelaksanaan_survey['id_periode']) && ($pelaksanaan_survey['id_periode'] == $p['id']) ? 'selected' : '' ?>>
                                <?= $p['tahun']; ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <label for="tanggal_mulai" class="col-form-label col-lg-3 col-sm-12">Tanggal Mulai</label>
                        <div class="col-lg-9 col-md-9 col-sm-12">
                          <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                        </div>
                        <label for="tanggal_selesai" class="col-form-label col-lg-3 col-sm-12">Tanggal Selesai</label>
                        <div class="col-lg-9 col-md-9 col-sm-12">
                          <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                        </div>
                        <label for="deskripsi_survey" class="col-form-label col-lg-3 col-sm-12">Deskripsi</label>
                        <div class="col-lg-9 col-md-9 col-sm-12">
                          <textarea class="form-control" id="deskripsi_survey" name="deskripsi_survey"
                            required></textarea>
                        </div>
                      </div>
                    </div>
                    <script>
                      document.getElementById("id_periode").addEventListener("change", function () {
                        const selectedOption = this.options[this.selectedIndex];
                        const tahun = selectedOption.textContent.trim();
                        document.getElementById("tanggal_mulai").setAttribute("min", tahun + "-01-01");
                        document.getElementById("tanggal_mulai").setAttribute("max", tahun + "-12-31");
                        document.getElementById("tanggal_selesai").setAttribute("min", tahun + "-01-01");
                        document.getElementById("tanggal_selesai").setAttribute("max", tahun + "-12-31");
                      });
                      document.getElementById("id_periode").dispatchEvent(new Event("change"));
                    </script>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                      <input type="submit" class="btn btn-primary" value="Tambah">
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!--end: Search Form -->
        <!--begin: Datatable -->
        <table class="m-datatable table-bordered" id="html_table" width="100%">
          <thead>
            <tr>
              <th title="Field #1">
                ID Survey
              </th>
              <th title="Field #2">
                Kode
              </th>
              <th title="Field #3">
                Nama
              </th>
              <th title="Field #4">
                Periode
              </th>
              <th title="Field #5">
                Tanggal mulai
              </th>
              <th title="Field #6">
                Tanggal selesai
              </th>
              <th title="Field #7">
                Status
              </th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($pelaksanaan as $pel): ?>
              <tr>
                <td>
                  <?php echo esc($pel['id']); ?>
                </td>
                <td>
                  <?php echo esc($pel['kode']); ?>
                </td>
                <td>
                  <?php echo esc($pel['nama']); ?>
                </td>
                <td>
                  <?php echo esc($pel['tahun']); ?>
                </td>
                <td>
                  <?php echo esc($pel['tanggal_mulai']); ?>
                </td>
                <td>
                  <?php echo esc($pel['tanggal_selesai']); ?>
                </td>
                <td>
                  <div class="w-5 text-center">
                    <?php if ($pel['status']): ?>
                      <span class="m-badge m-badge--success w-24 m-badge--wide">Aktif</span>
                    <?php else: ?>
                      <span class="m-badge m-badge--danger w-24 m-badge--wide">Tidak Aktif</span>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <script src="<?= base_url(); ?>/public/assets/demo/default/custom/components/datatables/base/html-table.js"
      type="text/javascript"></script>
    <!--end::Portlet-->
  </div>
</div>