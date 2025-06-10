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
                action="<?= isset($dataDukung) ? base_url('public/audit/input-data-dukung/update/' . $dataDukung['id']) : base_url('public/audit/input-data-dukung') ?>"
                method="post" enctype="multipart/form-data">
                <div class="m-portlet__body">

                    <div class="form-group m-form__group">
                        <label for="id_pelaksanaan">Kode Audit</label>
                        <?php if (isset($dataDukung)): ?>
                            <!-- Show readonly input when editing -->
                            <input type="hidden" name="id_pelaksanaan" value="<?= $dataDukung['id_pelaksanaan'] ?>">
                            <input type="text" class="form-control m-input" value="<?= $dataDukung['kode_audit'] ?>"
                                readonly>
                        <?php else: ?>
                            <!-- Show dropdown when creating new -->
                            <select class="form-control m-input" name="id_pelaksanaan" id="id_pelaksanaan" required>
                                <option value="">Pilih Kode Audit</option>
                                <?php foreach ($pelaksanaans as $pelaksanaan): ?>
                                    <option value="<?= $pelaksanaan['id'] ?>">
                                        <?= $pelaksanaan['kode_audit'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>

                    <!-- Info Pelaksanaan -->
                    <div id="pelaksanaan-info">
                        <div class="form-group m-form__group">
                            <label>Unit</label>
                            <input type="text" class="form-control m-input" id="unit-name" readonly
                                placeholder="Unit Pelaksanaan">
                        </div>
                    </div>

                    <!-- Standar dropdown -->
                    <div class="form-group m-form__group">
                        <label for="id_standar">Standar</label>
                        <?php if (isset($dataDukung)): ?>
                            <?php
                            // Cari nama standar yang sesuai
                            $nama_standar = '';
                            foreach ($standars as $standar) {
                                if ($standar['id'] == $dataDukung['id_standar']) {
                                    $nama_standar = $standar['nama_standar'];
                                    break;
                                }
                            }
                            ?>
                            <input type="hidden" name="id_standar" value="<?= $dataDukung['id_standar'] ?>">
                            <input type="text" class="form-control m-input" value="<?= htmlspecialchars($nama_standar) ?>" readonly>
                        <?php else: ?>
                            <select class="form-control m-input" name="id_standar" id="id_standar" required>
                                <option value="">Pilih Standar</option>
                                <?php foreach ($standars as $standar): ?>
                                    <option value="<?= $standar['id'] ?>"
                                        <?= (isset($dataDukung) && $dataDukung['id_standar'] == $standar['id']) ? 'selected' : '' ?>>
                                        <?= $standar['nama_standar'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>

                    <!-- Pernyataan dropdown -->
                    <div class="form-group m-form__group">
                        <label for="id_pernyataan">Pernyataan</label>
                        <?php if (isset($dataDukung)): ?>
                            <?php
                            // Cari nama pernyataan yang sesuai
                            $nama_pernyataan = '';
                            if (!empty($pernyataans)) {
                                foreach ($pernyataans as $pernyataan) {
                                    if ($pernyataan['id'] == $dataDukung['id_pernyataan']) {
                                        $nama_pernyataan = $pernyataan['pernyataan'];
                                        break;
                                    }
                                }
                            }
                            ?>
                            <input type="hidden" name="id_pernyataan" value="<?= $dataDukung['id_pernyataan'] ?>">
                            <input type="text" class="form-control m-input" value="<?= htmlspecialchars($nama_pernyataan) ?>" readonly>
                        <?php else: ?>
                            <select class="form-control m-input" name="id_pernyataan" id="id_pernyataan" required>
                                <option value="">Pilih Pernyataan</option>
                                <?php if (!empty($pernyataans)): ?>
                                    <?php foreach ($pernyataans as $pernyataan): ?>
                                        <option value="<?= $pernyataan['id'] ?>"
                                            <?= (isset($dataDukung) && $dataDukung['id_pernyataan'] == $pernyataan['id']) ? 'selected' : '' ?>>
                                            <?= $pernyataan['pernyataan'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        <?php endif; ?>
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
                        <?php if (isset($dataDukung) && $dataDukung['dokumen']): ?>
                            <div class="mt-2">
                                <p>File saat ini:</p>
                                <?php
                                $files = explode('|', $dataDukung['dokumen']);
                                foreach ($files as $file): ?>
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
                        <?php if (!isset($dataDukung)): ?>
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
                                        throw new Error(`HTTP error! status: ${response.status}`);
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    if (data) {
                                        document.getElementById('unit-name').value = data.unit_name || '';
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    document.getElementById('unit-name').value = '';
                                    alert('Gagal mengambil data: ' + error.message);
                                });
                        } else {
                            document.getElementById('unit-name').value = '';
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
                        <?php if (isset($dataDukung)): ?>
                            updatePelaksanaanInfo('<?= $dataDukung['id_pelaksanaan'] ?>');
                        <?php endif; ?>

                        // Handle form reset
                        const resetButton = document.querySelector('button[type="reset"]');
                        if (resetButton) {
                            resetButton.addEventListener('click', function() {
                                setTimeout(() => {
                                    // Just clear the values without hiding the container
                                    document.getElementById('unit-name').value = '';

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

                    document.addEventListener('DOMContentLoaded', function() {
                        // Get all required elements
                        const pelaksanaanSelect = document.getElementById('id_pelaksanaan');
                        const standarSelect = document.getElementById('id_standar');
                        const pernyataanSelect = document.getElementById('id_pernyataan');
                        const unitInput = document.getElementById('unit-name');

                        // Initially disable standar and pernyataan selects
                        if (!pelaksanaanSelect?.value) {
                            standarSelect.disabled = true;
                            pernyataanSelect.disabled = true;
                        }

                        // Handle pelaksanaan (Kode Audit) change
                        if (pelaksanaanSelect) {
                            pelaksanaanSelect.addEventListener('change', function() {
                                const pelaksanaanId = this.value;
                                resetDropdowns();

                                if (pelaksanaanId) {
                                    // Update unit info
                                    updatePelaksanaanInfo(pelaksanaanId);
                                    // Get standar options
                                    fetchStandarOptions(pelaksanaanId);
                                }
                            });
                        }

                        // Handle standar change
                        if (standarSelect) {
                            standarSelect.addEventListener('change', function() {
                                const standarId = this.value;
                                resetPernyataanDropdown();

                                if (standarId) {
                                    fetchPernyataanOptions(standarId);
                                }
                            });
                        }

                        // Helper Functions
                        function resetDropdowns() {
                            // Reset and disable standar
                            standarSelect.innerHTML = '<option value="">Pilih Standar</option>';
                            standarSelect.disabled = true;

                            // Reset and disable pernyataan
                            resetPernyataanDropdown();

                            // Reset unit
                            unitInput.value = '';
                        }

                        function resetPernyataanDropdown() {
                            pernyataanSelect.innerHTML = '<option value="">Pilih Pernyataan</option>';
                            pernyataanSelect.disabled = true;
                        }

                        function fetchStandarOptions(pelaksanaanId) {
                            fetch(`<?= base_url('public/audit/get-standar-by-pelaksanaan') ?>/${pelaksanaanId}`)
                                .then(response => {
                                    if (!response.ok) throw new Error('Network response was not ok');
                                    return response.json();
                                })
                                .then(data => {
                                    data.forEach(standar => {
                                        const option = document.createElement('option');
                                        option.value = standar.id;
                                        option.textContent = standar.nama_standar;
                                        standarSelect.appendChild(option);
                                    });
                                    standarSelect.disabled = false;
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Gagal mengambil data standar');
                                });
                        }

                        function fetchPernyataanOptions(standarId) {
                            fetch(`<?= site_url('audit/get-pernyataan-by-standar') ?>/${standarId}`)
                                .then(response => {
                                    if (!response.ok) throw new Error('Network response was not ok');
                                    return response.json();
                                })
                                .then(data => {
                                    if (data && data.length > 0) {
                                        data.forEach(item => {
                                            const option = document.createElement('option');
                                            option.value = item.id;
                                            option.textContent = item.pernyataan;
                                            pernyataanSelect.appendChild(option);
                                        });
                                        pernyataanSelect.disabled = false;
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Gagal mengambil data pernyataan');
                                });
                        }

                        // Form validation
                        const form = document.querySelector('form');
                        form.addEventListener('submit', function(e) {
                            const requiredFields = ['id_pelaksanaan', 'id_standar', 'id_pernyataan', 'deskripsi'];
                            let isValid = true;

                            requiredFields.forEach(fieldId => {
                                const field = document.getElementById(fieldId);
                                if (!field.value.trim()) {
                                    isValid = false;
                                    e.preventDefault();
                                    alert(`${field.previousElementSibling.textContent} harus diisi`);
                                    field.focus();
                                    return false;
                                }
                            });

                            // Validate file upload for new entries
                            <?php if (!isset($dataDukung)): ?>
                                const dokumen = document.getElementById('dokumen');
                                if (!dokumen.files.length) {
                                    isValid = false;
                                    e.preventDefault();
                                    alert('File dokumen harus diupload');
                                    dokumen.focus();
                                }
                            <?php endif; ?>

                            return isValid;
                        });

                        // Initialize for edit mode
                        <?php if (isset($dataDukung)): ?>
                            updatePelaksanaanInfo('<?= $dataDukung['id_pelaksanaan'] ?>');
                        <?php endif; ?>
                    });
                </script>

            </form>
        </div>
        <!--end::Portlet-->
    </div>
</div>