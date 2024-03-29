<div class="page-header">
    <h1>Tambah Sub</h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php if ($_POST) include 'aksi.php' ?>
        <form method="post">
            <div class="form-group">
                <label>Kode <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="kode_sub" value="<?= set_value('kode_sub', kode_oto('kode_sub', 'tb_sub', 'S', 2)) ?>" />
            </div>
            <div class="form-group">
                <label>Kriteria <span class="text-danger">*</span></label>
                <select class="form-control" name="kode_kriteria">
                    <option value="">&nbsp;</option>
                    <?= get_kriteria_option($_POST['kode_kriteria']) ?>
                </select>
            </div>
            <div class="form-group">
                <label>Nama sub <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nama_sub" value="<?= set_value('nama_sub') ?>" />
            </div>
            <div class="form-group">
                <label>Nilai sub <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nilai_sub" value="<?= set_value('nilai_sub') ?>" />
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="fa fa-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=sub"><span class="fa fa-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>