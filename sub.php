<div class="page-header">
    <h1>Sub</h1>
</div>
<div class="card mb-3">
    <div class="card-header">
        <form class="form-inline">
            <input type="hidden" name="m" value="sub" />
            <div class="mr-1">
                <input class="form-control" type="text" placeholder="Pencarian. . ." name="q" value="<?= _get('q') ?>" />
            </div>
            <div class="mr-1">
                <button class="btn btn-success"><span class="fa fa-sync"></span> Refresh</button>
            </div>
            <div class="mr-1">
                <a class="btn btn-primary" href="?m=sub_tambah"><span class="fa fa-plus"></span> Tambah</a>
            </div>
            <div class="mr-1">
                <a class="btn btn-secondary" href="cetak.php?m=sub&a=<?= _get('q') ?>" target="_blank"><span class="fa fa-print"></span> Cetak</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped m-0">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Kriteria</th>
                    <th>Nama</th>
                    <th>Nilai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <?php
            $q = esc_field(_get('q'));
            $rows = $db->get_results("SELECT * FROM tb_sub s INNER JOIN tb_kriteria k ON s.kode_kriteria=k.kode_kriteria WHERE nama_sub LIKE '%$q%' ORDER BY k.kode_kriteria, s.kode_sub");
            foreach ($rows as $row) : ?>
                <tr>
                    <td><?= $row->kode_sub ?></td>
                    <td><?= $row->nama_kriteria ?></td>
                    <td><?= $row->nama_sub ?></td>
                    <td><?= $row->nilai_sub ?></td>
                    <td>
                        <a class="btn btn-sm btn-warning" href="?m=sub_ubah&ID=<?= $row->kode_sub ?>"><span class="fa fa-edit"></span></a>
                        <a class="btn btn-sm btn-danger" href="aksi.php?act=sub_hapus&ID=<?= $row->kode_sub ?>" onclick="return confirm('Hapus data?')"><span class="fa fa-trash"></span></a>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>