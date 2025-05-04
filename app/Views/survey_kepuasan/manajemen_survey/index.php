<div class="m-content">
  <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
      <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
          <h3 class="m-portlet__head-text">
            Daftar Survey
          </h3>
        </div>
      </div>
    </div>
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
            <a href="<?= base_url("public/survey/create") ?>"
              class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air">
              <span>
                <i class="la la-plus"></i>
                <span>
                  Buat Survey
                </span>
              </span>
            </a>
            <div class="m-separator m-separator--dashed d-xl-none"></div>
          </div>
        </div>
      </div>
      <!--end: Search Form -->
      <!--begin: Datatable -->
      <table class="m-datatable table-bordered" id="survey_table" width="100%">
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
            <th title="Field #6">
              Dokumen Pendukung
            </th>
            <th title="Field #7">
              Status
            </th>
            <th title="Field #8">
              Aksi
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($surveys as $survey): ?>
            <tr>
              <td>
                <?php echo esc($survey['id']); ?>
              </td>
              <td>
                <?php echo esc($survey['kode']); ?>
              </td>
              <td>
                <?php echo esc($survey['nama']); ?>
              </td>
              <td>
                <?php echo esc($survey['dokumen_pendukung']) ?: "null"; ?>
              </td>
              <td>
                <div class="w-5 text-center">
                  <?php if ($survey['status'] === "t"): ?>
                    <span class="m-badge m-badge--success w-24 m-badge--wide">Aktif</span>
                  <?php else: ?>
                    <span class="m-badge m-badge--danger w-24 m-badge--wide">Tidak Aktif</span>
                  <?php endif; ?>
                </div>
              </td>
              <td>
                <div class="d-flex justify-content-around">
                  <span class="dropdown">
                    <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                      data-toggle="dropdown" aria-expanded="false">
                      <i class="la la-ellipsis-h"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                      <!-- <a class="dropdown-item"
                        href="<?= base_url("public/survey/edit?id_survey=$survey[id]") ?>"><i
                          class="la la-edit"></i> Edit Detail</a> -->
                      <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Lihat Hasil</a>
                      <a class="dropdown-item" href="#"><i class="la la-print"></i> Buat Laporan</a>
                      <a class="dropdown-item" href="<?= base_url("public/survey/delete?id_survey=$survey[id]") ?>"
                        data-toggle="modal" data-target="#deleteModal-<?= $survey['id']; ?>" fdprocessedid="yus45">
                        <i class="la la-trash"></i>Hapus Survey</a>
                    </div>
                  </span>
                  <div class="modal fade" id="deleteModal-<?= $survey['id']; ?>" tabindex="-1" role="dialog"
                    aria-labelledby="deleteModalLabel-<?= $survey['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteModalLabel-<?= $survey['id']; ?>">Hapus Survey</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>Apakah kamu yakin ingin menghapus Survey ini?</p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                          <a href="<?= base_url("public/survey/delete?id_survey=$survey[id]") ?>"
                            class="btn btn-danger">Hapus</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <span>
                    <a href="<?= base_url("public/survey/edit?id_survey=$survey[id]") ?>"
                      class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                      title="View">
                      <i class="la la-edit"></i>
                    </a>
                  </span>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <!--end: Datatable -->
      <?php
      $currentPage = $pager->getCurrentPage();
      $startPage = max(1, $currentPage - 3);
      $endPage = min($pager->getPageCount(), $currentPage + 3);

      $previousURI = $pager->getPreviousPageURI();
      $nextURI = $pager->getNextPageURI();
      ?>
      <div class="row">
        <div class="col-md-12">
          <div class="btn-group d-flex justify-content-center" role="group" aria-label="Default button group">
            <a <?= $previousURI ? "href='$previousURI'" : '' ?> class="btn btn-outline-primary" <?= $previousURI ?: "disabled='disabled'" ?>>Previous</a>
            <?php
            for ($index = $startPage; $index <= $endPage; $index++) { ?>
              <a <?= $pager->getPageURI($index) ? 'href="' . $pager->getPageURI($index) . '"' : '' ?>
                class="btn btn-outline-primary <?= $index === $currentPage ? 'active' : '' ?>"
                <?= $pager->getPageURI($index) ?: "disabled='disabled'" ?>><?= $index ?></a>
            <?php } ?>
            <a <?= $nextURI ? "href='$nextURI'" : '' ?> class="btn btn-outline-primary" <?= $nextURI ?: "disabled='disabled'" ?>>Next</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="<?= base_url(); ?>/public/assets/demo/default/custom/components/datatables/base/html-table.js"
  type="text/javascript"></script>