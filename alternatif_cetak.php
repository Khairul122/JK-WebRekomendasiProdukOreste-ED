<h1>Alternatif</h1>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Gambar</th>
            <th>Deskripsi</th>
        </tr>
    </thead>
    <?php
    $rows = $db->get_results("SELECT * FROM tb_alternatif  ORDER BY kode_alternatif");
    $no = 0;
    foreach ($rows as $row) : ?>
        <tr>
            <td><?= ++$no ?></td>
            <td><?= $row->kode_alternatif ?></td>
            <td><?= $row->nama_alternatif ?></td>
            <td><img class="thumbnail" src="<?= get_image_url($row->gambar, 'alternatif/small_') ?>" height="100" /></td>
            <td><?= $row->deskripsi ?></td>
        </tr>
    <?php endforeach ?>
</table>