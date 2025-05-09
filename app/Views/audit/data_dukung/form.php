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
                            <?= isset($dataDukung) ? 'Edit' : 'Input' ?> Data Dukung
                        </h3>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
            <form class="m-form m-form--fit m-form--label-align-right"
                action="<?= isset($dataDukung) ? base_url('public/audit/input-data-dukung/update/'.$dataDukung['id']) : base_url('public/audit/input-data-dukung') ?>"
                method="post" enctype="multipart/form-data">
                <div class="m-portlet__body">

                    <div class="form-group m-form__group">
                        <label for="id_pelaksanaan">ID Pelaksanaan</label>
                        <?php if(isset($dataDukung)): ?>
                        <!-- Show readonly input when editing -->
                        <input type="hidden" name="id_pelaksanaan" value="<?= $dataDukung['id_pelaksanaan'] ?>">
                        <input type="text" class="form-control m-input" value="<?= $dataDukung['id_pelaksanaan'] ?>"
                            readonly>
                        <?php else: ?>
                        <!-- Show dropdown when creating new -->
                        <select class="form-control m-input" name="id_pelaksanaan" id="id_pelaksanaan" required>
                            <option value="">Pilih ID Pelaksanaan</option>
                            <?php foreach ($pelaksanaans as $pelaksanaan): ?>
                            <option value="<?= $pelaksanaan['id'] ?>">
                                <?= $pelaksanaan['id'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <?php endif; ?>
                    </div>

                    <!-- Info Pelaksanaan akan muncul di bawah dropdown -->
                    <div id="pelaksanaan-info">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group m-form__group">
                                    <label>Unit</label>
                                    <input type="text" class="form-control m-input" id="unit-name" readonly
                                        placeholder="Unit Pelaksanaan">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-form__group">
                                    <label>Auditor</label>
                                    <input type="text" class="form-control m-input" id="auditor-name" readonly
                                        placeholder="Auditor Pelaksanaan">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group m-form__group">
                        <label for="id_pernyataan">Pernyataan</label>
                        <select class="form-control m-input" name="id_pernyataan" id="id_pernyataan">
                            <option value="">Pilih Pernyataan</option>
                            <?php foreach ($pernyataans as $pernyataan): ?>
                            <option value="<?= $pernyataan['id'] ?>"
                                <?= (isset($dataDukung) && $dataDukung['id_pernyataan'] == $pernyataan['id']) ? 'selected' : '' ?>>
                                <?= $pernyataan['pernyataan'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Menampilkan Pernyataan dan Indikator (readonly) -->
                    <div id="pernyataan-info">
                        <div class="form-group m-form__group">
                            <label>Indikator</label>
                            <input type="text" class="form-control m-input" id="indikator" readonly
                                placeholder="Indikator Pernyataan">
                        </div>
                    </div>


                    <!-- Deskripsi -->
                    <div class="form-group m-form__group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control m-input" name="deskripsi" id="deskripsi" rows="3"
                            placeholder="Deskripsi Data Dukung"
                            required><?= isset($dataDukung) ? $dataDukung['deskripsi'] : '' ?></textarea>
                    </div>

                    <!-- Upload File Dokumen -->
                    <div class="form-group m-form__group">
                        <label for="dokumen">Upload Data Dukung</label>
                        <input type="file" class="form-control m-input" name="dokumen[]" id="dokumen"
                            accept=".pdf,.doc,.docx,.jpg,.png" multiple <?= !isset($dataDukung) ? 'required' : '' ?>>
                        <span class="m-form__help">File yang diperbolehkan: PDF, DOC, DOCX, JPG, PNG. Bisa upload lebih
                            dari 1 file.</span>
                        <?php if(isset($dataDukung) && $dataDukung['dokumen']): ?>
                        <div class="mt-2">
                            <p>File saat ini:</p>
                            <?php 
                            $files = explode('|', $dataDukung['dokumen']);
                            foreach($files as $file): ?>
                            <div><?= $file ?></div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions">
                        <a href="javascript:void(0);"
                            onclick="confirmBack('<?= base_url('public/audit/data-dukung') ?>')"
                            class="btn btn-light">Kembali</a>
                        <button type="submit" class="btn btn-primary">
                            <?= isset($dataDukung) ? 'Update' : 'Simpan' ?>
                        </button>
                        <?php if(!isset($dataDukung)): ?>
                        <button type="reset" class="btn btn-metal">Reset</button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="modal fade" id="modalBack" tabindex="-1" role="dialog" aria-labelledby="modalBackLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalBackLabel">Konfirmasi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Apakah anda yakin ingin kembali? Perubahan yang belum disimpan akan hilang.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <a href="" class="btn btn-primary" id="modalBackLink">Ya, Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                // Function to handle pelaksanaan info updates
                function updatePelaksanaanInfo(pelaksanaanId) {
                    if (pelaksanaanId) {
                        fetch('<?= site_url('audit/get-pelaksanaan-info') ?>/' + pelaksanaanId)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok: ' + response.status);
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data) {
                                    document.getElementById('unit-name').value = data.unit_name || '';
                                    document.getElementById('auditor-name').value = data.auditor_name || '';
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Gagal mengambil data: ' + error.message);
                                document.getElementById('unit-name').value = '';
                                document.getElementById('auditor-name').value = '';
                            });
                    } else {
                        document.getElementById('unit-name').value = '';
                        document.getElementById('auditor-name').value = '';
                    }
                }

                // Initialize form based on mode (edit/create)
                document.addEventListener('DOMContentLoaded', function() {
                    const pelaksanaanSelect = document.getElementById('id_pelaksanaan');
                    const pelaksanaanInput = document.querySelector('input[name="id_pelaksanaan"]');

                    // For create mode
                    if (pelaksanaanSelect) {
                        pelaksanaanSelect.addEventListener('change', function() {
                            updatePelaksanaanInfo(this.value);
                        });
                    }

                    // For edit mode
                    <?php if(isset($dataDukung)): ?>
                    updatePelaksanaanInfo('<?= $dataDukung['id_pelaksanaan'] ?>');
                    <?php endif; ?>

                    // Handle form reset
                    const resetButton = document.querySelector('button[type="reset"]');
                    if (resetButton) {
                        resetButton.addEventListener('click', function() {
                            setTimeout(() => {
                                // Just clear the values without hiding the container
                                document.getElementById('unit-name').value = '';
                                document.getElementById('auditor-name').value = '';

                                // Reset pelaksanaan selection if it exists
                                const pelaksanaanSelect = document.getElementById(
                                    'id_pelaksanaan');
                                if (pelaksanaanSelect) {
                                    pelaksanaanSelect.selectedIndex = 0;
                                }

                                // Reset pernyataan selection
                                const pernyataanSelect = document.getElementById(
                                    'id_pernyataan');
                                if (pernyataanSelect) {
                                    pernyataanSelect.selectedIndex = 0;
                                }

                                // Reset deskripsi
                                const deskripsi = document.getElementById('deskripsi');
                                if (deskripsi) {
                                    deskripsi.value = '';
                                }

                                // Reset file input
                                const dokumen = document.getElementById('dokumen');
                                if (dokumen) {
                                    dokumen.value = '';
                                }
                            }, 0);
                        });
                    }
                });

                // Add these event listeners to your existing JavaScript
                document.addEventListener('DOMContentLoaded', function() {
                    // Pelaksanaan change handler
                    const pelaksanaanSelect = document.getElementById('id_pelaksanaan');
                    if (pelaksanaanSelect) {
                        pelaksanaanSelect.addEventListener('change', function() {
                            updatePelaksanaanInfo(this.value);
                        });
                    }

                    // Pernyataan change handler
                    // Replace the existing pernyataan change handler
                    const pernyataanSelect = document.getElementById('id_pernyataan');
                    if (pernyataanSelect) {
                        pernyataanSelect.addEventListener('change', function() {
                            const pernyataanId = this.value;
                            if (pernyataanId) {
                                fetch('<?= site_url('audit/get-pernyataan-info') ?>/' + pernyataanId)
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error('Network response was not ok');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        if (data) {
                                            document.getElementById('indikator').value = data
                                                .indikator || '';
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        document.getElementById('indikator').value = '';
                                    });
                            } else {
                                document.getElementById('indikator').value = '';
                            }
                        });
                    }
                });

                // Handle form validation
                const form = document.querySelector('form');
                form.addEventListener('submit', function(e) {
                    const deskripsi = document.getElementById('deskripsi');
                    if (!deskripsi.value.trim()) {
                        e.preventDefault();
                        alert('Deskripsi harus diisi');
                        deskripsi.focus();
                    }

                    <?php if(!isset($dataDukung)): ?>
                    const dokumen = document.getElementById('dokumen');
                    if (!dokumen.files.length) {
                        e.preventDefault();
                        alert('File dokumen harus diupload');
                        dokumen.focus();
                    }
                    <?php endif; ?>
                });

                function confirmBack(url) {
                    if (confirm('Apakah Anda yakin ingin kembali? Perubahan yang belum disimpan akan hilang.')) {
                        window.location.href = url;
                    }
                }

                function confirmBack(backUrl) {
                    document.getElementById('modalBackLink').href = backUrl;
                    $('#modalBack').modal('show');
                }
                </script>

            </form>
        </div>
        <!--end::Portlet-->
    </div>
</div>