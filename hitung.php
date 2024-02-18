<div class="page-header">
    <h1>Perhitungan</h1>
</div>

<div class="card mb-3 border-primary">
    <div class="card-header">
        <a data-toggle="collapse" href="#alt_krit">
            Alternatif Kriteria
        </a>
    </div>
    <div class="table-responsive collapse show" id="alt_krit">
        <table class="table table-bordered table-striped table-hover m-0">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <?php foreach ($KRITERIA as $key => $val) : ?>
                        <th><?= $val->nama_kriteria ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <?php
            $rel_alternatif = get_rel_alternatif();
            foreach ($rel_alternatif as $key => $val) : ?>
                <tr>
                    <td><?= $key ?></td>
                    <td><?= $ALTERNATIF[$key]->nama_alternatif ?></td>
                    <?php foreach ($val as $k => $v) : ?>
                        <td><?= $SUB[$v]->nama_sub ?></td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>
<div class="card mb-3 border-primary">
    <div class="card-header">
        <a data-toggle="collapse" href="#nilai">
            Nilai Alternatif Kriteria
        </a>
    </div>
    <div class="table-responsive collapse show" id="nilai">
        <table class="table table-bordered table-striped table-hover m-0">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <?php foreach ($KRITERIA as $key => $val) : ?>
                        <th><?= $val->nama_kriteria ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <?php
            $bobot = array();
            foreach ($KRITERIA as $key => $val) {
                $bobot[$key] = $val->nilai_kriteria;
            }
            foreach ($rel_alternatif as $key => $val) {
                foreach ($val as $k => $v) {
                    $rel_alternatif[$key][$k] = $SUB[$v]->nilai_sub;
                }
            }
            $oreste = new Oreste($rel_alternatif, $bobot);

            $categories = array();
            $series[0] = array(
                'name' => 'Alternatif',
            );

            $db->query("UPDATE tb_alternatif SET total=NULL, rank=NULL");
            foreach ($oreste->rank as $key => $val) {
                $db->query("UPDATE tb_alternatif SET total='{$oreste->total[$key]}', rank='{$oreste->rank[$key]}' WHERE kode_alternatif='$key'");
                $categories[] = $ALTERNATIF[$key]->nama_alternatif;
                $series[0]['data'][] = $oreste->total[$key] * 1;
            }

            foreach ($oreste->data as $key => $val) : ?>
                <tr>
                    <td><?= $key ?></td>
                    <td><?= $ALTERNATIF[$key]->nama_alternatif ?></td>
                    <?php foreach ($val as $k => $v) : ?>
                        <td><?= round($v, 4) ?></td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>
<div class="card mb-3 border-primary">
    <div class="card-header">
        <a data-toggle="collapse" href="#data_rank">
            Data Rank
        </a>
    </div>
    <div class="table-responsive collapse show" id="data_rank">
        <table class="table table-bordered table-striped table-hover m-0">
            <thead>
                <tr>
                    <th>Kode</th>
                    <?php foreach ($KRITERIA as $key => $val) : ?>
                        <th><?= $key ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <?php foreach ($oreste->data_rank as $key => $val) : ?>
                <tr>
                    <td><?= $key ?></td>
                    <?php foreach ($val as $k => $v) : ?>
                        <td><?= round($v, 4) ?></td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>
<div class="card mb-3 border-primary">
    <div class="card-header">
        <a data-toggle="collapse" href="#normal">
            Normalisasi
        </a>
    </div>
    <div class="table-responsive collapse show" id="normal">
        <table class="table table-bordered table-striped table-hover m-0">
            <thead>
                <tr>
                    <th>Kode</th>
                    <?php foreach ($KRITERIA as $key => $val) : ?>
                        <th><?= $key ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <?php foreach ($oreste->normal as $key => $val) : ?>
                <tr>
                    <td><?= $key ?></td>
                    <?php foreach ($val as $k => $v) : ?>
                        <td><?= round($v, 4) ?></td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>
<div class="card mb-3 border-primary">
    <div class="card-header">
        <a data-toggle="collapse" href="#distance_score">
            Distance Score
        </a>
    </div>
    <div class="table-responsive collapse show" id="distance_score">
        <table class="table table-bordered table-striped table-hover m-0">
            <thead>
                <tr>
                    <th>Kode</th>
                    <?php foreach ($KRITERIA as $key => $val) : ?>
                        <th><?= $key ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <?php foreach ($oreste->distance_score as $key => $val) : ?>
                <tr>
                    <td><?= $key ?></td>
                    <?php foreach ($val as $k => $v) : ?>
                        <td><?= round($v, 4) ?></td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>
<div class="card mb-3 border-primary">
    <div class="card-header">
        <a data-toggle="collapse" href="#terbobot">
            Terbobot
        </a>
    </div>
    <div class="table-responsive collapse show" id="terbobot">
        <table class="table table-bordered table-striped table-hover m-0">
            <thead>
                <tr>
                    <th>Kode</th>
                    <?php foreach ($KRITERIA as $key => $val) : ?>
                        <th><?= $key ?></th>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <th>Bobot</th>
                    <?php foreach ($oreste->bobot as $key => $val) : ?>
                        <th><?= $val ?> (<?= round($oreste->bobot_normal[$key], 4) ?>)</th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <?php foreach ($oreste->terbobot as $key => $val) : ?>
                <tr>
                    <td><?= $key ?></td>
                    <?php foreach ($val as $k => $v) : ?>
                        <td><?= round($v, 4) ?></td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>
<div class="card mb-3 border-primary">
    <div class="card-header">
        <a data-toggle="collapse" href="#rank">
            Perangkingan
        </a>
    </div>
    <div class="table-responsive collapse show" id="rank">
        <table class="table table-bordered table-striped table-hover m-0">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Preferensi</th>
                    <th>Rank</th>
                </tr>
            </thead>
            <?php foreach ($oreste->rank as $key => $val) :  ?>
                <tr>
                    <td><?= $key ?></td>
                    <td><?= $ALTERNATIF[$key]->nama_alternatif ?></td>
                    <td><?= round($oreste->total[$key], 4) ?></td>
                    <td><?= round($oreste->rank[$key], 4) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="card-body">
        <script src="assets/highcharts/highcharts.js"></script>
        <script src="assets/highcharts/modules/exporting.js"></script>
        <script src="assets/highcharts/modules/export-data.js"></script>
        <script src="assets/highcharts/modules/accessibility.js"></script>
        <div id="container"></div>
        <script>
            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Grafik Hasil Perhitungan Metode Oreste'
                },
                xAxis: {
                    categories: <?= json_encode($categories) ?>,
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.4f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: <?= json_encode($series) ?>
            });
        </script>
    </div>
    <div class="card-footer">
        <a class="btn btn-secondary" href="cetak.php?m=hitung" target="_blank"><span class="icon-print"></span> Cetak</a>
    </div>
</div>