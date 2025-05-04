<div class="m-content">
  <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
      <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
          <h3 class="m-portlet__head-text">
            <?php echo esc($survey[0]['nama']); ?>
          </h3>
        </div>
      </div>
    </div>
    <div class="m-portlet__body">
      <?php
      if (isset($optionsData)):
        foreach ($optionsData as $data): ?>
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
            <canvas id="<?= "P_$data[id_pertanyaan]" ?>" width="400" height="200"></canvas>
          </div>
          <?php
        endforeach;
      endif;
      ?>
      <!--begin: Search Form -->
      <!--end: Search Form -->
      <!--begin: Datatable -->
      <!--end: Datatable -->
    </div>
  </div>
</div>
<script src="<?= base_url(); ?>/public/assets/demo/default/custom/components/datatables/base/html-table.js"
  type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const questionIDs = [];
  const answers = [];
  <?php
  if (isset($optionsData)) {
    foreach ($optionsData as $data): ?>
      questionIDs.push(<?= $data['id_pertanyaan'] ?>);
      answers.push(<?= json_encode($data['jawaban']); ?>);
      <?php
    endforeach;
  }
  ?>
  if (!answers || !questionIDs) {
    return;
  }
  const answerLookUp = {
    '1': 'Sangat Buruk',
    '2': 'Buruk',
    '3': 'Cukup',
    '4': 'Baik',
    '5': 'Sangat Baik'
  };
  const labels = [];
  const data = [];
  answers.forEach(answer => {
    labels.push(answer.map(item => answerLookUp[item.jawaban]));
    data.push(answer.map(item => item.jumlah));
  });
  questionIDs.forEach((id, index) => {
    let ctx = document.getElementById(`P_${id}`).getContext('2d');
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
</script>