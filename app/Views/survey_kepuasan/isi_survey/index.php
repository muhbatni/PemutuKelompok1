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
              Survey Yang Belum Diisi
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
                Dokumen Pendukung
              </th>
              <th title="Field #5">
                Status
              </th>
              <th title="Field #6">
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
                    <a href="<?= base_url("public/survey/manajemen-survey/edit/$survey[id]") ?>"
                      class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill d-flex align-items-center justify-content-center"
                      title="Isi Survey">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 36 36">
                        <path fill="currentColor"
                          d="M21 12H7a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1M8 10h12V7.94H8Z"
                          class="clr-i-outline clr-i-outline-path-1" />
                        <path fill="currentColor"
                          d="M21 14.08H7a1 1 0 0 0-1 1V19a1 1 0 0 0 1 1h11.36L22 16.3v-1.22a1 1 0 0 0-1-1M20 18H8v-2h12Z"
                          class="clr-i-outline clr-i-outline-path-2" />
                        <path fill="currentColor"
                          d="M11.06 31.51v-.06l.32-1.39H4V4h20v10.25l2-1.89V3a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v28a1 1 0 0 0 1 1h8a3.4 3.4 0 0 1 .06-.49"
                          class="clr-i-outline clr-i-outline-path-3" />
                        <path fill="currentColor" d="m22 19.17l-.78.79a1 1 0 0 0 .78-.79"
                          class="clr-i-outline clr-i-outline-path-4" />
                        <path fill="currentColor"
                          d="M6 26.94a1 1 0 0 0 1 1h4.84l.3-1.3l.13-.55v-.05H8V24h6.34l2-2H7a1 1 0 0 0-1 1Z"
                          class="clr-i-outline clr-i-outline-path-5" />
                        <path fill="currentColor"
                          d="m33.49 16.67l-3.37-3.37a1.61 1.61 0 0 0-2.28 0L14.13 27.09L13 31.9a1.61 1.61 0 0 0 1.26 1.9a1.6 1.6 0 0 0 .31 0a1.2 1.2 0 0 0 .37 0l4.85-1.07L33.49 19a1.6 1.6 0 0 0 0-2.27ZM18.77 30.91l-3.66.81l.89-3.63L26.28 17.7l2.82 2.82Zm11.46-11.52l-2.82-2.82L29 15l2.84 2.84Z"
                          class="clr-i-outline clr-i-outline-path-6" />
                        <path fill="none" d="M0 0h36v36H0z" />
                      </svg>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <!--end: Datatable -->
        <?php
        // $currentPage = $pager->getCurrentPage();
        // $startPage = max(1, $currentPage - 3);
        // $endPage = min($pager->getPageCount(), $currentPage + 3);

        // $previousURI = $pager->getPreviousPageURI();
        // $nextURI = $pager->getNextPageURI();
        ?>
      </div>
    </div>
    <script src="<?= base_url(); ?>/public/assets/demo/default/custom/components/datatables/base/html-table.js"
      type="text/javascript"></script>
    <!--end::Portlet-->
  </div>
</div>