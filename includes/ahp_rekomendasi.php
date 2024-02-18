<?php
function get_baris_total($matriks = array())
{
    $total = array();
    foreach ($matriks as $key => $value) {
        foreach ($value as $k => $v) {
            if (!isset($total[$k]))
                $total[$k] = 0;
            $total[$k] += $v;
        }
    }
    return $total;
}

function normalize($matriks = array(), $total = array())
{

    foreach ($matriks as $key => $value) {
        foreach ($value as $k => $v) {
            $matriks[$key][$k] = $matriks[$key][$k] / $total[$k];
        }
    }
    return $matriks;
}

function get_rata($normal)
{
    $rata = array();
    foreach ($normal as $key => $value) {
        $rata[$key] = array_sum($value) / count($value);
    }
    return $rata;
}

function mmult($matriks = array(), $rata = array())
{
    $arr = array();
    foreach ($matriks as $key => $val) {
        foreach ($val as $k => $v) {
            $arr[$key][$k] = $v * $rata[$k];
        }
    }
    return $arr;
}

function consistency_measure($matriks, $rata)
{
    $matriks = mmult($matriks, $rata);
    foreach ($matriks as $key => $value) {
        $data[$key] = array_sum($value) / $rata[$key];
    }
    return $data;
}
