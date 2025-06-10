<div class="m-content">
  <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
      <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
          <h3 class="m-portlet__head-text">
            <?php echo esc($survey['nama']); ?>
          </h3>
        </div>
      </div>
    </div>
    <div class="m-portlet__body">
      <div class="m-portlet__head">
        <div class="dropdown d-inline-block">
          <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown"
            aria-expanded="false">
            <?php
            $idPeriode = $_GET['id_periode'] ?? $periode[0]->id_periode;
            $selectedPeriode = array_filter($periode, fn($p) => $p->id_periode == $idPeriode);
            echo esc(reset($selectedPeriode)->tahun);
            ?>
          </button>
          <div class="dropdown-menu dropdown-menu-right">
            <?php foreach ($periode as $p): ?>
              <a class="dropdown-item"
                href="<?= base_url("public/survey/view?id_survey=$survey[id]&id_periode=$p->id_periode") ?>"><?= $p->tahun ?></a>
            <?php endforeach; ?>
          </div>
        </div>
        <a href="<?= base_url("public/survey/download?id_survey=$survey[id]&id_periode=$idPeriode") ?>"
          class="btn btn-primary">
          Unduh CSV
        </a>
      </div>
      <?php
      if (isset($survey['data'])):
        foreach ($survey['data'] as $data): ?>
          <div class="m-portlet">
            <div class="m-portlet__head">
              <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                  <h3 class="m-portlet__head-text">
                    <?= $data["teks"] ?>
                  </h3>
                </div>
              </div>
            </div>
            <?php switch ($data['jenis']):
              case 1: ?>
                <canvas id="<?= "chart_$data[id_pertanyaan]" ?>" width="400" height="200"></canvas>
                <?php break;
              case 2: ?>
                <div class="m-portlet__body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover table-checkable">
                      <thead>
                        <tr>
                          <!-- <th>ID Pengisi</th> -->
                          <th>Jawaban</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($data['jawaban'] as $jawaban): ?>
                          <tr>
                            <!-- <td style="max-width: 100px; word-break: break-word;"><?php echo esc($jawaban['id_pengisi']) ?></td> -->
                            <td style="max-width: 100px; word-break: break-word;"><?php echo esc($jawaban['teks']) ?></td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
            <?php endswitch; ?>
          </div>
          <?php
        endforeach;
      endif;
      ?>
    </div>
  </div>
</div>
<script>
  const questionIDs = [];
  const answers = [];
  const answerLookUp = {
    '1': 'Sangat Buruk',
    '2': 'Buruk',
    '3': 'Cukup',
    '4': 'Baik',
    '5': 'Sangat Baik'
  };
  <?php
  if (isset($survey['data'])):
    foreach ($survey['data'] as $data): ?>
      <?php if ($data['jenis'] == 1): ?>
        questionIDs.push(<?= $data['id_pertanyaan'] ?>);
        answers.push(<?= json_encode($data['jawaban']); ?>);
      <?php endif; ?>
    <?php endforeach; ?>
    const labels = [];
    const data = [];
    answers.forEach(answer => {
      labels.push(answer.map(item => answerLookUp[item.jawaban]));
      data.push(answer.map(item => item.jumlah));
    });
    questionIDs.forEach((id, index) => {
      let ctx = document.getElementById(`chart_${id}`).getContext('2d');
      let surveyChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels[index],
          datasets: [{
            label: 'Data Kepuasan',
            data: data[index],
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 159, 64, 0.2)',
              'rgba(255, 205, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(153, 102, 255, 0.2)',
              'rgba(201, 203, 207, 0.2)'
            ],
            borderColor: [
              'rgb(255, 99, 132)',
              'rgb(255, 159, 64)',
              'rgb(255, 205, 86)',
              'rgb(75, 192, 192)',
              'rgb(54, 162, 235)',
              'rgb(153, 102, 255)',
              'rgb(201, 203, 207)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            x: {
              title: {
                display: true,
                text: 'Kategori Jawaban'
              }
            },
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'Jumlah Jawaban'
              }
            }
          }
        }
      });
    });
    <?php
  endif;
  ?>
</script>