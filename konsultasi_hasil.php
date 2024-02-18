<?php
$nilai = $_POST['nilai'];
$bobot = [];
foreach ($KRITERIA as $key => $val) {
    $bobot[$key] = $val->nilai_kriteria;
}
$rel_alternatif = get_rel_alternatif();
$rel_alternatif['A00'] = $nilai;
foreach ($rel_alternatif as $key => $val) {
    foreach ($val as $k => $v) {
        $rel_nilai[$key][$k] = isset($SUB[$v]) ? $SUB[$v]->nilai_sub : 0;
    }
}

$oreste = new Oreste($rel_nilai, $bobot);
$total = $oreste->total['A00'];
$selisih = [];
foreach ($oreste->total as $key => $val) {
    if ($key !== 'A00')
        $selisih[$key] = abs($val - $total);
}

?>

<div class="card mb-3">
    <div class="card-header">
        <strong>Selisih (Total: <?= round($total, 4) ?>)</strong>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped m-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Total</th>
                    <th>Selisih</th>
                </tr>
            </thead>
            <?php
            $no = 1;
            foreach ($selisih as $key => $val) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $key ?></td>
                    <td><?= $ALTERNATIF[$key]->nama_alternatif ?></td>
                    <td><?= round($oreste->total[$key], 3) ?></td>
                    <td><?= round($val, 3) ?></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <strong>Rekomendasi</strong>
    </div>
    <div class="card-body">
        <div class="row">

            <?php
            $no = 1;
            foreach ($selisih as $key => $val) : if ($no++ > 4) continue ?>
                <div class="col-md-3">
                    <div class="card">
                        <img class="card-img-top" src="<?= get_image_url($ALTERNATIF[$key]->gambar, 'alternatif/small_') ?>" />
                        <div class="card-body">
                            <h4 class="text-center"><?= $ALTERNATIF[$key]->nama_alternatif ?></h4>
                            <div>
                                <h5 class="text-center text-danger">Rp <?= number_format($ALTERNATIF[$key]->harga, 0, ',', '.') ?></h5>
                                <p><?= enter2br($ALTERNATIF[$key]->deskripsi) ?></p>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm m-0">
                                <?php foreach ($rel_alternatif[$key] as $k => $v) : ?>
                                    <tr>
                                        <td><?= $KRITERIA[$k]->nama_kriteria ?></td>
                                        <td><?= isset($SUB[$v]) ? $SUB[$v]->nama_sub : '' ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </table>
                        </div>
                        <!-- <div class="card-footer">
                            <a class="btn btn-block btn-primary">Selengkapnya</a>
                        </div> -->
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>