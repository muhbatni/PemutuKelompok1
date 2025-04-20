<!-- END: Subheader -->
<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">
              Membuat Survey
            </h3>
          </div>
        </div>
      </div>
      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" method="POST"
        action="<?= base_url("public/survey/manajemen-survey/create") ?>" enctype="multipart/form-data">
        <div class="m-portlet__body">
          <div class="form-group m-form__group row">
            <label class="col-form-label col-lg-3 col-sm-12">Kode<span style="color: red">*</span></label>
            <div class="col-lg-7 col-md-7 col-sm-12">
              <input type="text" name="kode_survey" class="form-control m-input" id="exampleInputKode1"
                aria-describedby="kodeHelp" placeholder="Isi kode survey">
            </div>
          </div>
          <div class="form-group m-form__group row">
            <label class="col-form-label col-lg-3 col-sm-12">Nama<span style="color: red">*</span></label>
            <div class="col-lg-7 col-md-7 col-sm-12">
              <input type="text" name="nama_survey" class="form-control m-input" id="exampleInputTitle1"
                aria-describedby="titleHelp" placeholder="Isi nama survey">
            </div>
          </div>
          <div class="form-group m-form__group row">
            <label class="col-form-label col-lg-3 col-sm-12">Status<span style="color: red">*</span></label>
            <div class="m-radio-inline ml-3">
              <label class="m-radio m-radio--success">
                <input type="radio" name="status_survey" value="true"> Aktif
                <span></span>
              </label>
              <label class="m-radio m-radio--danger">
                <input type="radio" name="status_survey" value="false"> Tidak aktif
                <span></span>
              </label>
            </div>
          </div>
          <div class="form-group m-form__group row">
            <label class="col-form-label col-lg-3 col-sm-12">Dokumen Pendukung</label>
            <div class="col-lg-7 col-md-7 col-sm-12">
              <input type="file" name="dokumen_pendukung_survey" class="form-control m-input"
                id="exampleInputSurveyDocument1" aria-describedby="surveyDocumentsHelp">
            </div>
          </div>
        </div>
        <div class="form-group m-form__group row">
          <label class="col-form-label col-lg-3 col-sm-12">List Pertanyaan</label>
          <div class="col-lg-7 col-md-7 col-sm-12">
            <div class="row ui-sortable" id="m_sortable_portlets">
              <div class="col-lg-12 portlet-template">
                <div class="m-portlet m-portlet--mobile m-portlet--sortable m-portlet--bordered" style="">
                  <div class="m-portlet__head ui-sortable-handle">
                    <div class="m-portlet__head-caption">
                      <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                          Jenis Pertanyaan
                        </h3>
                      </div>
                    </div>
                    <div class="m-portlet__head-tools">
                      <ul
                        class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand  m-tabs-line--right m-tabs-line-danger"
                        role="tablist">
                        <li class="nav-item m-tabs__item">
                          <a class="nav-link m-tabs__link active" data-toggle="tab"
                            href="#m_portlet_base_demo_1_tab_content" role="tab">
                            <i class="la la-star"></i> Opsian
                          </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                          <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_base_demo_1_tab_content"
                            role="tab" aria-selected="false">
                            <i class="la la-pencil-square"></i>
                            Isian
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="m-portlet__body">
                    <div class="d-flex align-items-center justify-content-center">
                      <input type="text" name="pertanyaan[]" class="form-control m-input" id="exampleInputTitle1"
                        aria-describedby="emailHelp" placeholder="Isi Pertanyaan" fdprocessedid="8wf9oh">
                      <input type="hidden" name="jenis[]" value="1">
                    </div>
                    <br>
                    <div data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
                      <span>
                        <i class="la la-trash-o"></i>
                        <span>Delete</span>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-lg-4">
                <div data-repeater-create="" class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
                  <span>
                    <i class="la la-plus"></i>
                    <span>Add</span>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions m-form__actions">
            <div class="row">
              <div class="col-lg-9 ml-lg-auto d-flex justify-content-between">
                <a href="<?= base_url("public/survey/manajemen-survey") ?>" class="btn btn-secondary">Batal</a>
                <input type="submit" class="btn btn-brand" value="Simpan" />
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!--end::Form-->
</div>
<!--end::Portlet-->
</div>
</div>