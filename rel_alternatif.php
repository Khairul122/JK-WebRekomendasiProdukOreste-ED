<div class="page-header">
    <h1>Nilai Bobot Alternatif</h1>
</div>
<div class="card mb-3">
    <div class="card-header">
        <form class="form-inline">
            <input type="hidden" name="m" value="rel_alternatif" />
            <div class="form-group mr-1">
                <input class="form-control" type="text" name="q" value="<?= _get('q') ?>" placeholder="Pencarian..." />
            </div>
            <div class="form-group mr-1">
                <button class="btn btn-success"><span class="fa fa-sync"></span> Refresh</button>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped m-0">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Alternatif</th>
                    <?php foreach ($KRITERIA as $key => $val) : ?>
                        <th><?= $val->nama_kriteria ?></th>
                    <?php endforeach ?>
                    <th>Aksi</th>
                </tr>
            </thead>
            <?php
            $db->query("DELETE FROM tb_rel_alternatif WHERE kode_alternatif NOT IN (SELECT kode_alternatif FROM tb_alternatif)");
            $db->query("DELETE FROM tb_rel_alternatif WHERE kode_kriteria NOT IN (SELECT kode_kriteria FROM tb_kriteria)");

            $q = esc_field(_get('q'));
            $rows = $db->get_results("SELECT * FROM tb_alternatif WHERE kode_alternatif LIKE '%$q%' OR nama_alternatif LIKE '%$q%' ORDER BY kode_alternatif");

            $rel_alternatif = get_rel_alternatif();
            $no = 0;
            foreach ($rows as $row) : ?>
                <tr>
                    <td><?= $row->kode_alternatif ?></td>
                    <td><?= $row->nama_alternatif ?></td>
                    <?php foreach ($rel_alternatif[$row->kode_alternatif] as $k => $v) : ?>
                        <td><?= isset($SUB[$v]) ? $SUB[$v]->nama_sub : '' ?></td>
                    <?php endforeach ?>
                    <td>
                        <a class="btn btn-sm btn-warning" href="?m=rel_alternatif_ubah&ID=<?= $row->kode_alternatif ?>"><span class="fa fa-edit"></span> Ubah</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>