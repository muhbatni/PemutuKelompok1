<!-- BEGIN: Subheader -->
<!-- <div class="m-subheader ">
  <div class="d-flex align-items-center">
    <div class="mr-auto">
      <h3 class="m-subheader__title m-subheader__title--separator">Actions</h3>
      <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
        <li class="m-nav__item m-nav__item--home">
          <a href="#" class="m-nav__link m-nav__link--icon">
            <i class="m-nav__link-icon la la-home"></i>
          </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
          <a href="" class="m-nav__link">
            <span class="m-nav__link-text">Actions</span>
          </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
          <a href="" class="m-nav__link">
            <span class="m-nav__link-text">Create New Post</span>
          </a>
        </li>
      </ul>
    </div>
    <div>
      <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
        m-dropdown-toggle="hover" aria-expanded="true">
        <a href="#"
          class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
          <i class="la la-plus m--hide"></i>
          <i class="la la-ellipsis-h"></i>
        </a>
        <div class="m-dropdown__wrapper">
          <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
          <div class="m-dropdown__inner">
            <div class="m-dropdown__body">
              <div class="m-dropdown__content">
                <ul class="m-nav">
                  <li class="m-nav__section m-nav__section--first m--hide">
                    <span class="m-nav__section-text">Quick Actions</span>
                  </li>
                  <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                      <i class="m-nav__link-icon flaticon-share"></i>
                      <span class="m-nav__link-text">Activity</span>
                    </a>
                  </li>
                  <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                      <i class="m-nav__link-icon flaticon-chat-1"></i>
                      <span class="m-nav__link-text">Messages</span>
                    </a>
                  </li>
                  <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                      <i class="m-nav__link-icon flaticon-info"></i>
                      <span class="m-nav__link-text">FAQ</span>
                    </a>
                  </li>
                  <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                      <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                      <span class="m-nav__link-text">Support</span>
                    </a>
                  </li>
                  <li class="m-nav__separator m-nav__separator--fit">
                  </li>
                  <li class="m-nav__item">
                    <a href="#" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">Submit</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->
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
      <!--end::Form-->
    </div>
    <!--end::Portlet-->
  </div>
</div>