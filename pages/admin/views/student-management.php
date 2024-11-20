<?php

require '../../../utils/database/helper.php';
require '../../../utils/date.php';

$students = fetch(
    "SELECT students.name, credentials.email, credentials.created_at FROM students
    JOIN credentials ON students.credential_id = credentials.id"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Siswa - Admin Djangourse</title>
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    <link rel="stylesheet" href="../css/student-management.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
</head>

<body>
    <div class="container">
        <aside class="sidebar">
            <img src="../../../assets/img/logo-django.png" alt="" width="120px">
            <nav>
                <ul>
                    <li><a href="dashboard.php">
                            <iconify-icon icon="material-symbols:dashboard" class="sidebar-icon"></iconify-icon>Dasbor
                        </a></li>

                    <li><a href="student-management.php" class="sidebar-on">
                            <iconify-icon icon="ph:student" class="sidebar-icon"></iconify-icon>Siswa
                        </a></li>
                    <li><a href="instructor-management.php">
                            <iconify-icon icon="mdi:teacher" class="sidebar-icon"></iconify-icon>Pengajar
                        </a></li>
                    <li><a href="setting.php">
                            <iconify-icon icon="uil:setting" class="sidebar-icon"></iconify-icon>Pengaturan
                        </a></li>
                    <li><a href="../../logout.php">
                            <iconify-icon icon="material-symbols:logout" class="sidebar-icon"></iconify-icon>Keluar
                        </a></li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
            <header class="header">
                <h1>Manajemen Siswa</h1>
            </header>

            <section>
                <h2>Data Siswa</h2>
                <table id="student-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Waktu Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($students) > 0) : ?>
                            <?php foreach ($students as $student) : ?>
                                <tr>
                                    <td><?= $student['name'] ?></td>
                                    <td><?= $student['email'] ?></td>
                                    <td><?= convert($student['created_at']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>

            <div class="divide">
                <section class="koin-purchase-section">
                    <h2>Status Pembelian Koin</h2>
                    <table id="koin-purchase-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Waktu Transaksi</th>
                                <th>Jumlah Koin</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </section>

                <section class="student-count-section">
                    <iconify-icon icon="ph:student"></iconify-icon>
                    <p class="student-counter-title">Jumlah Siswa</p>
                    <p class="student-counter">1</p>
                </section>
            </div>

            <section>
                <h2>Pembelian Kursus</h2>
                <table id="course-purchase-table">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>Pembelian</th>
                            <th>Pengajar</th>
                            <th>Koin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Muhammad Abdal Rizky</td>
                            <td>Kursus HTML<br><span class="purchase-time">5 Oktober 2024 13.25 WITA</span></td>
                            <td>Alsah Manggarai</td>
                            <td>-5 Koin</td>
                        </tr>
                    </tbody>
                </table>
            </section>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script>
    let studentTable = new DataTable('#student-table');
    let koinPurchaseTable = new DataTable('#koin-purchase-table');
    let coursePurchaseTable = new DataTable('#course-purchase-table');
    </script>
</body>

</html>