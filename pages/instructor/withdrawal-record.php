<?php

require '../../utils/database/helper.php';
require '../../utils/date.php';
require '../../utils/number.php';

session_start();

$instructorId = $_SESSION['user']['id'];

$instructor = fetch(
    "SELECT instructors.name, credentials.email, instructors.date_of_birth, instructors.phone_number, instructors.bio, instructors.profile_img, instructors.balance, instructors.preferred_withdrawal_method FROM instructors
    JOIN credentials ON instructors.credential_id = credentials.id
    WHERE instructors.id = $instructorId")[0];

$courses = fetch("SELECT * FROM courses WHERE instructor_id = $instructorId");

$withdrawal_requests = fetch(
    "SELECT * FROM withdrawal_requests WHERE instructor_id = $instructorId ORDER BY created_at DESC");

if (isset($_POST["submit"])){
    $amount = $_POST["amount"];
    if ($amount < 50000) {
        echo "<script>alert('Jumlah penarikan minimal Rp50.000');location.href='withdrawal-record.php'</script>";
        return;
    }
    if ($amount > $instructor['balance']) {
        echo "<script>alert('Saldo tidak mencukupi');location.href='withdrawal-record.php'</script>";
        return;
    }
    $payment_method = $instructor['preferred_withdrawal_method'];
    $status = 'pending';
    $datetime = time();
    $sql = execDML(
        "INSERT INTO withdrawal_requests (instructor_id, created_at, amount, payment_method, status) VALUES ($instructorId, '$datetime',$amount, '$payment_method', '$status');"
    );
    header("Location: withdrawal-record.php");
}   

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Pengajar - Djangourse</title>
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
    @import url('../style.css');

    body {
        background-color: #f8f9fa;
        color: #333;
    }

    .container {
        display: grid;
        grid-template-rows: 60px auto;
        grid-template-columns: 250px 1fr;
        grid-template-areas:
            "navbar navbar"
            "sidebar main";
        width: 100%;
        min-height: 100vh;
    }

    @media (max-width: 768px) {
        .container {
            grid-template-columns: 1fr;
            grid-template-areas:
                "navbar"
                "main";
        }

        .sidebar {
            position: fixed;
            left: -250px;
            top: 60px;
            height: 100%;
            background-color: #ffffff;
            width: 250px;
            transition: all 0.3s ease-in-out;
            z-index: 1000;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar.open {
            left: 0;
        }

        .navbar .menu {
            display: none;
        }
    }

    /* Navbar */
    .navbar {
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 4rem;
        background-color: #245044;
        /* height: 60px; */
    }

    .navbar nav {
        flex: 1;
        display: flex;

        justify-content: center;
        align-items: center;

    }

    .navbar ul {
        display: flex;
        list-style: none;
        gap: 30px;
    }

    .navbar ul li {
        margin-left: 20px;
    }

    .navbar a {
        text-decoration: none;
        color: #fff;
        transition: color 0.3s ease, border-bottom 0.3s ease;
    }

    .navbar a:hover {
        color: #A1D1B6;
    }

    .navbar nav a:hover {
        border-bottom: 2px solid #A1D1B6;
    }

    .hamburger {
        display: none;
        font-size: 24px;
        color: #fff;
        cursor: pointer;
    }

    @media (max-width: 768px) {
        .hamburger {
            display: block;
        }

        .navbar ul {
            display: none;
        }

        .sidebar {
            position: fixed;
            left: -250px;
            top: 0;
            height: 100%;
            background-color: #ffffff;
            width: 250px;
            transition: all 0.3s ease-in-out;
            z-index: 1000;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar.open {
            left: 0;
        }
    }

    /* Sidebar */
    .sidebar {
        grid-area: sidebar;
        background-color: #ffffff;
        padding: 20px;
        border-right: 1px solid #ddd;
        transition: all 0.3s ease-in-out;
        margin-top: 20px;
    }

    .sidebar .profile {
        text-align: center;
        margin-bottom: 30px;
    }

    .sidebar .profile img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 2px solid #ccc;
        margin-bottom: 10px;
        object-fit: cover;
    }

    .sidebar .profile h3 {
        font-size: 16px;
        color: #333;
    }

    .sidebar .profile p {
        font-size: 14px;
        color: #888;
    }

    .sidebar .add-course {
        background-color: #245044;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        margin-top: 20px;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none;
        display: inline-block;
    }

    .sidebar .add-course:hover {
        background-color: #2C8577;
        color: white;
    }

    .sidebar .menu ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    /* Sidebar section title */
    .sidebar .menu ul .section-title {
        font-weight: bold;
        color: #333;
        font-size: 14px;
        margin: 15px 0 10px 0;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .sidebar .menu ul li a {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: #333;
        font-size: 14px;
        padding: 10px 15px;
        border-radius: 5px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .sidebar .menu ul li a.active {
        background-color: #2C8577;
        color: white;
    }

    /* Hover effect */
    .sidebar .menu ul li a:hover {
        background-color: #2C8577;
        color: white;
    }

    /* Icon styling */
    .sidebar .menu ul li a i {
        font-size: 16px;
        color: #888;
        transition: color 0.3s ease;
    }

    .sidebar .menu ul li a:hover i {
        color: white;
    }


    /* Main Content */
    .main-content {
        grid-area: main;
        padding: 20px;
        margin-top: 20px;
    }

    .main-content .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        background: radial-gradient(closest-side,
                rgba(33, 108, 104, 1) 0%,
                rgba(217, 217, 217, 1) 0.7%,
                rgba(138, 183, 184, 1) 33.5%,
                rgba(30, 136, 140, 1) 78.2%,
                rgba(89, 162, 164, 1) 100%);
        padding: 50px;
    }

    .main-content .header h1 {
        font-size: 24px;
        color: #fff;
    }

    .main-content .header .breadcrumb {
        font-size: 14px;
        color: #fff;
    }

    .stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stats .card {
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .stats .card h4 {
        color: #888;
        font-size: 14px;
    }

    .stats .card p {
        color: #333;
        font-size: 20px;
        margin-top: 10px;
    }

    /* Table Section */
    .table-section {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .table-section h2 {
        margin-bottom: 20px;
        font-size: 18px;
        color: #1e5567;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th,
    table td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
        font-size: 14px;
    }

    table th {
        background-color: #1e5567;
        color: white;
    }

    table tr:hover {
        background-color: #f9f9f9;
    }

    .navbar-info-dropdown {
        position: absolute;
        top: 80px;
        right: 48px;
        width: 220px;
        padding: 16px;
        display: block;
        background-color: #005955;
    }

    .navbar-info-dropdown-content {
        display: flex;
        padding: 16px;
        gap: 16px;
    }

    .navbar-info-dropdown iconify-icon {
        font-size: 24px;
    }

    .navbar-cred {
        display: flex;
        align-items: center;
        gap: 12px;
        color: white;
    }

    .hide {
        display: none;
    }

    .main-content {
        grid-area: main;
        padding: 20px;
        margin-top: 20px;
        overflow-y: auto;
        height: calc(100vh - 60px);
    }

    .main-content .judul {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        background: radial-gradient(closest-side, rgba(33, 108, 104, 1) 0%, rgba(217, 217, 217, 1) 0.7%, rgba(138, 183, 184, 1) 33.5%, rgba(30, 136, 140, 1) 78.2%, rgba(89, 162, 164, 1) 100%);
        padding: 50px;
    }

    .main-content .judul h1 {
        font-size: 24px;
        color: #fff;
    }

    .main-content .judul .breadcrumb {
        font-size: 14px;
        color: #fff;
    }

    /* Right Content */

    .sub-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background-color: #156D70;
        color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .sub-left {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .sub-left .icon {
        font-size: 48px;
        color: #ffffff;
    }

    .sub-left h5 {
        font-size: 16px;
        color: #eaeaea;
        margin-bottom: 5px;
    }

    .sub-left h3 {
        font-size: 24px;
        color: #ffffff;
    }

    .sub-right .btn-primary {
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        color: white;
        background-color: #28a745;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .sub-right .btn-primary:hover {
        background-color: #218838;
        transform: scale(1.05);

    }

    /* Table Section */
    .table-record {
        margin-top: 20px;
    }

    .header-table h2 {
        font-size: 20px;
        margin-bottom: 10px;
        color: #555;
        font-weight: bold;
    }

    .withdrawal-table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 8px;
        overflow: hidden;
        background-color: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .withdrawal-table thead {
        background-color: #156D70;
        color: white;
        text-align: left;
    }

    .withdrawal-table thead th {
        padding: 15px;
        font-size: 16px;
        font-weight: bold;
    }

    .withdrawal-table tbody td {
        padding: 15px;
        font-size: 14px;
        color: #555;
        border-bottom: 1px solid #eaeaea;
    }

    .withdrawal-table tbody tr:hover {
        background-color: #f5f5f5;
    }

    /* Status Buttons */
    .withdrawal-table .status {
        padding: 5px 15px;
        border-radius: 5px;
        font-weight: bold;
        color: white;
        font-size: 14px;
        text-align: center;
    }

    .withdrawal-table .status.selesai {
        background-color: #28a745;
        border-style: none;
    }

    .withdrawal-table .status.selesai:hover {
        background-color: #218838;
    }

    .withdrawal-table .status.pending {
        background-color: #ffc107;
        color: #333;
        border-style: none;
    }

    .withdrawal-table .status.pending:hover {
        background-color: #bd8f07;
    }

    .withdrawal-table .status.gagal {
        background-color: #dc3545;
    }

    .withdrawal-table .status.gagal:hover {
        background-color: #92222d;
    }

    /* Modal Section */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }



    /* Modal Content - Tetap di tengah */
    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px 30px;
        border-radius: 12px;
        width: 40%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        position: relative;
        text-align: center;
        font-family: 'Arial', sans-serif;
    }


    .close-btn {
        position: absolute;
        top: 10px;
        right: 20px;
        font-size: 24px;
        cursor: pointer;
    }



    .modal-content h2 {
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }

    .modal-content p {
        font-size: 14px;
        color: #555;
        margin-bottom: 20px;
    }

    .modal-details {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .modal-details .detail span {
        font-size: 14px;
        color: #666;
    }

    .modal-details .detail p {
        font-size: 16px;
        font-weight: bold;
        color: #333;
    }

    #withdrawalForm input {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
    }

    .note {
        font-size: 12px;
        color: #888;
        text-align: left;
        margin-bottom: 20px;
    }

    .modal-actions {
        display: flex;
        justify-content: space-between;
    }

    .modal-actions .btn {
        padding: 10px 20px;
        border-radius: 8px;
        color: white;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.3s;
        border: 1px solid black;
    }

    .modal-actions .btn-submit {
        background-color: #28a745;
    }

    .modal-actions .btn-cancel {
        background-color: #dc3545;
    }

    .modal-actions .btn:hover {
        opacity: 0.9;
    }

    .close-btn:hover {
        color: #ff4d4d;
    }

    footer {
        background-image: url('../../assets/img/footer.png');
        background-size: cover;
        background-position: center;
        color: #fff;
        padding: 2rem 4rem;
        display: flex;
        justify-content: space-between;
    }

    .footer-content {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }

    .footer-content .logo-section p {
        padding-left: 10px;
        margin-top: 10px;
    }

    .footer-logo {
        width: 100px;
    }

    .links-section a {
        text-decoration: none;
        color: #fff;
        transition: color 0.3s ease, border-bottom 0.3s ease;
    }

    .links-section a:hover {
        color: #A1D1B6;
        border-bottom: 2px solid #A1D1B6;
    }

    .links-section ul {
        list-style: none;
        margin-top: 20px;
        padding-left: 0;
    }

    .links-section ul li {
        margin: 20px 0;
    }

    .contact-section p {
        margin: 20px 0;
    }

    .contact-section i {
        margin-right: 5px;
    }

    .contact-section a {
        text-decoration: none;
        color: #fff;
        transition: color 0.3s ease;
    }

    .contact-section a:hover {
        color: #A1D1B6;
        text-decoration: underline;
    }

    .btn-primary.disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }

    .btn-primary.disabled:hover {
        background-color: #ccc;
    }
    </style>
</head>

<body>
    <div class="container">
        <!-- Navbar -->
        <header class="navbar">
            <img src="../../assets/img/logo-django.png" alt="Logo" class="logo" style="width: 110px;">
            <nav>
                <ul id="navbar-menu">
                    <li><a href="../../index.php">Beranda</a></li>
                    <li><a href="../course-list.php">Kursus</a></li>
                    <li><a href="../how-to-use.php">Cara Penggunaan</a></li>
                </ul>
            </nav>
            <div class="navbar-info">
                <div class="navbar-cred">
                    <p>Hai, <?= $_SESSION['user']['name'] ?></p>
                    <iconify-icon icon="iconamoon:arrow-down-2-bold" id="btn-dropdown"></iconify-icon>
                </div>

                <?php if ($_SESSION['user']['role_id'] == 2): ?>
                <div class="navbar-info-dropdown hide" id="navbar-info-dropdown">
                    <a href="dashboard.php">
                        <div class="navbar-info-dropdown-content">
                            <iconify-icon icon="iconoir:profile-circle"></iconify-icon>
                            <span>Dasbor</span>
                        </div>
                    </a>
                    <a href="../logout.php">
                        <div class="navbar-info-dropdown-content">
                            <iconify-icon icon="material-symbols:logout" class="sidebar-icon"></iconify-icon>
                            <span>Keluar</span>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
            </div>
            <div class="hamburger" onclick="toggleSidebar()">&#9776;</div>
        </header>
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="profile">
                <img id="profile-pic"
                    src="<?= $instructor['profile_img'] ? 'uploads/' . $instructor['profile_img'] : 'https://artikel.rumah123.com/wp-content/uploads/sites/41/2023/09/12160753/gambar-foto-profil-whatsapp-kosong.jpg' ?>"
                    alt="Profile Picture">
                <h3><?= $_SESSION['user']['name'] ?></h3>
                <p>Pengajar</p>
                <a href="add-course.php" class="add-course">Tambah Kursus Baru</a>
            </div>
            <div class="menu">
                <ul>
                    <li class="section-title">Dasbor</li>
                    <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dasbor</a></li>
                    <li><a href="profile.php"><i class="fas fa-user"></i> Profil Saya</a></li>

                    <li class="section-title">Pengajar</li>
                    <li><a href="my-courses.php"><i class="fas fa-chalkboard-teacher"></i> Kursus Saya</a></li>
                    <li><a href="withdrawal-record.php" class="active"><i class="fas fa-wallet"
                                style="color: white;"></i> Tarik Saldo</a></li>

                    <li class="section-title">Pengaturan Akun</li>
                    <li><a href="edit-profile.php"><i class="fas fa-cogs"></i> Edit Profil</a></li>
                    <li><a href="change-password.php"><i class="fas fa-key"></i> Ubah Kata Sandi</a></li>
                    <li><a href="withdrawal-setting.php"><i class="fas fa-money-bill-wave"></i> Penarikan</a></li>
                    <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
                </ul>
            </div>
        </aside>
        <main class="main-content">
            <div class="judul">
                <h1>Tarik Saldo</h1>
                <span class="breadcrumb">Beranda > Tarik Saldo</span>
            </div>
            <div class="right-content">
                <h1>Penarikan</h1>
                <div class="sub-header">
                    <div class="sub-left">
                        <div class="icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="text">
                            <h5>Saldo Saat ini</h5>
                            <h3>Rp<?= formatAsCurrency($instructor['balance']) ?></h3>
                        </div>
                    </div>
                    <div class="sub-right">
                        <button id="withdrawalBtn" class="btn btn-primary <?= ($instructor['balance'] < 50000) ? 'disabled':'' ?>">
                            Permintaan Penarikan
                        </button>
                    </div>
                </div>

                <div class="table-record">
                    <div class="header-table">
                        <h2>Riwayat Penarikan</h2>
                    </div>
                    <table class="withdrawal-table">
                        <thead>
                            <tr>
                                <th>Metode Penarikan</th>
                                <th>Diminta Pada</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($withdrawal_requests)): ?>
                            <?php foreach ($withdrawal_requests as $w): ?>
                            <tr>
                                <?php if ($w['payment_method'] == 'paypal'): ?>
                                <td>
                                    <i class="fab fa-paypal"></i> PayPal<br />
                                    <?= $instructor['email'] ?>
                                </td>
                                <?php elseif ($w['payment_method'] == 'dana'): ?>
                                <td>
                                    <i class="fas fa-wallet"></i> DANA<br />
                                    <?= $instructor['phone_number'] ?>
                                </td>
                                <?php endif; ?>
                                <td> <?= htmlspecialchars(convertToWita($w['created_at'])) ?></td>
                                <td>Rp<?= formatAsCurrency($w["amount"]) ?></td>
                                <td><button class="status selesai"><?= $w["status"] ?></button></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align:center">Belum ada data.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal -->
    <div id="withdrawalModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Permintaan Penarikan</h2>
            <p>Silakan periksa notifikasi transaksi Anda pada metode penarikan yang terhubung</p>
            <div class="modal-details">
                <div class="detail">
                    <span>Saldo Anda</span>
                    <p>Rp<?= formatAsCurrency($instructor['balance']) ?></p>
                </div>
                <div class="detail">
                    <span>Terpilih Pembayaran</span>
                    <p><?= ($instructor['preferred_withdrawal_method'] == 'paypal') ? 'PayPal': 'DANA' ?></p>
                </div>
            </div>
            <form action="withdrawal-record.php" method="post" enctype="multipart/form-data" id="withdrawalForm">
                <label for="amount">Jumlah</label>
                <input type="number" id="amount" name="amount" placeholder="Rp" min="50000" required />
                <div class="note">
                    <p><span>&#9432;</span> Minimum tarik Rp50.000</p>
                </div>
                <div class="modal-actions">
                    <button type="submit" name='submit' class="btn btn-submit">Kirim Permintaan</button>
                </div>
            </form>
        </div>
    </div>
    <footer>
        <div class="footer-content">
            <div class="logo-section">
                <img src="../../assets/img/logo-django.png" alt="Logo" class="footer-logo">
                <p>Bergabunglah bersama kami untuk menguasai<br> berbagai keahlian
                    dibidang teknologi dan membuka<br>peluang karier di dunia teknologi
                    yang terus berkembang.<br><br> Kami menyediakan kursus
                    berkualitas yang membantu <br> kamu berkembang dari pemula
                    hingga ahli.</p>
                <div class="hak-cipta">
                    <p>© 2024 Django Course. Semua hak cipta dilindungi.</p>
                </div>
            </div>
            <div class="links-section">
                <h3>Instruktur</h3>
                <ul>
                    <li><a href="#">Profil</a></li>
                    <li><a href="#">Login</a></li>
                    <li><a href="#">Register</a></li>
                    <li><a href="#">Instructor</a></li>
                    <li><a href="#">Dashboard</a></li>
                </ul>
            </div>
            <div class="links-section">
                <h3>Siswa</h3>
                <ul>
                    <li><a href="#">Profil</a></li>
                    <li><a href="#">Jelajahi Kursus</a></li>
                    <li><a href="#">Wishlist Kursus</a></li>
                    <li><a href="#">Student</a></li>
                    <li><a href="#">Dashboard</a></li>
                </ul>
            </div>
            <div class="contact-section">
                <h3>Alamat</h3>
                <p>
                    <i class="fas fa-map-marker-alt"></i>
                    <a href="https://www.google.com/maps?q=Jalan+Gubeng+Surabaya" target="_blank">Jalan Gubeng,
                        Surabaya</a>
                </p>
                <p>
                    <i class="fas fa-envelope"></i>
                    <a href="mailto:info@djangourse.com">info@dingcourse.com</a>
                </p>
                <p>
                    <i class="fas fa-phone-alt"></i>
                    <a href="tel:+62123456789">+62 123 456 789</a>
                </p>
            </div>

        </div>
    </footer>
    <script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('open');

        const navbarMenu = document.querySelector('.navbar ul');
        const sidebarMenu = document.querySelector('.sidebar .menu ul');

        if (window.innerWidth <= 768) {
            if (sidebar.classList.contains('open')) {

                sidebarMenu.prepend(navbarMenu);
                sidebarMenu.appendChild(navbarMenu);
            } else {
                document.querySelector('.navbar nav').appendChild(navbarMenu);
            }
        }
    }
    </script>
    <?php
    if ($instructor['balance'] >= 50000) {
        echo "<script>
    const withdrawalBtn = document.getElementById('withdrawalBtn');

    withdrawalBtn.addEventListener('click', () => {
        withdrawalModal.style.display = 'block';
    });
    </script>";
    }
    ?>
    <script src="../../navbar.js"></script>
    <script src="./scripts/withdrawal-record.js"></script>
</body>

</html>