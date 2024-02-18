<?php

class Oreste
{
    public $total;
    function __construct($data, $bobot)
    {
        $this->data = $data;
        $this->bobot = $bobot;
        $this->normal();
        $this->distance_score();
        $this->terbobot();
        $this->total();
        $this->rank();
    }
    function rank()
    {
        $data = $this->total;
        asort($data);
        $no = 1;
        $this->rank = array();
        foreach ($data as $key => $val) {
            $this->rank[$key] = $no++;
        }
    }
    function total()
    {
        foreach ($this->terbobot as $key => $val) {
            $this->total[$key] = array_sum($val);
        }
    }
    function terbobot()
    {
        $total = array_sum($this->bobot);
        foreach ($this->bobot as $key => $val) {
            $this->bobot_normal[$key] = $val / $total;
        }
        $this->terbobot = array();
        foreach ($this->distance_score as $key => $val) {
            foreach ($val as $k => $v) {
                $this->terbobot[$key][$k] = $v * $this->bobot_normal[$k];
            }
        }
    }

    function distance_score()
    {
        $R = 3;
        foreach ($this->normal as $key => $val) {
            $cj = 1;
            foreach ($val as $k => $v) {
                $cja = $v;
                $this->distance_score[$key][$k] = pow(1 / 2 * pow($cja, $R) + 1 / 2 * pow($cj, $R), 1 / $R);
                $cj++;
            }
        }
    }

    function normal()
    {
        $arr = array();
        foreach ($this->data as $key => $val) {
            foreach ($val as $k => $v) {
                $arr[$k][$key] = $v;
            }
        }

        $this->data_rank = array();
        foreach ($arr as $key => $val) {
            $this->data_rank[$key] = rank_q($val);
        }

        $arr2 = array();
        foreach ($this->data_rank as $key => $val) {
            asort($val);
            $rank = 1;
            foreach ($val as $k => $v) {
                $arr2[$key][$v][] = $rank++;
            }
        }

        $arr3 = array();
        foreach ($arr2 as $key => $val) {
            foreach ($val as $k => $v) {
                $arr3[$key][$k] = array_sum($arr2[$key][$k]) / count($arr2[$key][$k]);
            }
        }

        $this->data_rank = transpose($this->data_rank);

        $this->normal = array();
        foreach ($this->data_rank as $key => $val) {
            foreach ($val as $k => $v) {
                $this->normal[$key][$k] = $arr3[$k][$v];
            }
        }
    }
}

function transpose($arr)
{
    $res = array();
    foreach ($arr as $key => $val) {
        foreach ($val as $k => $v) {
            $res[$k][$key] = $v;
        }
        ksort($res[$k]);
    }
    ksort($res);
    return $res;
}

function rank_q($arr)
{
    arsort($arr);
    $rank = 0;
    $temp = -1;
    $i = 1;
    $arr2 = array();
    foreach ($arr as $k => $v) {
        if ($temp == $v) {
        } else {
            $rank = $i;
        }
        $arr2[$k] = $rank;
        $temp = $v;
        $i++;
    }
    return $arr2;
}
