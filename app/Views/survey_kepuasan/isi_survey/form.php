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
                            <div class="m-portlet m-portlet--bordered m-portlet--unair p-3">
                                <div class="m-portlet_head mb-1">
                                    <div class="m-portlet__head-caption mb-2">
                                        <label for="question_<?= $index; ?>"><?= esc($question['teks']); ?></label>
                                    </div>
                                </div>
                                <?php if ($question['jenis'] === '1'): ?>
                                    <!-- Pilihan range 1-5 -->
                                    <div class="">
                                        <label class="m-radio m-radio--solid m-radio--brand m-2">
                                            <input type="radio" name="answers[<?= $question['id']; ?>]" value="1" required>
                                            <span class="mt-2"></span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36"
                                                viewBox="0 0 512 512">
                                                <path fill="#b90000"
                                                    d="M0 256a256 256 0 1 1 512 0a256 256 0 1 1-512 0m338.7 139.9c6.6-5.9 7.1-16 1.2-22.6c-16.1-17.9-44.2-37.3-83.9-37.3s-67.8 19.4-83.9 37.3c-5.9 6.6-5.4 16.7 1.2 22.6s16.7 5.4 22.6-1.2c11.7-13 31.6-26.7 60.1-26.7s48.4 13.7 60.1 26.7c5.9 6.6 16 7.1 22.6 1.2M176.4 272c17.7 0 32-14.3 32-32c0-1.5-.1-3-.3-4.4l10.9 3.6c8.4 2.8 17.4-1.7 20.2-10.1s-1.7-17.4-10.1-20.2l-96-32c-8.4-2.8-17.4 1.7-20.2 10.1s1.7 17.4 10.1 20.2l30.7 10.2c-5.8 5.8-9.3 13.8-9.3 22.6c0 17.7 14.3 32 32 32m192-32c0-8.9-3.6-17-9.5-22.8l30.2-10.1c8.4-2.8 12.9-11.9 10.1-20.2S387.3 174 379 176.8l-96 32c-8.4 2.8-12.9 11.9-10.1 20.2s11.9 12.9 20.2 10.1l11.7-3.9c-.2 1.5-.3 3.1-.3 4.7c0 17.7 14.3 32 32 32s32-14.3 32-32z" />
                                            </svg>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand m-2">
                                            <input type="radio" name="answers[<?= $question['id']; ?>]" value="2" required>
                                            <span class="mt-2"></span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36"
                                                viewBox="0 0 512 512">
                                                <path fill="#d58000"
                                                    d="M256 512a256 256 0 1 0 0-512a256 256 0 1 0 0 512m-96.7-123.3c-2.6 8.4-11.6 13.2-20 10.5s-13.2-11.6-10.5-20C145.2 326.1 196.3 288 256 288s110.8 38.1 127.3 91.3c2.6 8.4-2.1 17.4-10.5 20s-17.4-2.1-20-10.5C340.5 349.4 302.1 320 256 320s-84.5 29.4-96.7 68.7M144.4 208a32 32 0 1 1 64 0a32 32 0 1 1-64 0m192-32a32 32 0 1 1 0 64a32 32 0 1 1 0-64" />
                                            </svg>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand m-2">
                                            <input type="radio" name="answers[<?= $question['id']; ?>]" value="3" required>
                                            <span class="mt-2"></span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36"
                                                viewBox="0 0 512 512">
                                                <path fill="#dbda07"
                                                    d="M256 512a256 256 0 1 0 0-512a256 256 0 1 0 0 512m-79.6-336a32 32 0 1 1 0 64a32 32 0 1 1 0-64m128 32a32 32 0 1 1 64 0a32 32 0 1 1-64 0M160 336h192c8.8 0 16 7.2 16 16s-7.2 16-16 16H160c-8.8 0-16-7.2-16-16s7.2-16 16-16" />
                                            </svg>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand m-2">
                                            <input type="radio" name="answers[<?= $question['id']; ?>]" value="4" required>
                                            <span class="mt-2"></span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36"
                                                viewBox="0 0 512 512">
                                                <path fill="#34b700"
                                                    d="M256 512a256 256 0 1 0 0-512a256 256 0 1 0 0 512M96.8 314.1c-3.8-13.7 7.4-26.1 21.6-26.1h275.2c14.2 0 25.5 12.4 21.6 26.1C396.2 382 332.1 432 256 432S115.8 382 96.8 314.1M144.4 192a32 32 0 1 1 64 0a32 32 0 1 1-64 0m192-32a32 32 0 1 1 0 64a32 32 0 1 1 0-64" />
                                            </svg>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand m-2">
                                            <input type="radio" name="answers[<?= $question['id']; ?>]" value="5" required>
                                            <span class="mt-2"></span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36"
                                                viewBox="0 0 512 512">
                                                <path fill="#db0779"
                                                    d="M256 512a256 256 0 1 0 0-512a256 256 0 1 0 0 512m132.1-199.2c12.3-3.8 24.3 6.9 19.3 18.7c-25 59.1-83.2 100.5-151.1 100.5s-126.2-41.4-151.1-100.5c-5-11.8 7-22.5 19.3-18.7c39.7 12.2 84.5 19 131.8 19s92.1-6.8 131.8-19M199.3 129.1c17.8 4.8 28.4 23.1 23.6 40.8l-17.4 65c-2.3 8.5-11.1 13.6-19.6 11.3l-65.1-17.4C103 224 92.4 205.7 97.2 188s23.1-28.4 40.8-23.6l16.1 4.3l4.3-16.1c4.8-17.8 23.1-28.4 40.8-23.6zm154.3 23.6l4.3 16.1l16.1-4.3c17.8-4.8 36.1 5.8 40.8 23.6s-5.8 36.1-23.6 40.8l-65.1 17.4c-8.5 2.3-17.3-2.8-19.6-11.3l-17.4-65c-4.8-17.8 5.8-36.1 23.6-40.8s36.1 5.8 40.9 23.6z" />
                                            </svg>
                                        </label>
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