<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengajar - Admin Djangourse</title>
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    <link rel="stylesheet" href="../css/instructor-management.css">
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
                    <li><a href="student-management.php">
                            <iconify-icon icon="ph:student" class="sidebar-icon"></iconify-icon>Siswa
                        </a></li>
                    <li><a href="instructor-management.php" class="sidebar-on">
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
                <h1>Manajemen Pengajar</h1>
            </header>

            <section class="instructor-count-section">
                <div class="instructor-count-content">
                    <iconify-icon icon="mdi:teacher" class="instructor-count-icon"></iconify-icon>
                    <p class="text-wrapper">Jumlah Pengajar</p>
                    <p class="text-counter">1</p>
                </div>
            </section>

            <section>
                <h2>Data Pengajar</h2>
                <table id="instructor-data-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Kursus Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Muhammad Abdal Rizky</td>
                            <td>aabdal.rizky@gmail.com</td>
                            <td>3</td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section class="withdraw-approval-section">
                <h2>Persetujuan Penarikan</h2>
                <div class="table-box">
                    <p style="display: none;">Belum ada permintaan</p>
                    <table class="common-table">
                        <tr>
                            <td>Nama</td>
                            <td>Jumlah</td>
                            <td>Tujuan Pembayaran</td>
                            <td>Aksi</td>
                        </tr>
                        <tr>
                            <td>ff</td>
                            <td>ff</td>
                            <td>Paypal</td>
                            <td>
                                <a href="#" class="btn-approve">
                                    <iconify-icon icon="si:check-fill"></iconify-icon>
                                    <span>Setujui</span>
                                </a>
                                <a href="#" class="btn-reject">
                                    <iconify-icon icon="streamline:delete-1-solid"></iconify-icon>
                                    <span>Tolak</span>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </section>

            <section class="withdraw-approval-section">
                <h2>Persetujuan Penambahan Kursus Baru</h2>
                <div class="table-box">
                    <p style="display: none;">Belum ada permintaan</p>
                    <table class="common-table">
                        <tr>
                            <td>Nama Kursus</td>
                            <td>Kategori</td>
                            <td>Tingkat Kesulitan</td>
                            <td>Pengajar</td>
                            <td>Harga</td>
                            <td>Aksi</td>
                        </tr>
                        <tr>
                            <td>Kursus HTML</td>
                            <td>Web Programming</td>
                            <td>Mudah</td>
                            <td>Muhammad Abdal Rizky</td>
                            <td>10.000</td>
                            <td>
                                <a href="#" class="btn-approve">
                                    <iconify-icon icon="si:check-fill"></iconify-icon>
                                    <span>Setujui</span>
                                </a>
                                <a href="#" class="btn-reject">
                                    <iconify-icon icon="streamline:delete-1-solid"></iconify-icon>
                                    <span>Tolak</span>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </section>

        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script>
    let instructorTable = new DataTable('#instructor-data-table');
    </script>
</body>

</html>