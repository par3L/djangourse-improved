<?php

require "connection.php";

// Menangani query SELECT
function fetch($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
    }
    return $rows;
}

// Menangani query INSERT, UPDATE, DELETE
function execDML($query) {
    global $conn;
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}