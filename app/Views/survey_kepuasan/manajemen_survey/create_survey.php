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
          <div class="row ui-sortable" id="m_sortable_portlets">
            <div class="col-lg-12 portlet-template">
              <div
                class="m-portlet m-portlet--tabs m-portlet--success m-portlet--head-solid-bg m-portlet--sortable m-portlet--bordered"
                style="">
                <div class="m-portlet__head ui-sortable-handle">
                  <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                      <h3 class="m-portlet__head-text">
                        Jenis Pertanyaan
                      </h3>
                    </div>
                  </div>
                  <div class="m-portlet__head-tools">
                    <ul class="nav nav-tabs m-tabs m-tabs-line  m-tabs-line--right" role="tablist">
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
                    <input type="text" class="form-control m-input" id="exampleInputTitle1" aria-describedby="emailHelp"
                      placeholder="Isi Pertanyaan" fdprocessedid="8wf9oh">
                  </div>
                  <!-- <div class="md-editor" id="1745128214339"></div>
                  <textarea name="markdown" class="form-control md-input" data-provide="markdown" rows="5"
                    style="resize: none;" aria-describedby="markdown-error" aria-invalid="true"></textarea> -->
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
          <div class="m-form__group form-group row">
            <label class="col-lg-2 col-form-label"></label>
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

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const sortable = new Sortable(document.getElementById('m_sortable_portlets'), {
      animation: 150, // Animasi saat elemen dipindahkan
      handle: '.m-portlet__head', // Hanya bagian header yang bisa digunakan untuk drag
      ghostClass: 'sortable-ghost', // Tambahkan kelas saat elemen sedang di-drag
    });
  });

  document.addEventListener('DOMContentLoaded', function () {
    const addButton = document.querySelector('[data-repeater-create]');
    const container = document.getElementById('m_sortable_portlets');
    const template = document.querySelector('.portlet-template');

    // Fungsi untuk menambahkan portlet baru
    addButton.addEventListener('click', function () {
      // Clone the template
      const newPortlet = template.cloneNode(true);

      // Clear any input fields in the cloned portlet
      const inputs = newPortlet.querySelectorAll('textarea, input');
      inputs.forEach(input => input.value = '');

      // Tambahkan animasi fade-in menggunakan JavaScript
      newPortlet.style.opacity = 0;
      newPortlet.style.transform = 'scale(0.95)';
      container.appendChild(newPortlet);

      // Gunakan setTimeout untuk memberikan efek animasi
      setTimeout(() => {
        newPortlet.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        newPortlet.style.opacity = 1;
        newPortlet.style.transform = 'scale(1)';
      }, 10);

      // Tambahkan event listener untuk tombol delete di portlet baru
      const deleteButton = newPortlet.querySelector('[data-repeater-delete]');
      deleteButton.addEventListener('click', function () {
        // Tambahkan animasi fade-out menggunakan JavaScript
        newPortlet.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        newPortlet.style.opacity = 0;
        newPortlet.style.transform = 'scale(0.95)';
        setTimeout(() => {
          newPortlet.remove(); // Hapus portlet setelah animasi selesai
        }, 300); // Durasi animasi
      });
    });

    // Tambahkan event listener untuk tombol delete di portlet awal
    const initialDeleteButtons = document.querySelectorAll('[data-repeater-delete]');
    initialDeleteButtons.forEach(button => {
      button.addEventListener('click', function () {
        const portlet = button.closest('.portlet-template');
        if (portlet) {
          // Tambahkan animasi fade-out menggunakan JavaScript
          portlet.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
          portlet.style.opacity = 0;
          portlet.style.transform = 'scale(0.95)';
          setTimeout(() => {
            portlet.remove(); // Hapus portlet setelah animasi selesai
          }, 300); // Durasi animasi
        }
      });
    });
  });
</script>