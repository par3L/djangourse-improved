<?php
function ensureAuthenticated() {
    if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
        // Jika pengguna tidak terautentikasi, arahkan ke halaman login
        header('Location: ../auth.php');
        exit();
    }
}

function ensureRole($allowedRole) {
    // Pastikan sesi berisi role_id
    if (!isset($_SESSION['user']['role_id'])) {
        die("Akses ditolak: Role tidak ditemukan.");
    }

    // Periksa apakah peran sesuai dengan peran yang diizinkan
    if ($_SESSION['user']['role_id'] != $allowedRole) {
        die("Akses ditolak: Anda tidak memiliki izin untuk mengakses halaman ini.");
    }
}

?>