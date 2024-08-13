<?php

use App\Models\Pembelian;
use App\Models\Penjualan;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of helpers
 *
 * @author 
 */
function setActive($path, $active = 'active') {
    return call_user_func_array('Request::is', (array)$path) ? $active : '';
}

function setShow($path, $block = 'block') {
    return call_user_func_array('Request::is', (array)$path) ? $block : '';
}

function formatDate($array) {
    $string = date('Y-m-d', strtotime($array));
    return $string;
}

if (! function_exists('num_row')) {
	function num_row($page, $limit) {
		if (is_null($page)) {
			$page = 1;
		}

		$num = ($page * $limit) - ($limit - 1);
		return $num;
	}
}
function format_rupiah($x) {
if(is_nan($x)) {
  $x = 0;
} 

if(is_infinite($x)) {
  $x = 0;
}
return number_format($x, 0, ",", ".");

}

function tgl_indo($tanggal){
    $bulan = array (
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    //return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    return $pecahkan[2] . '/' . $pecahkan[1]  . '/' . $pecahkan[0];
}


if (!function_exists('getTotalQtyPembelian')) {
    function getTotalQtyPembelian($perhiasanId)
    {
        // Gantilah dengan query sesuai dengan model dan relasi di aplikasi Anda
        return Pembelian::where('perhiasan_id', $perhiasanId)->sum('qty');
    }
}

if (!function_exists('getTotalQtyPenjualan')) {
    function getTotalQtyPenjualan($perhiasanId)
    {
        // Gantilah dengan query sesuai dengan model dan relasi di aplikasi Anda
        return Penjualan::where('perhiasan_id', $perhiasanId)->sum('qty');
    }
}

