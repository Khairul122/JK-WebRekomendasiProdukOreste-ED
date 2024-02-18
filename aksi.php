<?php
require_once 'functions.php';

if ($mod == 'login') {
    $user = esc_field($_POST['user']);
    $pass = esc_field($_POST['pass']);

    $row = $db->get_row("SELECT * FROM tb_user WHERE user='$user' AND pass='$pass'");
    if ($row) {
        $_SESSION['login'] = $row->user;
        redirect_js("index.php");
    } else {
        print_msg("Salah kombinasi username dan password.");
    }
} else if ($mod == 'password') {
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $pass3 = $_POST['pass3'];

    $row = $db->get_row("SELECT * FROM tb_user WHERE user='$_SESSION[login]' AND pass='$pass1'");

    if ($pass1 == '' || $pass2 == '' || $pass3 == '')
        print_msg('Field bertanda * harus diisi.');
    elseif (!$row)
        print_msg('Password lama salah.');
    elseif ($pass2 != $pass3)
        print_msg('Password baru dan konfirmasi password baru tidak sama.');
    else {
        $db->query("UPDATE tb_user SET pass='$pass2' WHERE user='$_SESSION[login]'");
        print_msg('Password berhasil diubah.', 'success');
    }
} elseif ($act == 'logout') {
    unset($_SESSION['login']);
    header("location:index.php?m=login");
}

/** alternatif **/
elseif ($mod == 'alternatif_tambah') {
    $kode_alternatif = $_POST['kode_alternatif'];
    $nama_alternatif = $_POST['nama_alternatif'];
    $gambar = $_FILES['gambar'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];

    if ($kode_alternatif == '' || $nama_alternatif == '')
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif ($db->get_results("SELECT * FROM tb_alternatif WHERE kode_alternatif='$kode_alternatif'"))
        print_msg("Kode sudah ada!");
    else {
        if ($gambar['name']) {
            $file_name = rand(1000, 9999) . parse_file_name($gambar['name']);
            $img = new SimpleImage($gambar['tmp_name']);
            $img->best_fit(1024, 1024);
            $img->save('assets/img/alternatif/' . $file_name);
            $img->thumbnail(300, 300);
            $img->save('assets/img/alternatif/small_' . $file_name);
        } else {
            $file_name = '';
        }
        $db->query("INSERT INTO tb_alternatif(kode_alternatif, nama_alternatif, gambar, deskripsi, harga) VALUES ('$kode_alternatif', '$nama_alternatif', '$file_name', '$deskripsi', '$harga')");
        $db->query("INSERT INTO tb_rel_alternatif(kode_alternatif, kode_kriteria) SELECT '$kode_alternatif', kode_kriteria FROM tb_kriteria");
        redirect_js("index.php?m=alternatif");
    }
} elseif ($mod == 'alternatif_ubah') {
    $kode_alternatif = $_POST['kode_alternatif'];
    $nama_alternatif = $_POST['nama_alternatif'];
    $gambar = $_FILES['gambar'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];

    if ($kode_alternatif == '' || $nama_alternatif == '')
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif ($db->get_results("SELECT * FROM tb_alternatif WHERE kode_alternatif='$kode_alternatif' AND kode_alternatif<>'$_GET[ID]'"))
        print_msg("Kode sudah ada!");
    else {
        if ($gambar['name']) {
            delete_image($_GET['ID']);
            $file_name = rand(1000, 9999) . parse_file_name($gambar['name']);
            $img = new SimpleImage($gambar['tmp_name']);
            $img->best_fit(1024, 1024);
            $img->save('assets/img/alternatif/' . $file_name);
            $img->thumbnail(300, 300);
            $img->save('assets/img/alternatif/small_' . $file_name);
            $sql_gambar = ", gambar='$file_name'";
        } else {
            $sql_gambar = '';
        }
        $db->query("UPDATE tb_alternatif SET nama_alternatif='$nama_alternatif' $sql_gambar, deskripsi='$deskripsi', harga='$harga' WHERE kode_alternatif='$_GET[ID]'");
        redirect_js("index.php?m=alternatif");
    }
} elseif ($act == 'alternatif_hapus') {
    $db->query("DELETE FROM tb_rel_alternatif WHERE kode_alternatif='$_GET[ID]'");
    $db->query("DELETE FROM tb_alternatif WHERE kode_alternatif='$_GET[ID]'");
    header("location:index.php?m=alternatif");
}

/** kriteria */
elseif ($mod == 'kriteria_tambah') {
    $kode_kriteria = $_POST['kode_kriteria'];
    $nama_kriteria = $_POST['nama_kriteria'];
    $nilai_kriteria = $_POST['nilai_kriteria'];
    if ($kode_kriteria == '' || $nama_kriteria == '' || $nilai_kriteria == '')
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif ($db->get_results("SELECT * FROM tb_kriteria WHERE kode_kriteria='$kode_kriteria'"))
        print_msg("Kode sudah ada!");
    else {
        $db->query("INSERT INTO tb_kriteria (kode_kriteria, nama_kriteria, nilai_kriteria) VALUES ('$kode_kriteria', '$nama_kriteria', '$nilai_kriteria')");
        $db->query("INSERT INTO tb_rel_alternatif(kode_alternatif, kode_kriteria) SELECT kode_alternatif, '$kode_kriteria' FROM tb_alternatif");
        redirect_js("index.php?m=kriteria");
    }
} else if ($mod == 'kriteria_ubah') {
    $nama_kriteria = $_POST['nama_kriteria'];
    $nilai_kriteria = $_POST['nilai_kriteria'];
    if ($nama_kriteria == '' || $nilai_kriteria == '')
        print_msg("Field bertanda * tidak boleh kosong!");
    else {
        $db->query("UPDATE tb_kriteria SET nama_kriteria='$nama_kriteria', nilai_kriteria='$nilai_kriteria' WHERE kode_kriteria='$_GET[ID]'");
        redirect_js("index.php?m=kriteria");
    }
} else if ($act == 'kriteria_hapus') {
    if ($db->get_row("SELECT * FROM tb_sub WHERE kode_kriteria='$_GET[ID]'")) {
        set_msg('Data tidak bisa dihapus karena masih ada subkriteria', 'danger');
    } else {
        $db->query("DELETE FROM tb_rel_alternatif WHERE kode_kriteria='$_GET[ID]'");
        $db->query("DELETE FROM tb_kriteria WHERE kode_kriteria='$_GET[ID]'");
    }
    header("location:index.php?m=kriteria");
}

/** RELASI ALTERNATIF */
else if ($act == 'rel_alternatif_ubah') {
    foreach ($_POST['nilai'] as $key => $value) {
        $db->query("UPDATE tb_rel_alternatif SET kode_sub='$value' WHERE kode_alternatif='$_GET[ID]' AND kode_kriteria='$key'");
    }

    header("location:index.php?m=rel_alternatif");
}

/** sub */
elseif ($mod == 'sub_tambah') {
    $kode_kriteria = $_POST['kode_kriteria'];
    $kode_sub = $_POST['kode_sub'];
    $nama_sub = $_POST['nama_sub'];
    $nilai_sub = $_POST['nilai_sub'];
    if ($kode_kriteria == '' || $kode_sub == '' || $nama_sub == '' || $nilai_sub == '')
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif ($db->get_results("SELECT * FROM tb_sub WHERE kode_sub='$kode_sub'"))
        print_msg("Kode sudah ada!");
    else {
        $db->query("INSERT INTO tb_sub (kode_sub, kode_kriteria, nama_sub, nilai_sub) VALUES ('$kode_sub', '$kode_kriteria', '$nama_sub', '$nilai_sub')");
        redirect_js("index.php?m=sub");
    }
} else if ($mod == 'sub_ubah') {
    $kode_kriteria = $_POST['kode_kriteria'];
    $kode_sub = $_POST['kode_sub'];
    $nama_sub = $_POST['nama_sub'];
    $nilai_sub = $_POST['nilai_sub'];
    if ($kode_kriteria == '' || $kode_sub == '' || $nama_sub == '' || $nilai_sub == '')
        print_msg("Field bertanda * tidak boleh kosong!");
    else {
        $db->query("UPDATE tb_sub SET kode_kriteria='$kode_kriteria', nama_sub='$nama_sub', nilai_sub='$nilai_sub' WHERE kode_sub='$_GET[ID]'");
        redirect_js("index.php?m=sub");
    }
} else if ($act == 'sub_hapus') {
    $db->query("DELETE FROM tb_sub WHERE kode_sub='$_GET[ID]'");
    header("location:index.php?m=sub");
}
