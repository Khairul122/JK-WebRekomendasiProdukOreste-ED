<?php
$row = $db->get_row("SELECT * FROM tb_alternatif WHERE kode_alternatif='$_GET[ID]'");
?>
<div class="page-header">
    <h1>Ubah Alternatif</h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php if ($_POST) include 'aksi.php' ?>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Kode <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="kode_alternatif" readonly="readonly" value="<?= $row->kode_alternatif ?>" />
            </div>
            <div class="form-group">
                <label>Nama Alternatif <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nama_alternatif" value="<?= set_value('nama_alternatif', $row->nama_alternatif) ?>" />
            </div>
            <div class="form-group">
                <label>Gambar </label>
                <input class="form-control" type="file" name="gambar" accept="image/*" />
                <p class="form-text">Kosongkan jika tidak ingin mengubah gambar.
                </p>
                <img class="thumbnail" height="100" src="<?= get_image_url($row->gambar, 'alternatif/small_') ?>" />
            </div>
            <div class="form-group">
                <label>Deskripsi </label>
                <textarea class="form-control editor" name="deskripsi"><?= set_value('deskripsi', $row->deskripsi) ?></textarea>
            </div>
            <div class="form-group">
                <label>Harga <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="harga" value="<?= set_value('harga', $row->harga) ?>" />
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="fa fa-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=alternatif"><span class="fa fa-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>