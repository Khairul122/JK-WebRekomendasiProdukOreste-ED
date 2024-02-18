<?php
session_start();

include 'config.php';
include 'includes/db.php';
$db = new DB($config['server'], $config['username'], $config['password'], $config['database_name']);
include 'includes/oreste.php';
include 'includes/SimpleImage.php';

$nRI = array(
    1 => 0,
    2 => 0,
    3 => 0.58,
    4 => 0.9,
    5 => 1.12,
    6 => 1.24,
    7 => 1.32,
    8 => 1.41,
    9 => 1.46,
    10 => 1.49
);

function _post($key, $val = null)
{
    global $_POST;
    if (isset($_POST[$key]))
        return $_POST[$key];
    else
        return $val;
}

function _get($key, $val = null)
{
    global $_GET;
    if (isset($_GET[$key]))
        return $_GET[$key];
    else
        return $val;
}

function _session($key, $val = null)
{
    global $_SESSION;
    if (isset($_SESSION[$key]))
        return $_SESSION[$key];
    else
        return $val;
}

$mod = _get('m');
$act = _get('act');

$rows = $db->get_results("SELECT * FROM tb_alternatif ORDER BY kode_alternatif");
foreach ($rows as $row) {
    $ALTERNATIF[$row->kode_alternatif] = $row;
}

$rows = $db->get_results("SELECT * FROM tb_sub ORDER BY kode_sub");
$SUB = array();
$KRITERIA_SUB = array();
foreach ($rows as $row) {
    $SUB[$row->kode_sub] = $row;
    $KRITERIA_SUB[$row->kode_kriteria][$row->kode_sub] = $row;
}

$rows = $db->get_results("SELECT * FROM tb_kriteria ORDER BY kode_kriteria");
foreach ($rows as $row) {
    $KRITERIA[$row->kode_kriteria] = $row;
    $target = $row->kode_kriteria;
}

DEFINE('ABSPATH', dirname(__FILE__) . '/');
function get_image_url($filename, $pref_f = "", $pref_d = "")
{
    $location = "assets/img/{$pref_f}{$filename}";

    $file = ABSPATH . $location;
    if (is_file($file))
        return $pref_d . $location;
    else
        return $pref_d . "assets/img/no_image.png";
}

function get_rel_alternatif()
{
    global $db;
    $arr = array();
    $rows = $db->get_results("SELECT * FROM tb_rel_alternatif ORDER BY kode_alternatif, kode_kriteria");
    foreach ($rows as $row) {
        $arr[$row->kode_alternatif][$row->kode_kriteria] = $row->kode_sub;
    }
    return $arr;
}

function get_kriteria_option($selected)
{
    global $KRITERIA;
    $a = '';
    foreach ($KRITERIA as $key => $val) {
        if ($key == $selected)
            $a .= "<option value='$key' selected>$key - $val->nama_kriteria</option>";
        else
            $a .= "<option value='$key'>$key - $val->nama_kriteria</option>";
    }
    return $a;
}

function set_value($key = null, $default = null)
{
    global $_POST;
    if (isset($_POST[$key]))
        return $_POST[$key];

    if (isset($_GET[$key]))
        return $_GET[$key];

    return $default;
}

function kode_oto($field, $table, $prefix, $length)
{
    global $db;
    $var = (string)$db->get_var("SELECT $field FROM $table WHERE $field REGEXP '{$prefix}[0-9]{{$length}}' ORDER BY $field DESC");
    if ($var) {
        return $prefix . substr(str_repeat('0', $length) . (substr($var, -$length) + 1), -$length);
    } else {
        return $prefix . str_repeat('0', $length - 1) . 1;
    }
}

function esc_field($str)
{
    return addslashes($str);
}

function redirect_js($url)
{
    echo '<script type="text/javascript">window.location.replace("' . $url . '");</script>';
}

function alert($url)
{
    echo '<script type="text/javascript">alert("' . $url . '");</script>';
}

function set_msg($msg, $type = 'success')
{
    $_SESSION['message'] = ['msg' => $msg, 'type' => $type];
}

function show_msg()
{
    if (_session('message'))
        print_msg($_SESSION['message']['msg'], $_SESSION['message']['type']);
    unset($_SESSION['message']);
}

function print_msg($msg, $type = 'danger')
{
    echo ('<div class="alert alert-' . $type . ' alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $msg . '</div>');
}

function parse_file_name($file_name)
{
    $x = strtolower($file_name);
    $x = str_replace(array(' '), '-', $x);
    return $x;
}

function delete_image($ID)
{
    global $db;
    $gambar = $db->get_var("SELECT gambar FROM tb_alternatif WHERE kode_alternatif='$ID'");
    if (!empty($gambar)) {
        $gambar1 = "assets/img/alternatif/$gambar";
        $gambar2 = "assets/img/alternatif/small_$gambar";
        if (file_exists($gambar1) && is_file($gambar1))
            unlink($gambar1);
        if (file_exists($gambar2) && is_file($gambar2))
            unlink($gambar2);
    }
}

function get_nilai_option($selected = '')
{
    $nilai = array(
        '1' => 'Sama penting dengan',
        '2' => 'Mendekati sedikit lebih penting dari',
        '3' => 'Sedikit lebih penting dari',
        '4' => 'Mendekati lebih penting dari',
        '5' => 'Lebih penting dari',
        '6' => 'Mendekati sangat penting dari',
        '7' => 'Sangat penting dari',
        '8' => 'Mendekati mutlak dari',
        '9' => 'Mutlak sangat penting dari',
    );
    $a = '';
    foreach ($nilai as $key => $value) {
        if ($selected == $key)
            $a .= "<option value='$key' selected>$key - $value</option>";
        else
            $a .= "<option value='$key'>$key - $value</option>";
    }
    return $a;
}

function dd($arr)
{
    echo '<pre>' . print_r($arr, 1) . '</pre>';
}

function get_sub_option($selected = '', $kode_kriteria)
{
    global $db;
    $where = "WHERE kode_kriteria='$kode_kriteria'";
    $rows = $db->get_results("SELECT kode_sub, nama_sub FROM tb_sub $where ORDER BY kode_sub");
    $a = '';
    foreach ($rows as $row) {
        if ($row->kode_sub == $selected)
            $a .= "<option value='$row->kode_sub' selected>$row->nama_sub</option>";
        else
            $a .= "<option value='$row->kode_sub'>$row->nama_sub</option>";
    }
    return $a;
}


function get_rank($array)
{
    $data = $array;
    arsort($data);
    $no = 1;
    $new = array();
    foreach ($data as $key => $value) {
        $new[$key] = $no++;
    }
    return $new;
}

function enter2br($str)
{
    return str_replace("\n", '<br />', $str);
}
function angka($numb)
{
    return number_format($numb, 0, ',', '.');
}
