<div class="page-header">
    <h1>Rekomendasi</h1>
</div>
<form method="post">
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">
                    <strong>Pilih Atribut</strong>
                </div>
                <div class="card-body">
                    <?php foreach ($KRITERIA as $key => $val) : ?>
                        <div class="form-group">
                            <label><?= $val->nama_kriteria ?></label>
                            <select class="form-control" name="nilai[<?= $key ?>]">
                                <?= get_sub_option($_POST['nilai'][$key], $key) ?>
                            </select>
                        </div>
                    <?php endforeach ?>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary"><span class="fa fa-eye"></span> Rekomendasi</button>
                </div>
            </div>
        </div>
    </div>
    <?php if ($_POST) include 'konsultasi_hasil.php'; ?>
</form>