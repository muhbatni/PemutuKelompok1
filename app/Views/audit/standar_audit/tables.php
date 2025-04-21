<div class="m-content">

  <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
      <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
          <h3 class="m-portlet__head-text">
            Data Standar Audit
          </h3>
        </div>
      </div>
    </div>

    <div class="m-portlet__body">
      <!--begin: Search Form -->
      <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
        <div class="row align-items-center">
          <div class="col-xl-4 order-1 order-xl-1 m--align-left">
            <a href="/pemutu/public/audit/input-standar" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
              <span>
                <i class="flaticon-add"></i>
                <span>
                  Tambah Standar
                </span>
              </span>
            </a>
            <div class="m-separator m-separator--dashed d-xl-none"></div>
          </div>
          <div class="col-xl-8 order-2 order-xl-2">
            <div class="form-group m-form__group row align-items-center">
              <div class="col-md-4 ml-auto">
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
      <table class="m-datatable" id="html_table" width="100%">
        <thead>
          <tr>
            <th title="Field #1">
           Judul
            </th>
            <th title="Field #2">
              Parent
            </th>
            <th title="Field #3">
            Deskripsi
            </th>
            <th title="Field #4">
              Aksi
            </th>
            <!-- <th title="Field #5">
              Car Model
            </th>
            <th title="Field #6">
              Color
            </th>
            <th title="Field #7">
              Deposit Paid
            </th>
            <th title="Field #8">
              Order Date
            </th> -->
          </tr>
        </thead>
        <tbody>
          <!-- <tr>
            <td>
              16590-107
            </td>
            <td>
              Zandra Fisbburne
            </td>
            <td>
              (916) 6137523
            </td>
            <td>
              Pontiac
            </td>
            <td>
              Grand Am
            </td>
            <td>
              Puce
            </td>
            <td>
              $75343.80
            </td>
            <td>
              2016-09-08
            </td>
          </tr>
          <tr>
            <td>
              58232-0517
            </td>
            <td>
              Mela Ord
            </td>
            <td>
              (331) 6613809
            </td>
            <td>
              Lamborghini
            </td>
            <td>
              Gallardo
            </td>
            <td>
              Aquamarine
            </td>
            <td>
              $46031.10
            </td>
            <td>
              2016-08-21
            </td>
          </tr>
          <tr>
            <td>
              67296-0590
            </td>
            <td>
              Benyamin Boerderman
            </td>
            <td>
              (248) 3715044
            </td>
            <td>
              Lexus
            </td>
            <td>
              LX
            </td>
            <td>
              Green
            </td>
            <td>
              $86721.38
            </td>
            <td>
              2017-11-17
            </td>
          </tr> -->
        </tbody>
      </table>
      <!--end: Datatable -->
    </div>
  </div>
</div>

<script src="<?= base_url(); ?>/public/assets/demo/default/custom/components/datatables/base/html-table.js"
  type="text/javascript"></script>