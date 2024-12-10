<?php

function convertToWita($epoch) {
    date_default_timezone_set('Asia/Makassar');
    $result = date('d-m-Y H.i', $epoch);
    return "$result WITA";
}

function convertToIndonesianDate($date) {
    $months = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $explode = explode('-', $date); // Format: YYYY-MM-DD
    return $explode[2] . ' ' . $months[(int)$explode[1]] . ' ' . $explode[0];
}