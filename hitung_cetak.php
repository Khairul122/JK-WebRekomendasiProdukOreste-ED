<h1>Laporan Hasil Perhitungan</h1>
<table class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
            <th>Rank</th>
            <th>Kode</th>
            <th>Nama Alternatif</th>
            <th>Total</th>
        </tr>
    </thead>
    <?php
    $rows = $db->get_results("SELECT * FROM tb_alternatif WHERE NOT ISNULL(rank) ORDER BY rank");
    foreach ($rows as $row) : ?>
        <tr>
            <td><?= $row->rank ?></td>
            <td><?= $row->kode_alternatif ?></td>
            <td><?= $row->nama_alternatif ?></td>
            <td><?= round($row->total, 4) ?></td>
        </tr>
    <?php endforeach; ?>
</table>