<?php
$row = $db->get_row("SELECT * FROM tb_alternatif WHERE kode_alternatif='$_GET[ID]'");
?>
<div class="page-header">
    <h1>Ubah Nilai Bobot &raquo; <small><?= $row->nama_alternatif ?></small></h1>
</div>
<div class="row">
    <div class="col-sm-4">
        <form method="post" action="aksi.php?act=rel_alternatif_ubah&ID=<?= $_GET['ID'] ?>">
            <?php
            $rows = $db->get_results("SELECT * FROM tb_rel_alternatif r INNER JOIN tb_kriteria k ON k.kode_kriteria=r.kode_kriteria  
                WHERE kode_alternatif='$_GET[ID]' ORDER BY r.kode_kriteria");
            foreach ($rows as $row) : ?>
                <div class="form-group">
                    <label><?= $row->nama_kriteria ?></label>
                    <select class="form-control" name="nilai[<?= $row->kode_kriteria ?>]">
                        <?= get_sub_option($row->kode_sub, $row->kode_kriteria) ?>
                    </select>
                </div>
            <?php endforeach ?>
            <button class="btn btn-primary"><span class="fa fa-save"></span> Simpan</button>
            <a class="btn btn-danger" href="?m=rel_alternatif"><span class="fa fa-arrow-left"></span> Kembali</a>
        </form>
    </div>
</div>