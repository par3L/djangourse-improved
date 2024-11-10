<?php

function convert($epoch) {
    date_default_timezone_set('Asia/Makassar');
    $result = date('d-m-Y H.i', $epoch);
    return "$result WITA";
}