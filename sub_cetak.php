<h1>Sub</h1>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kriteria</th>
            <th>Kode</th>
            <th>Nama sub</th>
            <th>Nilai</th>
        </tr>
    </thead>
    <?php
    $rows = $db->get_results("SELECT * FROM tb_sub s INNER JOIN tb_kriteria k ON s.kode_kriteria=k.kode_kriteria ORDER BY k.kode_kriteria, s.kode_sub");
    $no = 0;
    foreach ($rows as $row) : ?>
        <tr>
            <td><?= ++$no ?></td>
            <td><?= $row->nama_kriteria ?></td>
            <td><?= $row->kode_sub ?></td>
            <td><?= $row->nama_sub ?></td>
            <td><?= $row->nilai_sub ?></td>
        </tr>
    <?php endforeach ?>
</table>