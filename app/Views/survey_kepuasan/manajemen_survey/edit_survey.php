<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">
              Edit Survey
            </h3>
          </div>
        </div>
      </div>
      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" method="POST"
        action="<?= base_url("public/survey/edit?id_survey=" . ($idSurvey ?? $survey['id'])) ?>"
        enctype="multipart/form-data">
        <div class="m-portlet__body">
          <div class="form-group m-form__group row">
            <label class="col-form-label col-lg-3 col-sm-12">Kode<span style="color: red">*</span></label>
            <div class="col-lg-7 col-md-7 col-sm-12">
              <input type="text" name="kode_survey" class="form-control m-input" id="exampleInputKode1"
                aria-describedby="kodeHelp" placeholder="Isi kode survey"
                value="<?= isset($old['kode_survey']) ? $old['kode_survey'] : $survey['kode'] ?>">
              <?php if (isset($errors['kode_survey'])): ?>
                <span class="m-form__help text-danger"><?= esc($errors['kode_survey']) ?></span>
              <?php endif; ?>
            </div>
          </div>
          <div class="form-group m-form__group row">
            <label class="col-form-label col-lg-3 col-sm-12">Nama<span style="color: red">*</span></label>
            <div class="col-lg-7 col-md-7 col-sm-12">
              <input type="text" name="nama_survey" class="form-control m-input" id="exampleInputNama1"
                aria-describedby="titleHelp" placeholder="Isi nama survey"
                value="<?= isset($old['nama_survey']) ? $old['nama_survey'] : $survey['nama'] ?>">
              <?php if (isset($errors['nama_survey'])): ?>
                <span class="m-form__help text-danger"><?= esc($errors['nama_survey']) ?></span>
              <?php endif; ?>
            </div>
          </div>
          <div class="form-group m-form__group row">
            <label class="col-form-label col-lg-3 col-sm-12">Status<span style="color: red">*</span></label>
            <div class="m-radio-inline ml-3">
              <label class="m-radio m-radio--success">
                <input type="radio" name="status_survey" value="true" <?= isset($survey['status']) && $survey['status'] === "t" ? "checked" : "" ?> <?= isset($old['status_survey']) && $old['status_survey'] === "true" ? "checked" : "" ?>>
                Aktif
                <span></span>
              </label>
              <label class="m-radio m-radio--danger">
                <input type="radio" name="status_survey" value="false" <?= isset($survey['status']) && $survey['status'] === "f" ? "checked" : "" ?> <?= isset($old['status_survey']) && $old['status_survey'] === "false" ? "checked" : "" ?>>
                Tidak aktif
                <span></span>
              </label>
              <?php if (isset($errors['status_survey'])): ?>
                <span class="m-form__help text-danger"><?= esc($errors['status_survey']) ?></span>
              <?php endif; ?>
            </div>
          </div>
          <div class="form-group m-form__group row">
            <label class="col-form-label col-lg-3 col-sm-12">Dokumen Pendukung</label>
            <div class="col-lg-7 col-md-7 col-sm-12">
              <input type="file" name="dokumen_pendukung_survey" class="form-control m-input"
                id="exampleInputSurveyDocument1" aria-describedby="surveyDocumentsHelp">
              <?php if (isset($errors['dokumen_pendukung'])): ?>
                <span class="m-form__help text-danger"><?= esc($errors['dokumen_pendukung']) ?></span>
              <?php endif; ?>
            </div>
          </div>
          <div class="form-group m-form__group row">
            <label for="id_periode" class="col-form-label col-lg-3 col-sm-12">Pilih Periode</label>
            <div class="col-lg-7 col-md-7 col-sm-12">
              <select class="form-control" id="id_periode" name="id_periode" required>
                <?php foreach ($periode as $p): ?>
                  <option value="<?= $p['id']; ?>" <?= isset($pelaksanaan_survey['id_periode']) && ($pelaksanaan_survey['id_periode'] == $p['id']) ? 'selected' : '' ?>>
                    <?= $p['tahun']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group m-form__group row">
            <label for="id_kriteria" class="col-form-label col-lg-3 col-sm-12">Pilih Kriteria</label>
            <div class="col-lg-7 col-md-7 col-sm-12">
              <select class="form-control" id="id_kriteria" name="id_kriteria">
                <?php foreach ($kriteria as $k): ?>
                  <option value="<?= $k['id']; ?>">
                    <?= $k['nama']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group m-form__group row">
            <label class="col-form-label col-lg-3 col-sm-12">Tanggal Mulai<span style="color: red">*</span></label>
            <div class="col-lg-7 col-md-7 col-sm-12">
              <input type="date" class="form-control" name="tanggal_mulai" required
                value="<?= isset($old['tanggal_mulai']) ? $old['tanggal_mulai'] : $pelaksanaan_survey['tanggal_mulai'] ?>">
            </div>
          </div>
          <div class="form-group m-form__group row">
            <label class="col-form-label col-lg-3 col-sm-12">Tanggal Selesai<span style="color: red">*</span></label>
            <div class="col-lg-7 col-md-7 col-sm-12">
              <input type="date" class="form-control" name="tanggal_selesai" required
                value="<?= isset($old['tanggal_selesai']) ? $old['tanggal_selesai'] : $pelaksanaan_survey['tanggal_selesai'] ?>">
              <?php if (isset($errors['tanggal_selesai'])): ?>
                <span class="m-form__help text-danger"><?= esc($errors['tanggal_selesai']) ?></span>
              <?php endif; ?>
            </div>
          </div>
          <div class="form-group m-form__group row">
            <label class="col-form-label col-lg-3 col-sm-12">Deskripsi<span style="color: red">*</span></label>
            <div class="col-lg-7 col-md-7 col-sm-12">
              <textarea class="form-control" id="deskripsi" name="deskripsi_survey" rows="3"
                required><?= isset($old['deskripsi_survey']) ? $old['deskripsi_survey'] : $pelaksanaan_survey['deskripsi'] ?></textarea>
            </div>
          </div>
          <div class="form-group m-form__group row">
            <label class="col-form-label col-lg-3 col-sm-12">List Pertanyaan</label>
            <div class="col-lg-7 col-md-7 col-sm-12">
              <div class="row ui-sortable" id="m_sortable_portlets">
                <?php if (isset($old['pertanyaan'])): ?>
                  <?php foreach ($old['pertanyaan'] as $index => $pertanyaan): ?>
                    <div class="col-lg-12 portlet-template">
                      <?php if (isset($errors["pertanyaan.$index"])): ?>
                        <span
                          class="m-form__help text-danger"><?= str_replace('{index}', $index, esc($errors["pertanyaan.$index"])) ?></span>
                      <?php endif; ?>
                      <?php if (isset($errors["jenis.$index"])): ?>
                        <span
                          class="m-form__help text-danger"><?= str_replace('{index}', $index, esc($errors["jenis.$index"])) ?></span>
                      <?php endif; ?>
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
                            <div class="dropdown d-inline-block">
                              <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="false">
                                <?php switch ($old['jenis'][$index]) {
                                  case 1: ?>
                                    <i class="la la-star"></i> Opsian
                                    <?php
                                    break;
                                  case 2: ?>
                                    <i class="la la-pencil-square"></i> Isian
                                    <?php
                                    break;
                                  default: ?>
                                    Pilih
                                    <?php
                                    break;
                                }
                                ?>
                              </button>
                              <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item <?= $old['jenis'][$index] == 1 ? 'active' : '' ?>"
                                  type="button" data-jenis="1"><i class="la la-star"></i> Opsian</button>
                                <button class="dropdown-item <?= $old['jenis'][$index] == 2 ? 'active' : '' ?>"
                                  type="button" data-jenis="2"><i class="la la-pencil-square"></i> Isian</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="m-portlet__body">
                          <div class="d-flex align-items-center justify-content-center">
                            <input type="hidden" name="id_pertanyaan[]" value="<?= $old['id_pertanyaan'][$index] ?>">
                            <input type="text" name="pertanyaan[]" class="form-control m-input" placeholder="Isi Pertanyaan"
                              value="<?= $pertanyaan ?>">
                            <input type="hidden" name="jenis[]" value="<?= $old['jenis'][$index] ?>">
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
                  <?php endforeach; else: ?>
                  <?php foreach ($pertanyaan as $p): ?>
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
                            <div class="dropdown d-inline-block">
                              <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="false">
                                <?php switch ($p['jenis']) {
                                  case 1: ?>
                                    <i class="la la-star"></i> Opsian
                                    <?php
                                    break;
                                  case 2: ?>
                                    <i class="la la-pencil-square"></i> Isian
                                    <?php
                                    break;
                                  default: ?>
                                    Pilih
                                    <?php
                                    break;
                                }
                                ?>
                              </button>
                              <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item <?= $p['jenis'] == 1 ? 'active' : '' ?>" type="button"
                                  data-jenis="1"><i class="la la-star"></i> Opsian</button>
                                <button class="dropdown-item <?= $p['jenis'] == 2 ? 'active' : '' ?>" type="button"
                                  data-jenis="2"><i class="la la-pencil-square"></i> Isian</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="m-portlet__body">
                          <div class="d-flex align-items-center justify-content-center">
                            <input type="hidden" name="id_pertanyaan[]" value="<?= $p['id'] ?>">
                            <input type="text" name="pertanyaan[]" class="form-control m-input" placeholder="Isi Pertanyaan"
                              value="<?= $p['teks'] ?>">
                            <input type="hidden" name="jenis[]" value="<?= $p['jenis'] ?>">
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
                  <?php endforeach; endif; ?>
              </div>
              <div class="form-group row">
                <div class="col-lg-4">
                  <div data-repeater-create=""
                    class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
                    <span>
                      <i class="la la-plus"></i>
                      <span>Add</span>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions m-form__actions">
            <div class="row">
              <div class="col-lg-9 ml-lg-auto d-flex justify-content-between">
                <a class="btn btn-secondary" href="<?= base_url("public/survey") ?>">Batal</a>
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