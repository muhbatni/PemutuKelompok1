<!-- filepath: c:\xampp\htdocs\pemutu\app\Views\survey_kepuasan\isi_survey\form.php -->
<div class="row">
    <div class="col-md-12">
        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon m--hide">
                            <i class="la la-gear"></i>
                        </span>
                        <h3 class="m-portlet__head-text"><?= esc($survey['nama']); ?></h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <form action="<?= base_url('public/survey/isi-survey/' . $survey['id']); ?>" method="post">
                    <?php foreach ($questions as $index => $question): ?>
                        <div class="form-group">
                            <div class="m-portlet m-portlet--bordered m-portlet--unair">
                                <div class="m-portlet_head mb-4">
                                    <div class="m-portlet__head-caption">
                                        <label for="question_<?= $index; ?>"><?= esc($question['teks']); ?></label>
                                    </div>
                                </div>
                                <?php if ($question['jenis'] === '1'): ?>
                                    <!-- Pilihan range 1-5 -->
                                    <div class="m-portlet__body">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <label class="m-radio m-radio--solid black <?= "m-radio--value-$i"; ?>">
                                                <input type=" radio" name="answers[<?= $question['id']; ?>]" value="<?= $i; ?>"
                                                    required checked>
                                                <span></span>
                                                <?= $i; ?></label>
                                        <?php endfor; ?>
                                    </div>
                                <?php elseif ($question['jenis'] === '2'): ?>
                                    <!-- Isian text field -->
                                    <div class="">
                                        <input type="text" name="answers[<?= $question['id']; ?>]" id="question_<?= $index; ?>"
                                            class="form-control" required>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>